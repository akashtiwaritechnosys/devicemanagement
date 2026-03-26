<?php
// Include necessary vTiger files
require_once('modules/Emails/class.smtp.php');
require_once('modules/Emails/class.phpmailer.php');
require_once('include/utils/CommonUtils.php');
require_once('include/utils/VTCacheUtils.php');
require_once('include/database/PearDatabase.php');
require_once('include/utils/EmailTemplate.php');
require_once('modules/Emails/mail.php'); // ✅ THIS IS REQUIRED
require_once('include/utils/utils.php');
require_once('include/logging.php');



class OTPHandler
{

    public static function generateOTP()
    {
        return sprintf("%06d", mt_rand(100000, 999999));
    }

    public static function sendOTP($email)
    {
        global $adb;

        try {
            error_log("OTPHandler - Starting sendOTP for email: " . $email);

            // Check if user exists
            $userQuery = "SELECT id, first_name, last_name, user_name, email1 FROM vtiger_users WHERE email1 = ? AND status = 'Active'";
            $userResult = $adb->pquery($userQuery, array($email));
            // print_r($userResult);
            // exit;

            if ($adb->num_rows($userResult) == 0) {
                error_log("OTPHandler - User not found for email: " . $email);
                return array('success' => false, 'message' => 'User not found or inactive');
            }

            $userData = $adb->fetch_array($userResult);
            $otp = self::generateOTP();
            //$expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));
            date_default_timezone_set('Asia/Kolkata');
            $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));
            // echo "Current time is: " . $currentTime;
            // echo "<pre>";
            // print_r($expiresAt);
            // exit;

            error_log("OTPHandler - Generated OTP: " . $otp . " for user: " . $userData['user_name']);

            // Delete old OTPs for this email
            $deleteQuery = "DELETE FROM vtiger_user_otp WHERE email = ?";
            $adb->pquery($deleteQuery, array($email));

            //$otp = strval(rand(100000, 999999));
            //$expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            $insertQuery = "INSERT INTO vtiger_user_otp (email, otp, expires_at) VALUES (?, ?, ?)";
            $result = $adb->pquery($insertQuery, array($email, $otp, $expiresAt));

            if (!$result) {
                error_log("DB Error: " . $adb->database->ErrorMsg());
                return array('success' => false, 'message' => 'Failed to generate OTP: DB error');
            }


            // Insert new OTP
            // $insertQuery = "INSERT INTO vtiger_user_otp (email, otp, expires_at) VALUES (?, ?, ?)";
            // $result = $adb->pquery($insertQuery, array($email, $otp, $expiresAt));
            // echo "<pre>";
            // print_r($result);
            // exit;

