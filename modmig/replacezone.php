<?php

chdir(dirname(__FILE__) . '/../');

include_once 'config.php';
include_once 'include/Webservices/Relation.php';
include_once 'vtlib/Vtiger/Module.php';
include_once 'includes/main/WebUI.php';

global $current_user;
$current_user = Users::getActiveAdminUser();

global $adb;

// // Part 1: Replace with Rajasthan as zone if equipment serial number has customer address as Rajasthan and showing in East zone
$sql1 = "UPDATE vtiger_equipment e
         JOIN vtiger_account a ON e.account_id = a.accountid
         JOIN vtiger_accountbillads ab ON e.account_id = ab.accountaddressid
         JOIN vtiger_crmentity ce ON e.equipmentid = ce.crmid
         SET e.zone = 'RAJASTHAN'
         WHERE e.zone = 'RAJ & UP'
         AND (ab.bill_state LIKE '%Rajasthan%'  
              OR ab.bill_city LIKE '%Rajasthan%' )
         AND ce.deleted = 0";

$result1 = $adb->pquery($sql1, array());
$count1 = $adb->getAffectedRowCount($result1);

// Part 2: All Uttar Pradesh Zone equipment serial numbers should be replaced with North 3 zone
$sql2 = "UPDATE vtiger_equipment e
         JOIN vtiger_account a ON e.account_id = a.accountid
         JOIN vtiger_accountbillads ab ON e.account_id = ab.accountaddressid
         JOIN vtiger_crmentity ce ON e.equipmentid = ce.crmid
         SET e.zone = 'NORTH 3'
         WHERE (ab.bill_state LIKE '%Uttar Pradesh%'  
              OR ab.bill_city LIKE '%Uttar Pradesh%' )
         AND ce.deleted = 0";
$result2 = $adb->pquery($sql2, array());
$count2 = $adb->getAffectedRowCount($result2);

echo "Zone update completed successfully!<br>";
echo "Changed {$count1} equipment records from East to Rajasthan zone.<br>";
echo "Changed {$count2} equipment records from Uttar Pradesh to North 3 zone.<br>";