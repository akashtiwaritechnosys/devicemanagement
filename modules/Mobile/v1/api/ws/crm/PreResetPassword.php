<?php

require_once 'includes/main/WebUI.php';
require_once 'include/utils/utils.php';
require_once 'include/utils/VtlibUtils.php';
require_once 'modules/Vtiger/helpers/ShortURL.php';


class Mobile_WS_PreResetPassword extends Mobile_WS_Controller {
    function requireLogin() {
        return false;
    }

    function process(Mobile_API_Request $request) {
        $response = new Mobile_API_Response();
        $emailFromRequest = $request->get('email');
        $mobileFromRequest = $request->get('mobile');
        
        if (empty($emailFromRequest) && empty($mobileFromRequest)) {
            $response->setError(100, 'Either Email or Mobile Number Is Required');
            return $response;
        }
        
        global $adb;
        $IpAddress = $this->getClientIp() . date("YmdH");
        $sql = "SELECT count(*) as 'count' FROM vtiger_shorturls WHERE ip_address = ?";
        $result = $adb->pquery($sql, array($IpAddress));
        $dataRow = $adb->fetchByAssoc($result, 0);
        $numberOfattempts = (int) $dataRow['count'];
        
        if ($numberOfattempts > 10) {
            $response->setError(100, 'Number of Password Reset Attempt is Exceeded');
            return $response;
        }

        // Find user details from email or mobile
        $userDetails = null;
        if (!empty($emailFromRequest)) {
            $userDetails = $this->getUserDetailsByEmail($emailFromRequest);
        }
        
        if (empty($userDetails) && !empty($mobileFromRequest)) {
            $userDetails = $this->getUserDetailsByMobile($mobileFromRequest);
        }
        
        if (empty($userDetails)) {
            $response->setError(100, 'Unable To Find User');
            return $response;
        }

        $time = time();
        $otp = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
        $options = array(
            'handler_path' => 'modules/Users/handlers/ForgotPassword.php',
            'handler_class' => 'Users_ForgotPassword_Handler',
            'handler_function' => 'changePassword',
            'onetime' => 0
        );
        
        // Use appropriate identifier for hash based on user type
        $hashIdentifier = !empty($userDetails['badgeNo']) ? $userDetails['badgeNo'] : $userDetails['email'];
        
        $handler_data = array(
            'time' => strtotime("+15 Minute"),
            'hash' => md5($hashIdentifier . $time),
            'otp' => $otp,
            'badgeNo' => $userDetails['badgeNo'] ?? '', // Handle missing badgeNo
            'email' => $userDetails['email'],
            'id' => $userDetails['id']
        );
        
        $options['handler_data'] = $handler_data;
        $trackURL = Vtiger_ShortURL_Helper::generateURLMobile($options);
        
        // Send OTP to both email and SMS if available
        $emailSuccess = false;
        $smsSuccess = false;
        $message = '';
        
        // Always try to send email if user has email
        if (!empty($userDetails['email'])) {
            $emailSuccess = $this->sendEmailOTP($userDetails['email'], $otp);
            if ($emailSuccess) {
                $message = 'OTP Has Been Sent To Registered Email';
            }
        }
        
        // Always try to send SMS if user has phone
        // if (!empty($userDetails['phone'])) {
        //     $smsSuccess = $this->sendSMS($userDetails['phone'], $otp, $userDetails['name'] ?? '');
        //     if ($smsSuccess) {
        //         $message = empty($message) ? 
        //             'OTP Has Been Sent To Registered Mobile Number' : 
        //             'OTP Has Been Sent To Registered Email And Mobile Number';
        //     }
        // }
        
        if ($emailSuccess || $smsSuccess) {
            $responseObject = array(
                'uid' => $trackURL,
                'usermobilenumber' => $userDetails['phone'],
                'usercreatedid' => $userDetails['userCreatedId'],
                'useruniqeid' => $userDetails['id'],
                'timestamp' => (new DateTime())->getTimestamp(),
                'usertype' => $userDetails['usertype'],
                'message' => $message
            );
            
            $response->setApiSucessMessage($message);
            $response->setResult($responseObject);
            $adb->pquery('update vtiger_shorturls set ip_address = ? where uid = ?', array($IpAddress, $trackURL));
            return $response;
        } else {
            $response->setError(100, 'Failed to send OTP');
            return $response;
        }
    }

    private function sendEmailOTP($email, $otp) {
        $content = 'Dear User,<br><br> 
        You recently requested a password reset for your CRM Account.<br> 
        To create a new password, Here is your OTP ' . $otp . '
        <br><br> 
        This request was made on ' . date("d/m/Y h:i:s a")  . ' and will expire in next 15 Minutes.<br><br> 
        Regards,<br> 
        CRM Support Team.<br>';

        $subject = 'CRM: Password Reset';
        vimport('~~/modules/Emails/mail.php');
        global $HELPDESK_SUPPORT_EMAIL_ID, $HELPDESK_SUPPORT_NAME;
        return send_mail('Users', $email, $HELPDESK_SUPPORT_NAME, $HELPDESK_SUPPORT_EMAIL_ID, $subject, $content, '', '', '', '', '', true);
    }

