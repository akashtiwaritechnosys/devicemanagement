<?php

chdir(dirname(__FILE__) . '/../');

include_once 'config.php';
include_once 'include/Webservices/Relation.php';
include_once 'vtlib/Vtiger/Module.php';
include_once 'includes/main/WebUI.php';

global $current_user;
$current_user = Users::getActiveAdminUser();

global $adb;

$sql = "SELECT accountid FROM vtiger_account";
$res = $adb->pquery($sql, array());

$prefix = 'CAN';
$counter = 1;
while ($row = $adb->fetchByAssoc($res)) {
    $accountId = $row['accountid'];

    $newAccountNo = $prefix . str_pad($counter, 3, '0', STR_PAD_LEFT);
    
    // Update account_no in database
    $updateSql = "UPDATE vtiger_account SET account_no = ? WHERE accountid = ?";
    $adb->pquery($updateSql, array($newAccountNo, $accountId));

    $counter++;
}

echo "Account numbers updated successfully!";
