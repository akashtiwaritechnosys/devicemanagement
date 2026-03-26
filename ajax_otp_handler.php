<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start output buffering to prevent any output before JSON
ob_start();

try {
    session_start();

    // Include vTiger files
    chdir(dirname(__FILE__));
    require_once('config.inc.php');
    require_once('include/utils/utils.php');
    require_once('include/database/PearDatabase.php');
    require_once('modules/Users/OTPHandler.php');

    // Clean any previous output
    ob_clean();

    // Set JSON header
    header('Content-Type: application/json');

    // Log the request for debugging
    error_log("OTP Handler - Request received: " . print_r($_POST, true));

    if (!isset($_POST['action'])) {
        echo json_encode(array('success' => false, 'message' => 'Invalid request - no action specified'));
        exit;
    }

    if ($_POST['action'] == 'send_otp') {
        $email = trim($_POST['email']);

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(array('success' => false, 'message' => 'Please enter a valid email address'));
            exit;
        }

        error_log("OTP Handler - Sending OTP to: " . $email);

        $result = OTPHandler::sendOTP($email);

        error_log("OTP Handler - Send result: " . print_r($result, true));

        echo json_encode($result);
    } elseif ($_POST['action'] == 'verify_otp') {
        $email = trim($_POST['email']);
        $otp = trim($_POST['otp']);

        if (empty($email) || empty($otp)) {
            echo json_encode(array('success' => false, 'message' => 'Email and OTP are required'));
            exit;
        }

        $isValid = OTPHandler::verifyOTP($email, $otp);

        if ($isValid) {
            // Get user details and set session
            global $adb, $application_unique_key;
            $userQuery = "SELECT * FROM vtiger_users WHERE email1 = ? AND status = 'Active'";
            $userResult = $adb->pquery($userQuery, array($email));

            if ($adb->num_rows($userResult) > 0) {
                $userData = $adb->fetch_array($userResult);

                // Set session variables (similar to normal login)
                $_SESSION['authenticated_user_id'] = $userData['id'];
                $_SESSION['app_unique_key'] = $application_unique_key;
                $_SESSION['authenticated_user_name'] = $userData['user_name'];
                $_SESSION['vtiger_authenticated_user_theme'] = $userData['theme'];
                $_SESSION['vtiger_authenticated_user_language'] = $userData['language'];

                echo json_encode(array('success' => true, 'message' => 'Login successful', 'redirect' => 'index.php'));
            } else {
                echo json_encode(array('success' => false, 'message' => 'User not found'));
            }
        } else {
            echo json_encode(array('success' => false, 'message' => 'Invalid or expired OTP'));
        }
    } else {
        echo json_encode(array('success' => false, 'message' => 'Invalid action'));
    }
} catch (Exception $e) {
    error_log("OTP Handler - Exception: " . $e->getMessage());
    echo json_encode(array('success' => false, 'message' => 'Server error: ' . $e->getMessage()));
} catch (Error $e) {
    error_log("OTP Handler - Error: " . $e->getMessage());
    echo json_encode(array('success' => false, 'message' => 'Server error: ' . $e->getMessage()));
}

// End output buffering and flush
ob_end_flush();