    // private function sendSMS($mobile, $otp, $name) {
    //     $name = !empty($name) ? $name : "Customer";
    //     $apiUrl = "https://onlysms.co.in/api/sms.aspx";
    //     $params = [
    //         'GSMID' => 'BZTINF',
    //         'PEID' => '1701173331130180744',
    //         'UNICODE' => 'TEXT',
    //         'TEMPID' => '1707173694923303499',
    //         'Message' => "Dear ". $name .", ". $otp." is the OTP to reset your password. The OTP is valid for 7 minutes. Do not share the OTP with anyone. BZTINF.",
    //         'UserPass' => 'Biz909@',
    //         'UserID' => 'biztechotp',
    //         'MobileNo' => $mobile
    //     ];
    
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $apiUrl);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    //     $response = curl_exec($ch);
    //     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //     curl_close($ch);
    
    //     return ($httpCode == 200);
    // }
    
    // Fixed method to find user by email
    private function getUserDetailsByEmail($email) {
        global $adb;
        $email = vtlib_purify($email);
        
        // Try in service engineer table first
        $sql = 'SELECT serviceengineerid, service_engineer_name, vtiger_serviceengineer.email, vtiger_users.id, 
                vtiger_serviceengineer.phone, vtiger_users.accesskey, vtiger_serviceengineer.badge_no
                FROM vtiger_serviceengineer 
                INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_serviceengineer.serviceengineerid 
                INNER JOIN vtiger_users ON vtiger_users.user_name = vtiger_serviceengineer.badge_no 
                WHERE vtiger_serviceengineer.email = ? AND vtiger_crmentity.deleted = 0 
                ORDER BY serviceengineerid DESC LIMIT 1';
        
        $result = $adb->pquery($sql, array($email));
        if ($adb->num_rows($result) == 1) {
           return [
                'email'        => $adb->query_result($result, 0, 'email'),
                'id'           => $adb->query_result($result, 0, 'id'),
                'phone'        => $adb->query_result($result, 0, 'phone'),
                'badgeNo'      => $adb->query_result($result, 0, 'badge_no'),
                'userCreatedId'=> $adb->query_result($result, 0, 'serviceengineerid'),
                'usertype'     => 'EPSILONUSER'
            ];
        
        }
        
        // Try in account(customer role) table if not found
        $sql = 'SELECT  vtiger_account.accountid, vtiger_account.accountname, vtiger_account.phone, vtiger_account.email1
                FROM vtiger_account
                INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_account.accountid
                INNER JOIN vtiger_users ON vtiger_users.user_name = vtiger_account.email1
                WHERE vtiger_account.email1 = ?
                AND vtiger_crmentity.deleted = 0
                ORDER BY accountid DESC 
                LIMIT 1;
                ';
    
        $result = $adb->pquery($sql, array($email));
        if ($adb->num_rows($result) == 1) {
           return [
                'email'        => $adb->query_result($result, 0, 'email1'),
                'id'           => $adb->query_result($result, 0, 'accountid'),
                'phone'        => $adb->query_result($result, 0, 'phone'),
                'userCreatedId'=> $adb->query_result($result, 0, 'accountid'),
                'usertype'     => 'BIZUSER',
                'name'         => $adb->query_result($result, 0, 'accountname') 
            ];
        
        }
        
        return null;
    }
    
    // Fixed method to find user by mobile
    private function getUserDetailsByMobile($mobile) {
        global $adb;
        $mobile = vtlib_purify($mobile);
        
        // Try in service engineer table first
        $sql = 'SELECT serviceengineerid, service_engineer_name, vtiger_serviceengineer.email, vtiger_users.id, 
                vtiger_serviceengineer.phone, vtiger_users.accesskey, vtiger_serviceengineer.badge_no
                FROM vtiger_serviceengineer 
                INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_serviceengineer.serviceengineerid 
                INNER JOIN vtiger_users ON vtiger_users.user_name = vtiger_serviceengineer.badge_no 
                WHERE vtiger_serviceengineer.phone = ? AND vtiger_crmentity.deleted = 0 
                ORDER BY serviceengineerid DESC LIMIT 1';
        
        $result = $adb->pquery($sql, array($mobile));
        if ($adb->num_rows($result) == 1) {
          return [
                'email'        => $adb->query_result($result, 0, 'email'),
                'id'           => $adb->query_result($result, 0, 'id'),
                'phone'        => $adb->query_result($result, 0, 'phone'),
                'badgeNo'      => $adb->query_result($result, 0, 'badge_no'),
                'userCreatedId'=> $adb->query_result($result, 0, 'serviceengineerid'),
                'usertype'     => 'EPSILONUSER'
            ];
        
        }
        
        // Try in account table if not found
        $sql = 'SELECT accountid, accountname, phone, email1
                FROM vtiger_account
                INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_account.accountid
                INNER JOIN vtiger_users ON vtiger_users.user_name = vtiger_account.email1
                WHERE vtiger_account.phone = ? AND vtiger_crmentity.deleted = 0
                ORDER BY accountid DESC LIMIT 1';
    
        $result = $adb->pquery($sql, array($mobile));
        if ($adb->num_rows($result) == 1) {
           return [
                'email'        => $adb->query_result($result, 0, 'email1'),
                'id'           => $adb->query_result($result, 0, 'accountid'),
                'phone'        => $adb->query_result($result, 0, 'phone'),
                'userCreatedId'=> $adb->query_result($result, 0, 'accountid'),
                'usertype'     => 'BIZINFRAUSER',
                'name'         => $adb->query_result($result, 0, 'accountname') 
            ];
        
        }
        
        return null;
    }
    
    function getClientIp() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';

        return $ipaddress;
    }
}