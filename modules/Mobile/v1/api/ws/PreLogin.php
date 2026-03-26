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

class Mobile_WS_PreLogin extends Mobile_WS_Controller {
    private static $userURLCache = [];

    function requireLogin() {
        return false;
    }

    function process(Mobile_API_Request $request) {
        global $adb;
        $response = new Mobile_API_Response();

        $email = $request->get('email');
        // $otp = $request->get('otp');

        if (empty($email)) {
            $response->setError(1507, 'Email is Missing');
            return $response;
        }
        

        // Check if user exists before proceeding
        $existsInModules = $this->checkEmailExistsInModules($email);
        if (!$existsInModules) {
            $response->setError(1508, 'You are Not Registered');
            return $response;
        }

        $userData = $this->getUserDataByEmail($email);
        if (!$userData) {
            $response->setError(1509, 'User Not Found');
            return $response;
        }

        if ($userData['approval_status'] == 'Rejected') {
            $response->setError(1510, 'User Verification Rejected. Please Sign Up Again.');
            return $response;
        }

        // Handle OTP generation if OTP is not provided
        $otp = '';
        if (empty($otp)) {
            try {
                if (!empty($email)) {
                    $time = time();
                    $otp = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
                    $options = array(
                        'handler_path' => 'modules/Users/handlers/ForgotPassword.php',
                        'handler_class' => 'Users_ForgotPassword_Handler',
                        'handler_function' => 'changePassword',
                        'onetime' => 0
                    );
                    
                    $handler_data = array(
                        'email' => $email,
                        'time' => strtotime("+15 Minute"),
                        'hash' => md5($email . $time),
                        'otp' => $otp
                    );
                    
                    $options['handler_data'] = $handler_data;
                    $trackURL = Vtiger_ShortURL_Helper::generateURLMobile($options);

                    // Send OTP via Email
                    $content = 'Dear User,<br><br>
                        Here is your OTP for Email verification: ' . $otp . '
                        <br><br>
                        This request was made on ' . date("d/m/Y h:i:s a")  . ' and will expire in next 15 minutes.<br><br>
                        Regards,<br>
                        CRM Support Team.<br>';
                    $subject = 'CCHS: OTP Verification';

                    vimport('~~/modules/Emails/mail.php');
                    global $HELPDESK_SUPPORT_EMAIL_ID, $HELPDESK_SUPPORT_NAME;
                    $status = send_mail('Users', $email, $HELPDESK_SUPPORT_NAME, $HELPDESK_SUPPORT_EMAIL_ID, $subject, $content, '', '', '', '', '', true);

                    if (!$status) {
                        $response->setError(1511, 'Failed to send OTP email');
                        return $response;
                    }

                    $response->setResult(array(
                        'tracking_url' => $trackURL
                    ));
                    $response->setApiSucessMessage('OTP Sent Successfully');
                    return $response;
                }
            } catch (Exception $e) {
                $response->setError(1512, 'Error in OTP process: ' . $e->getMessage());
                return $response;
            }
        }
    }

    // private function verifyOTP($trackingId, $otp) {
    //     global $handlerData;
    //     $status = Vtiger_ShortURL_Helper::handleForgotPasswordMobile(vtlib_purify($trackingId));

    //     $shortURLModel = Vtiger_ShortURL_Helper::getInstance($trackingId);
    //     if (!$shortURLModel) {
    //         return 'Invalid tracking URL';
    //     }
        
    //     $handlerData = $shortURLModel->handler_data;
    //     if (empty($handlerData)) {
    //         return 'Invalid OTP data';
    //     }

    //     if ($otp != $handlerData['otp']) {
    //         return 'Invalid OTP';
    //     }

    //     if (time() > $handlerData['time']) {
    //         return 'OTP has expired';
    //     }

    //     return true;
    // }

    private function checkEmailExistsInModules($email) {
        global $adb;
        $sql = "SELECT 1 FROM vtiger_serviceengineer WHERE email = ?";
        $result = $adb->pquery($sql, array($email));
        return $adb->num_rows($result) > 0;
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

    function getUserDataByEmail($email) {
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

    function postProcess(Mobile_API_Response $response) {
        return $response;
    }
}