<?php
require_once('../../config.inc.php');
require_once('include/utils/utils.php');
require_once('include/database/PearDatabase.php');
require_once('include/Webservices/Utils.php');
require_once('modules/Users/Users.php');
require_once('data/CRMEntity.php');

header('Content-Type: application/json');

$secretKey = '2d79b2c5ba9285b85ab0e14e065c4062ad4cff5755133b9a0168f98f14fe9b51';

function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function createToken($payload, $secretKey) {
    $header = ['alg' => 'HS256', 'typ' => 'JWT'];
    $encodedHeader = base64url_encode(json_encode($header));
    $encodedPayload = base64url_encode(json_encode($payload));
    $signature = hash_hmac('sha256', "$encodedHeader.$encodedPayload", $secretKey, true);
    $encodedSignature = base64url_encode($signature);
    return "$encodedHeader.$encodedPayload.$encodedSignature";
}

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

$current_user = CRMEntity::getInstance('Users');
$current_user->column_fields['user_name'] = $username;

if (!$current_user->doLogin($password)) {
    http_response_code(401);
    echo json_encode(['status' => 'failed', 'code' => 401, 'message' => 'Incorrect login credentials.']);
    exit;
}

$current_user->id = $current_user->retrieve_user_id($username);
$current_user->retrieveCurrentUserInfoFromFile($current_user->id);

$timestamp = time();
$hash = hash_hmac('sha256', $current_user->id . $username . $timestamp, $secretKey);

$tokenPayload = [
    'user_id' => $current_user->id,
    'username' => $username,
    'timestamp' => $timestamp,
    'hash' => $hash
];

$token = base64_encode(json_encode($tokenPayload));

global $site_URL;
$redirectURL = rtrim($site_URL, '/') . '/modules/Users/externalLogin.php?token=' . urlencode($token);

$response = [
    'status' => 'success',
    'message' => 'Login successful',
    'redirect_url' => $redirectURL
];

echo json_encode($response);
exit;
