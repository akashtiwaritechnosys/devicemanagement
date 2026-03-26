<?php
chdir(dirname(__FILE__) . '/../../');
require_once 'config.inc.php';
require_once 'includes/main/WebUI.php';
 
session_start();
 
$callback_uri = $_GET['callback_uri'] ?? '';
$redirectUri = (rtrim($callback_uri, '/') ?? '') . '/sign-in';
if (!$redirectUri || !filter_var($redirectUri, FILTER_VALIDATE_URL)) {
    $redirectUri = 'http://localhost/signin/login.php';
}
 
$secretKey = '2d79b2c5ba9285b85ab0e14e065c4062ad4cff5755133b9a0168f98f14fe9b51';
$token = $_GET['token'] ?? '';
 
if (!$token) {
    header("Location: $redirectUri?error=" . urlencode("Missing token"));
    exit;
}
 
// --- Decode JWT ---
$parts = explode('.', $token);
if (count($parts) !== 3) {
    header("Location: $redirectUri?error=" . urlencode("Invalid token format"));
    exit;
}
 
list($encodedHeader, $encodedPayload, $encodedSignature) = $parts;
 
// Base64url decode helper
function base64url_decode($data) {
    $remainder = strlen($data) % 4;
    if ($remainder) {
        $data .= str_repeat('=', 4 - $remainder);
    }
    return base64_decode(strtr($data, '-_', '+/'));
}
 
// Decode header & payload
$header = json_decode(base64url_decode($encodedHeader), true);
$payload = json_decode(base64url_decode($encodedPayload), true);
$signature = base64url_decode($encodedSignature);
 
// Validate payload fields
if (!$payload || !isset($payload['username'], $payload['user_id'], $payload['timestamp'], $payload['hash'])) {
    header("Location: $redirectUri?error=" . urlencode("Invalid token payload"));
    exit;
}
 
// --- Verify signature ---
$expectedSignature = hash_hmac('sha256', "$encodedHeader.$encodedPayload", $secretKey, true);
if (!hash_equals($expectedSignature, $signature)) {
    header("Location: $redirectUri?error=" . urlencode("Invalid token signature"));
    exit;
}
 
// --- Token expiry check (optional, e.g., 5 minutes) ---
if ((time() - $payload['timestamp']) > 300) {
    header("Location: $redirectUri?error=" . urlencode("Token expired"));
    exit;
}
 
// --- Set session ---
$userId = $payload['user_id'];
$username = $payload['username'];
 
$user = new Users();
$user->retrieveCurrentUserInfoFromFile($userId);
 
session_regenerate_id(true);
 
Vtiger_Session::set('AUTHUSERID', $userId);
$_SESSION['authenticated_user_id'] = $userId;
$_SESSION['app_unique_key'] = vglobal('application_unique_key');
$_SESSION['authenticated_user_language'] = vglobal('default_language');
$_SESSION['LOGOUT_URL'] = $redirectUri;
 
// KCFINDER setup
$_SESSION['KCFINDER'] = [
    'disabled' => false,
    'uploadURL' => "test/upload",
    'uploadDir' => "../test/upload",
    'deniedExts' => implode(" ", vglobal('upload_badext')),
];
 
// Track login
$moduleModel = Users_Module_Model::getInstance('Users');
$moduleModel->saveLoginHistory($username);
 
// Final redirect to CRM dashboard
global $site_URL;
echo <<<HTML
<!DOCTYPE html>
<html>
<head>
    <title>Logging in...</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root {
            --primary: #012233;
            --accent: #33ED88;
            --bg: #f9fafb;
            --card: #ffffff;
            --text: #111827;
            --text-light: #6b7280;
        }
        @media (prefers-color-scheme: dark) {
            :root {
                --bg: #000F1A;
                --card: #012233;
                --text: #f9fafb;
                --text-light: #9ca3af;
            }
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: var(--text);
            line-height: 1.5;
        }
        .card {
            background-color: var(--card);
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            width: 100%;
            max-width: 360px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        .loader {
            display: inline-block;
            position: relative;
            width: 80px;
            height: 80px;
            margin: 1.5rem 0;
        }
        .loader-dot {
            position: absolute;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            background: var(--accent);
            animation: loader-animation 1.2s linear infinite;
        }
        .loader-dot:nth-child(1) { top: 8px; left: 8px; animation-delay: 0s; }
        .loader-dot:nth-child(2) { top: 8px; left: 32px; animation-delay: 0.4s; }
        .loader-dot:nth-child(3) { top: 8px; left: 56px; animation-delay: 0.8s; }
        @keyframes loader-animation {
            0%, 100% { transform: scale(0); opacity: 0.5; }
            50% { transform: scale(1); opacity: 1; }
        }
        h1 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--primary);
        }
        p {
            color: var(--text-light);
            font-size: 0.875rem;
            margin-top: 0;
        }
        .progress-bar {
            height: 4px;
            background-color: rgba(1, 34, 51, 0.1);
            border-radius: 2px;
            margin-top: 1.5rem;
            overflow: hidden;
        }
        .progress {
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            animation: progress 1.5s ease-out forwards;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="loader">
            <div class="loader-dot"></div>
            <div class="loader-dot"></div>
            <div class="loader-dot"></div>
        </div>
        <h1>Signing you in</h1>
        <p>Please wait while we securely log you in</p>
        <div class="progress-bar">
            <div class="progress"></div>
        </div>
    </div>
    <script>
        setTimeout(() => {
            window.location.href = "{$site_URL}index.php?module=Users&parent=Settings&view=SystemSetup";
        }, 1800);
    </script>
</body>
</html>
HTML;
exit;
 
 