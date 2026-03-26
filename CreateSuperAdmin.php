<?php
require_once 'vendor/autoload.php';
include_once 'config.php';
include_once 'include/Webservices/Relation.php';
include_once 'vtlib/Vtiger/Module.php';
include_once 'includes/main/WebUI.php';
include_once 'modules/Users/Users.php';

global $adb, $current_user;

// Use admin user as context
$current_user = Users::getActiveAdminUser();

// Enable error reporting for debugging (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Read JSON input
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

// Validate input
if (!$data || !isset($data['username'], $data['person_name'], $data['phone'], $data['email'], $data['password'], $data['confirm_password'])) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid or missing JSON payload'
    ]);
    exit;
}

try {
    // === Create vtiger User ===
    $focus = new Users();
    $focus->column_fields['user_name'] = $data['username'];
    $focus->column_fields['first_name'] = $data['person_name'];
    $focus->column_fields['last_name'] = 'Admin';
    $focus->column_fields['phone_mobile'] = $data['phone'];
    $focus->column_fields['email1'] = $data['email'];
    $focus->column_fields['user_password'] = $data['password'];
    $focus->column_fields['confirm_password'] = $data['confirm_password'];
    $focus->column_fields['roleid'] = 'H2'; // ⚠️ Ensure this roleid exists in vtiger_role table
    $focus->column_fields['is_admin'] = 'on';
    $focus->column_fields['status'] = 'Active';
    $focus->column_fields['currency_id'] = '1';
    $focus->column_fields['defaultlandingpage'] = 'Home';
    $focus->column_fields['language'] = 'en_us';
    $focus->column_fields['time_zone'] = 'Asia/Kolkata';
    $focus->column_fields['reminder_interval'] = '1 Minute';
    $focus->column_fields['date_format'] = 'dd/mm/yyyy';
    $focus->column_fields['hour_format'] = '24';
    $focus->column_fields['start_hour'] = '09:00';
    $focus->column_fields['end_hour'] = '18:00';
    $focus->column_fields['callduration'] = '5';
    $focus->column_fields['othereventduration'] = '5';
    $focus->column_fields['activity_view'] = 'Today';
    $focus->column_fields['lead_view'] = 'Today';

    $focus->save("Users");
    $newuserid = $focus->id;

    // === Create Service Engineer record ===
    $seFocus = Vtiger_Record_Model::getCleanInstance('ServiceEngineer');
    $seFocus->set('mode', 'create');
    $seFocus->set('service_engineer_name', $data['person_name']);
    $seFocus->set('phone', $data['phone']);
    $seFocus->set('email', $data['email']);
    $seFocus->set('user_password', $data['password']);
    $seFocus->set('confirm_password', $data['confirm_password']);
    $seFocus->set('assigned_user_id', $current_user->id);
    $seFocus->set('source', 'CRM');
    $seFocus->set('status', 'Active');
    $seFocus->set('approval_status', 'Accepted');
    $seFocus->set('ser_usr_log_plat', 'Both');
    $seFocus->set('badge_no', $data['username']);
    $seFocus->set('sub_service_manager_role', 'EU Personnel');
    $seFocus->save();

    // === Insert Dashboard Tabs for the new user ===
    $dashboardSql = "INSERT INTO `vtiger_dashboard_tabs`
        (`id`, `tabname`, `isdefault`, `sequence`, `appname`, `modulename`, `userid`)
        VALUES
        (NULL, 'My Dashboard', '1', '1', '', '', ?),
        (NULL, 'Leads', '0', '2', '', '', ?)";
    $adb->pquery($dashboardSql, [$newuserid, $newuserid]);

    // === Update Widgets for 'My Dashboard' ===
    $sql = 'SELECT id FROM vtiger_dashboard_tabs WHERE userid = ? AND tabname = ?';
    $result = $adb->pquery($sql, [$newuserid, 'My Dashboard']);
    if ($adb->num_rows($result) > 0) {
        $dashboardTabId = $adb->query_result($result, 0, 'id');
        $adb->pquery(
            'UPDATE vtiger_module_dashboard_widgets SET userid = ?, dashboardtabid = ? WHERE userid = 1 AND dashboardtabid = 2 AND linkid != 56',
            [$newuserid, $dashboardTabId]
        );
    }

    // === Update Widgets for 'Leads' ===
    $result = $adb->pquery($sql, [$newuserid, 'Leads']);
    if ($adb->num_rows($result) > 0) {
        $dashboardTabId = $adb->query_result($result, 0, 'id');
        $adb->pquery(
            'UPDATE vtiger_module_dashboard_widgets SET userid = ?, dashboardtabid = ? WHERE userid = 1 AND dashboardtabid = 10',
            [$newuserid, $dashboardTabId]
        );
    }

    // === Success response ===
    echo json_encode([
        'status' => 'success',
        'message' => 'Super Admin user created successfully',
        'user_id' => $newuserid
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Error creating user: ' . $e->getMessage()
    ]);
}
