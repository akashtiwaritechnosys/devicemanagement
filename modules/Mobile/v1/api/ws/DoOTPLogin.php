<?php
include_once 'vtlib/Vtiger/Module.php';
include_once "include/utils/VtlibUtils.php";
include_once "include/utils/CommonUtils.php";
include_once "includes/Loader.php";
include_once 'includes/runtime/BaseModel.php';
include_once "includes/http/Request.php";
include_once "include/Webservices/Custom/ChangePassword.php";
include_once "include/Webservices/Utils.php";
include_once "includes/runtime/EntryPoint.php";
include_once "modules/vtiger/helpers/ShortURL.php";
vimport('includes.runtime.EntryPoint');
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Mobile_WS_DoOTPLogin extends Mobile_WS_Controller {
    private static $userURLCache = [];

    function requireLogin() {
        return false;
    }

    function process(Mobile_API_Request $request) {
        global $adb;
        $response = new Mobile_API_Response();

        try {
            
            $trackingId = $request->get('tracking_url');
            $otp = $request->get('otp');
            if (empty($trackingId)) {
                $response->setError(1502, 'Tracking URL is missing');
                return $response;
            }

            global $handlerData;
            $status = true;
            $shortURLModel = Vtiger_ShortURL_Helper::getInstance(vtlib_purify($trackingId));
            if (!$shortURLModel) {
                $response->setError(1503, 'Invalid tracking URL');
                return $response;
            }
        
            $handlerData = $shortURLModel->handler_data;
            if (empty($handlerData)) {
                $response->setError(1504, 'Invalid OTP data');
                return $response;
            }
        
            if ($otp != $handlerData['otp']) {
                $response->setError(1505, 'Invalid OTP');
                return $response;
            }
        
            if (time() > $handlerData['time']) {
                $response->setError(1506, 'OTP has expired');
                return $response;
            }

            $email = $handlerData['email'];
            $userData = $this->getUserDataByEmail($email);
            
            if (!$userData) {
                $response->setResult(array(
                    'statuscode' => 0,
                    'statusMessage' => 'User not found',
                    'data' => array()
                ));
                return $response;
            }
            
            $username = $userData['user_name'];

            $current_user = CRMEntity::getInstance('Users');
            $current_user->column_fields['user_name'] = $username;
            $current_user->id = $current_user->retrieve_user_id($username);
            $current_user->retrieveCurrentUserInfoFromFile($current_user->id);
            $this->setActiveUser($current_user);

            require __DIR__ . DIRECTORY_SEPARATOR . 'autoload.php';
            $key = "ONSGVGFDKNBXVDAWTYSVSCDX" . $current_user->user_password . $current_user->user_name;
            $payload = ['userid' => $current_user->id];
            $jwt = JWT::encode($payload, $key, 'HS256');

            $profileData = $this->getEmployeeProfileData($username);

            $result = array_merge($profileData, [
                'assign_user_id' => $current_user->id,
                'access_token' => $jwt,
                'username' => $username,
                'useruniqeid' => $current_user->id,
                'timestamp' => (new DateTime())->getTimestamp(),
                'message' => 'You Have Logged in Successfully',
            ]);

            $imageUrl = $this->getUserImageDetails($current_user->id);
            $result['imagename'] = $imageUrl;
            $response->setApiSucessMessage('Successfully Logged In');
            $response->setResult($result);
            $this->postProcess($response);
        
            return $response;
        } catch (Exception $e) {
            $response->setApiErrorMessage('Login Error: ' . $e->getMessage());
            $response->setResult([]);
            return $response;
        }            
    }

    private function getUserDataByEmail($email) {
        global $adb;
        $sql = "SELECT u.user_name, se.email, se.approval_status, 'Employee' AS type
                FROM vtiger_serviceengineer se
                INNER JOIN vtiger_users u ON u.email1 = se.email
                WHERE se.email = ?";
        $result = $adb->pquery($sql, array($email));
        return $adb->num_rows($result) > 0 ? $adb->fetchByAssoc($result) : false;
    }

    function getEmployeeProfileData($username) {
        global $adb;
        $sql = 'SELECT serviceengineerid, email, phone, sub_service_manager_role
                FROM vtiger_serviceengineer
                INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_serviceengineer.serviceengineerid
                WHERE badge_no = ? AND vtiger_crmentity.deleted = 0
                ORDER BY serviceengineerid DESC LIMIT 1';
        $sqlResult = $adb->pquery($sql, array($username));
        $dataRow = $adb->fetchByAssoc($sqlResult, 0);

        $recordModel = Vtiger_Record_Model::getInstanceById($dataRow['serviceengineerid'], 'ServiceEngineer');
        $emData = $recordModel->getData();
        unset($emData['confirm_password'], $emData['user_password']);

        $date = new DateTime();
        $role = $dataRow['sub_service_manager_role'] ?: 'None';

        return array(
            'usercreatedid' => $dataRow['serviceengineerid'],
            'useremail' => $dataRow['email'],
            'usermobilenumber' => $dataRow['phone'],
            'userRole' => $role,
            'profileInfo' => $emData,
            'timestamp' => $date->getTimestamp(),
            'imagename' => $this->getUserImageDetails($dataRow['serviceengineerid'])
        );
    }

    public function getUserImageDetails($recordId) {
        if (empty($recordId)) {
            return NULL;
        }
        global $site_URL_NonHttp;
        $db = PearDatabase::getInstance();

        if (!isset(self::$userURLCache[$recordId])) {
            $query = "SELECT vtiger_attachments.attachmentsid, vtiger_attachments.path,
                    vtiger_attachments.name, vtiger_attachments.storedname FROM vtiger_attachments
                    LEFT JOIN vtiger_salesmanattachmentsrel
                    ON vtiger_salesmanattachmentsrel.attachmentsid = vtiger_attachments.attachmentsid
                    WHERE vtiger_salesmanattachmentsrel.smid=? order by attachmentsid desc limit 1";
            $result = $db->pquery($query, array($recordId));

            $storedname = $db->query_result($result, 0, 'storedname');
            $imagePath = $db->query_result($result, 0, 'path');
            $imageId = $db->query_result($result, 0, 'attachmentsid');

            if (empty($imagePath)) {
                self::$userURLCache[$recordId] = NULL;
            } else {
                self::$userURLCache[$recordId] = $site_URL_NonHttp . $imagePath . $imageId . '_' . $storedname;
            }
        }

        return self::$userURLCache[$recordId];
    }
   
    function postProcess(Mobile_API_Response $response) {
        return $response;
    }
}