            if ($result) {
                error_log("OTPHandler - OTP saved to database, now sending email");

                // Send email using vTiger's email system
                //$emailSent = send_mail($email, $otp, $userData['first_name'] . ' ' . $userData['last_name']);
                global $log;
                // $log->debug("ottttttttp is" . $otp)
                $emailSent = self::sendOTPEmail($email, $otp, $userData['first_name'] . ' ' . $userData['last_name']);
                // echo "<pre>";
                // print_r($emailSent);
                // exit;

                //$emailSent = send_mail('Users', $email, '007', '', 'testing', 'otp recived 007');

                if ($emailSent) {
                    error_log("OTPHandler - Email sent successfully");
                    return array('success' => true, 'message' => 'OTP sent successfully to your email');
                } else {
                    error_log("OTPHandler - Failed to send email");
                    return array('success' => false, 'message' => 'Failed to send OTP email. Please check email configuration.');
                }
            } else {
                error_log("OTPHandler - Failed to save OTP to database");
                return array('success' => false, 'message' => 'Failed to generate OTP');
            }
        } catch (Exception $e) {
            error_log("OTPHandler - Exception in sendOTP: " . $e->getMessage());
            return array('success' => false, 'message' => 'Error: ' . $e->getMessage());
        }
    }

    public static function verifyOTP($email, $otp)
    {
        global $adb;
        try {
            $query = "SELECT id FROM vtiger_user_otp WHERE email = ? AND otp = ? AND expires_at > NOW() AND is_used = 0";
            $result = $adb->pquery($query, array($email, $otp));


            if ($adb->num_rows($result) > 0) {
                // Mark OTP as used
                $otpId = $adb->query_result($result, 0, 'id');
                $updateQuery = "UPDATE vtiger_user_otp SET is_used = 1 WHERE id = ?";
                $adb->pquery($updateQuery, array($otpId));

                return true;
            }

            return false;
        } catch (Exception $e) {
            error_log("OTPHandler - Exception in verifyOTP: " . $e->getMessage());
            return false;
        }
    }

    // private static function sendOTPEmail($email, $otp, $userName)
    // {
    //     global $adb;

    //     try {
    //         error_log("OTPHandler - Starting sendOTPEmail");

    //         // Method 1: Try using simple mail function first
    //         $subject = "vTiger CRM - Login OTP";
    //         $message = "Dear $userName,\r\n\r\n";
    //         $message .= "Your OTP for vTiger CRM login is: $otp\r\n";
    //         $message .= "This OTP will expire in 10 minutes.\r\n\r\n";
    //         $message .= "If you did not request this OTP, please ignore this email.\r\n\r\n";
    //         $message .= "Best regards,\r\nvTiger CRM Team";

    //         $headers = "From: VTiger CRM <noreply@" . $_SERVER['HTTP_HOST'] . ">\r\n";
    //         $headers .= "Reply-To: noreply@" . $_SERVER['HTTP_HOST'] . "\r\n";
    //         $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    //         // Try PHP's built-in mail function first
    //         if (mail($email, $subject, $message, $headers)) {
    //             error_log("OTPHandler - Email sent via PHP mail()");
    //             return true;
    //         }

    //         error_log("OTPHandler - PHP mail() failed, trying vTiger send_mail");

    //         // Method 2: Try vTiger's send_mail function
    //         if (function_exists('send_mail')) {
    //             // Get admin user details
    //             $adminQuery = "SELECT id, email1, first_name, last_name FROM vtiger_users WHERE is_admin = 'on' AND status = 'Active' LIMIT 1";
    //             $adminResult = $adb->pquery($adminQuery, array());

    //             if ($adb->num_rows($adminResult) > 0) {
    //                 $adminData = $adb->fetch_array($adminResult);
    //                 $adminEmail = $adminData['email1'] ? $adminData['email1'] : 'admin@' . $_SERVER['HTTP_HOST'];
    //                 $adminName = trim($adminData['first_name'] . ' ' . $adminData['last_name']);
    //                 if (empty($adminName)) $adminName = 'vTiger Admin';

    //                 // HTML content for vTiger send_mail
    //                 $contents = "Dear $userName,<br><br>";
    //                 $contents .= "Your OTP for vTiger CRM login is: <strong>$otp</strong><br>";
    //                 $contents .= "This OTP will expire in 10 minutes.<br><br>";
    //                 $contents .= "If you did not request this OTP, please ignore this email.<br><br>";
    //                 $contents .= "Best regards,<br>vTiger CRM Team";

    //                 // Use vTiger's send_mail function
    //                 $result = send_mail(
    //                     'Emails',           // module
    //                     $email,            // to_email
    //                     $adminName,        // from_name  
    //                     $adminEmail,       // from_email
    //                     $subject,          // subject
    //                     $contents,         // body
    //                     '',                // cc
    //                     '',                // bcc
    //                     '',                // attachment
    //                     $adminData['id'],  // assigned_user_id
    //                     '',                // logo (optional)
    //                     ''                 // reply_to (optional)
    //                 );
    //                 error_log("OTPHandler - vTiger send_mail result: " . print_r($result, true));

    //                 return ($result == 1 || $result === true);
    //             } else {
    //                 error_log("OTPHandler - No admin user found");
    //                 return false;
    //             }
    //         } else {
    //             error_log("OTPHandler - send_mail function not available");
    //             return false;
    //         }
    //     } catch (Exception $e) {
    //         error_log("OTPHandler - Exception in sendOTPEmail: " . $e->getMessage());
    //         return false;
    //     }
    // }

    private static function sendOTPEmail($email, $otp, $userName)
    {
        global $adb;

        $subject = "Epsilon CRM - Login OTP";
        $contents = "Dear $userName,<br><br>";
        $contents .= "Your OTP for Epsilon CRM login is: <strong>$otp</strong><br>";
        $contents .= "This OTP will expire in 10 minutes.<br><br>";
        $contents .= "Best regards,<br>Epsilon CRM Team";

        // Get admin details
        $adminQuery = "SELECT id, email1, first_name, last_name FROM vtiger_users WHERE is_admin = 'on' AND status = 'Active' LIMIT 1";
        $adminResult = $adb->pquery($adminQuery, array());

        if ($adb->num_rows($adminResult) == 0) {
            error_log("sendOTPEmail - No admin user found");
            return false;
        }

        $adminData = $adb->fetch_array($adminResult);
        $adminEmail = $adminData['email1'] ?: 'admin@' . $_SERVER['HTTP_HOST'];
        $adminName = trim($adminData['first_name'] . ' ' . $adminData['last_name']) ?: 'vTiger Admin';
        $sendResult = send_mail("Users", $email, 'Epsilon', $adminEmail, $subject, $contents, '');

        error_log("send_mail result: " . var_export($sendResult, true));

        return ($sendResult === true || $sendResult == 1);
    }
}
