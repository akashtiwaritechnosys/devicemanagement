<?php
// -------------------- CONFIG --------------------
$vtiger_root = dirname(__DIR__, 4);
$logFile = __DIR__ . '/ssologin.log';
$secretKey = '2d79b2c5ba9285b85ab0e14e065c4062ad4cff5755133b9a0168f98f14fe9b51';
$callback_uri = "https://green-lobster-463551.hostingersite.com/";
 
// -------------------- LOG FUNCTION --------------------
function logMsg($msg) {
    global $logFile;
    file_put_contents($logFile, date('Y-m-d H:i:s') . " :: " . $msg . "\n", FILE_APPEND);
}
 
// -------------------- ERROR REPORTING --------------------
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
// -------------------- CHANGE WORKING DIRECTORY --------------------
chdir($vtiger_root);
 
// -------------------- INCLUDE VTIGER FILES --------------------
try {
    require_once $vtiger_root . '/vendor/autoload.php'; // Monolog & composer packages
    require_once($vtiger_root . '/config.inc.php');
    require_once($vtiger_root . '/include/utils/utils.php');
    require_once($vtiger_root . '/include/database/PearDatabase.php');
    require_once($vtiger_root . '/include/Webservices/Utils.php');
    require_once($vtiger_root . '/modules/Users/Users.php');
    require_once($vtiger_root . '/data/CRMEntity.php');
} catch (Throwable $e) {
    logMsg("Error including files: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'failed', 'error' => $e->getMessage()]);
    exit;
}
 
// -------------------- HEADERS --------------------
header('Content-Type: application/json');
 
// -------------------- HELPER: BASE64URL ENCODE --------------------
function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
 
// -------------------- HELPER: CREATE JWT TOKEN --------------------
function createToken($payload, $secretKey) {
    $header = ['alg' => 'HS256', 'typ' => 'JWT'];
    $encodedHeader = base64url_encode(json_encode($header));
    $encodedPayload = base64url_encode(json_encode($payload));
    $signature = hash_hmac('sha256', "$encodedHeader.$encodedPayload", $secretKey, true);
    $encodedSignature = base64url_encode($signature);
    return "$encodedHeader.$encodedPayload.$encodedSignature";
}
 
// -------------------- REQUEST VALIDATION --------------------
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'failed', 'code' => 405, 'message' => 'Invalid request method']);
    exit;
}
 
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
 
if (empty($username) || empty($password)) {
    http_response_code(400);
    echo json_encode(['status' => 'failed', 'code' => 400, 'message' => 'Username and Password are required']);
    exit;
}
 
// -------------------- LOGIN USER --------------------
try {
    $current_user = CRMEntity::getInstance('Users');
    $current_user->column_fields['user_name'] = $username;
 
    if (!$current_user->doLogin($password)) {
        http_response_code(401);
        echo json_encode(['status' => 'failed', 'code' => 401, 'message' => 'Incorrect login credentials.']);
        exit;
    }
 
    $current_user->id = $current_user->retrieve_user_id($username);
    $current_user->retrieveCurrentUserInfoFromFile($current_user->id);
 
} catch (Throwable $e) {
    logMsg("Login error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'failed', 'error' => $e->getMessage()]);
    exit;
}
 
// -------------------- CREATE TOKEN --------------------
$timestamp = time();
$hash = hash_hmac('sha256', $current_user->id . $username . $timestamp, $secretKey);
 
$tokenPayload = [
    'user_id' => $current_user->id,
    'username' => $username,
    'timestamp' => $timestamp,
    'hash' => $hash
];
 
$token = createToken($tokenPayload, $secretKey);
 
// -------------------- BUILD REDIRECT URL --------------------
global $site_URL;
$redirectURL = rtrim($site_URL, '/') . '/modules/Users/externalLogin.php?token=' . urlencode($token) . '&callback_uri=' . urlencode($callback_uri);
 
// -------------------- RESPONSE --------------------
$response = [
    'status' => 'success',
    'message' => 'Login successful',
    'redirect_url' => $redirectURL
];
 
echo json_encode($response);
exit;
 
 