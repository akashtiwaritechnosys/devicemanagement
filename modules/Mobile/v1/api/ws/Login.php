<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Mobile_WS_Login extends Mobile_WS_Controller {

	function requireLogin() {
		return false;
	}

	function process(Mobile_API_Request $request) {
		$response = new Mobile_API_Response();
		$username = $request->get('username');
		$password = $request->get('password');

		// Basic checks
		if (empty($username)) {
			return $this->errorResponse($response, 1501, 'Username Is Missing');
		}
		if (empty($password)) {
			return $this->errorResponse($response, 1501, 'Password Is Missing');
		}

		// Check module availability
		if (vtlib_isModuleActive('Mobile') === false) {
			return $this->errorResponse($response, 1501, 'Service not available');
		}

		$current_user = CRMEntity::getInstance('Users');
		$current_user->column_fields['user_name'] = $username;

		// Authenticate
		if (!$current_user->doLogin($password)) {
			return $this->errorResponse($response, 1210, 'Authentication Failed');
		}

		$current_user->id = $current_user->retrieve_user_id($username);
		$current_user->retrieveCurrentUserInfoFromFile($current_user->id);
		$this->setActiveUser($current_user);

		// JWT Implementation
		require __DIR__ . DIRECTORY_SEPARATOR .'autoload.php';
		// $key = "ONSGVGFDKNBXVDAWTYSVSCDX".$current_user->user_password . $current_user->user_name;
		$key = $this->generateJwtKey($username);
		$payload = [ 'userid' => $current_user->id ];
		$jwt = JWT::encode($payload, $key, 'HS256');

		// First check in ServiceEngineer
		$data = $this->getUserDetailsBasedOnEmployeeModule($username);


		if ($data === false) {
			// If not found, fallback to Account
			$data = $this->getUserDetailsBasedOnAccountModule($username);
			if ($data === false) {
				return $this->errorResponse($response, 1501, 'Not Able To Find User Details in ServiceEngineer or Accounts');
			}

			// Build Account login response
			$result = $this->buildAccountResponse($data, $jwt, $username, $password, $current_user);
			$response->setApiSucessMessage('Successfully Logged In');
			$response->setResult($result);
			return $this->postProcess($response);
		}

		// ServiceEngineer flow
		global $adb;
		$sql = 'SELECT serviceengineerid 
		        FROM vtiger_serviceengineer 
		        INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_serviceengineer.serviceengineerid
		        WHERE badge_no = ? AND vtiger_crmentity.deleted = 0 
		        ORDER BY serviceengineerid DESC LIMIT 1';
		$sqlResult = $adb->pquery($sql, [$username]);
		$dataRow = $adb->fetchByAssoc($sqlResult, 0);

		$recordModel = Vtiger_Record_Model::getInstanceById($dataRow['serviceengineerid'], 'ServiceEngineer');
		$emData = $recordModel->getData();
		unset($emData['confirm_password'], $emData['user_password']);

		$role = $data['cust_role'];
		if ($emData['office'] == 'Production Division') {
			$role = 'Divisonal Service Manager';
		} elseif ($emData['office'] == 'Service Centre' && $data['cust_role'] == 'Service Manager') {
			$role = 'Service Centre Manager';
		}

		$emData['imagename'] = $this->getUserImageDetails($current_user->id);

		$result = [
			'assign_user_id'   => $current_user->id,
			'usercreatedid'    => $data['serviceengineerid'],
			'usertype'         => "EPSILONUSER",
			'access_token'     => $jwt,
			'username'         => $username,
			'password'         => $password,
			'usermobilenumber' => $data['phone'],
			"userRole"         => $data['cust_role'],
			"userRoleUnified"  => $role,
			'useruniqeid'      => $current_user->id,
			'timestamp'        => (new DateTime())->getTimestamp(),
			'message'          => 'Thank You Have Been Login Succesfully',
			'profileInfo'      => $emData
		];

		include_once('include/utils/GeneralUtils.php');
		$plant = getCurrentUserPlantDetailsFromMobileLogin($username);
		if ($plant) {
			$tabId = Mobile_WS_Utils::getEntityModuleWSId('MaintenancePlant');
			$result['plant_name'] = $tabId . 'x' . $plant;
			$result['plant_name_label'] = decode_html(Vtiger_Functions::getCRMRecordLabel($plant));
		}

		$response->setApiSucessMessage('Successfully Logged In');
		$response->setResult($result);
		return $this->postProcess($response);
	}


	private function errorResponse($response, $code, $message) {
		$response->setError($code, $message);
		return $response;
	}
	
	private function generateJwtKey($username) {
		global $adb;
		$userQuery = "SELECT user_password FROM vtiger_users WHERE user_name = ? AND status = 'Active'";
		$userResult = $adb->pquery($userQuery, [$username]);
		
		if ($adb->num_rows($userResult) == 0) {
			throw new Exception("User not found for JWT generation");
		}
		
		$currentPassword = $adb->query_result($userResult, 0, 'user_password');
		return "ONSGVGFDKNBXVDAWTYSVSCDX" . $currentPassword . $username;
	}

	/** Build response for Account login */
	private function buildAccountResponse($data, $jwt, $username, $password, $current_user) {
		return [
			'assign_user_id'   => $current_user->id,
			'usercreatedid'    => $data['accountid'],
			'usertype'         => "BIZUSER",
			'access_token'     => $jwt,
			'username'         => $username,
			'password'         => $password,
			'usermobilenumber' => $data['phone'],
			"userRole"         => "Customer",
			"userRoleUnified"  => "Customer",
			'useruniqeid'      => $current_user->id,
			'timestamp'        => (new DateTime())->getTimestamp(),
			'message'          => 'Thank You, You Have Been Logged In Successfully',
			'profileInfo'      => $data
		];
	}

	
	protected static $userURLCache = [];

	public function getUserImageDetails($recordId) {
		if (empty($recordId)) {
			return NULL;
		}
		global $site_URL_NonHttp;
		$db = PearDatabase::getInstance();
		if (!self::$userURLCache[$recordId]) {
			$query = "SELECT vtiger_attachments.attachmentsid, vtiger_attachments.path, 
						vtiger_attachments.name, vtiger_attachments.storedname 
					  FROM vtiger_attachments
					  LEFT JOIN vtiger_salesmanattachmentsrel 
					  ON vtiger_salesmanattachmentsrel.attachmentsid = vtiger_attachments.attachmentsid
					  WHERE vtiger_salesmanattachmentsrel.smid=? 
					  ORDER BY attachmentsid DESC LIMIT 1";
			$result = $db->pquery($query, [$recordId]);
			$imagePath = $db->query_result($result, 0, 'path');
			if (!empty($imagePath)) {
				$storedname = $db->query_result($result, 0, 'storedname');
				$imageId = $db->query_result($result, 0, 'attachmentsid');
				self::$userURLCache[$recordId] = $site_URL_NonHttp . $imagePath. $imageId .'_'.$storedname;
			} else {
				self::$userURLCache[$recordId] = NULL;
			}
		}
		return self::$userURLCache[$recordId];
	}

	function getAccessiblePlatforms($userName) {
		global $adb;
		$sql = 'SELECT ser_usr_log_plat,badge_no,approval_status 
		        FROM vtiger_serviceengineer
		        INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_serviceengineer.serviceengineerid
		        WHERE badge_no = ? ';
		$result = $adb->pquery($sql, [$userName]);
		return $adb->fetch_array($result);
	}

	function getUserDetailsBasedOnEmployeeModule($badgeNo) {
		global $adb;
		$sql = 'SELECT serviceengineerid,phone,cust_role 
		        FROM vtiger_serviceengineer 
		        INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_serviceengineer.serviceengineerid 
		        WHERE vtiger_serviceengineer.badge_no = ? 
		        AND vtiger_crmentity.deleted = 0 
		        ORDER BY serviceengineerid DESC LIMIT 1';
		$sqlResult = $adb->pquery($sql, [$badgeNo]);
		// print_r($sqlResult);exit;
		return ($adb->num_rows($sqlResult) == 1) ? $adb->fetchByAssoc($sqlResult, 0) : false;
	}

	function getUserDetailsBasedOnAccountModule($username) {
		global $adb;
		$sql = 'SELECT accountid, accountname, phone, email1 
		        FROM vtiger_account 
		        INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_account.accountid
		        WHERE (accountname = ? OR email1 = ?) 
		        AND vtiger_crmentity.deleted = 0 
		        ORDER BY accountid DESC LIMIT 1';
		$sqlResult = $adb->pquery($sql, [$username, $username]);
		return ($adb->num_rows($sqlResult) == 1) ? $adb->fetchByAssoc($sqlResult, 0) : false;
	}

	function postProcess(Mobile_API_Response $response) {
		return $response;
	}
}