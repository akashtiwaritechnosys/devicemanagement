<?php
function CreatePeriodicMaintainence($entityData) {

    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
  global $adb;
    global $log;

    $recordInfo = $entityData->{'data'};
    $id = $recordInfo['id'];
    $id = explode('x', $id);
    $id = $id[1];

    $equipmentId = $recordInfo['equipment_id'];
    $equipmentId = explode('x', $equipmentId);
    $equipmentId = $equipmentId[1];
   print_r("EquipmentId" . $equipmentId); 
    $account_id = $recordInfo['account_id'];
    $account_id = explode('x', $account_id);
    $account_id = $account_id[1];
   print_r("accountId" . $account_id); 
    // Get equipment and account details
    $equipmentDetails = getDetailedEquipmentInfo($equipmentId, $account_id);
    
    require_once('modules/HelpDesk/HelpDesk.php');
    require_once('modules/Users/Users.php');
    require_once('include/utils/GeneralUtils.php');

    $lines = getLineItemDependentCReation($id);
    foreach ($lines as $SerialNumber) {
        $focus = new HelpDesk();
        $focus->id = '';
        $focus->mode = '';
        $warrantyStartDate = date('Y-m-d');
        
        // Basic fields
        $focus->column_fields['parent_id'] = $account_id;
        $focus->column_fields['equipment_id'] = $equipmentId;
        $focus->column_fields['ticket_type'] = 'PREVENTIVE MAINTENANCE SERVICE';
        $focus->column_fields['ticketstatus'] = 'Open';
        $focus->column_fields['cf_2978'] = $SerialNumber;

         if ($equipmentDetails) {
            // Equipment fields
            $focus->column_fields['warrenty_period'] = $equipmentDetails['war_in_months'];
            $focus->column_fields['eq_run_war_st'] = $equipmentDetails['eq_run_war_st'];
            $focus->column_fields['model_number'] = $equipmentDetails['model_number'];

            // Account related fields
            $focus->column_fields['email1'] = $equipmentDetails['account_email'];  // Updated field name
            $focus->column_fields['address'] = $equipmentDetails['bill_street'];
            $focus->column_fields['mobile'] = $equipmentDetails['account_phone'];  // Updated field name
            $focus->column_fields['helpdesk_district'] = $equipmentDetails['account_district'];
            $focus->column_fields['helpdesk_state'] = $equipmentDetails['bill_state'];
            $focus->column_fields['helpdesk_pincode'] = $equipmentDetails['bill_code'];
            $focus->column_fields['helpdesk_country'] = $equipmentDetails['bill_country'];
            $focus->column_fields['helpdesk_city'] = $equipmentDetails['bill_city'];
        }

        $focus->save("HelpDesk");
    }
}

function getDetailedEquipmentInfo($equipmentId, $accountId) {
    global $adb;
    
    $sql = "SELECT 
        e.equipmentid,
        e.productname,
        e.model_number,
        e.eq_run_war_st,
        e.warrenty_period,
        ecf.*,
        a.accountaddressid,
        a.bill_street,
        a.bill_city,
        a.bill_state,
        a.bill_code,
        a.bill_country,
        acc.account_district,
        acc.email1 AS account_email,
        acc.phone AS account_phone
        FROM vtiger_equipment e
        INNER JOIN vtiger_equipmentcf ecf ON e.equipmentid = ecf.equipmentid
        INNER JOIN vtiger_crmentity ce ON e.equipmentid = ce.crmid
        INNER JOIN vtiger_account acc ON acc.accountid = ?
        INNER JOIN vtiger_accountbillads a ON a.accountaddressid = acc.accountid
        WHERE e.equipmentid = ?
        AND ce.deleted = 0";
    
    // Add error logging
    try {
        $result = $adb->pquery($sql, array($accountId, $equipmentId));
        
        if ($result && $adb->num_rows($result) > 0) {
            $equipmentData = $adb->fetch_array($result);
            // Decode HTML entities in the data
            return array_map('decode_html', $equipmentData);
        } else {
            error_log("No results found for equipmentId: $equipmentId and accountId: $accountId");
            return null;
        }
    } catch (Exception $e) {
        error_log("Error in getDetailedEquipmentInfo: " . $e->getMessage());
        return null;
    }
}
function getLineItemDependentCReation($lineitem_id) {
    global $log, $adb;
    $sql = "SELECT payment_date FROM `vtiger_pm_schedule` 
	where id = ?";
    $result = $adb->pquery($sql, array($lineitem_id));
    $dependent = [];
    while ($row = $adb->fetch_array($result)) {
        array_push(
            $dependent,
            $row['payment_date']
        );
    }
    $log->debug("Exiting getLineItemDependent method ...");
    return $dependent;
}
