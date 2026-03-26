<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

function AccountsWarrantyStatusUpdate($entityData) {
    global $adb, $log;
    $adb = PearDatabase::getInstance();
    
    $moduleName = $entityData->getModuleName();
    $wsId = $entityData->getId();
    $parts = explode('x', $wsId);
    $entityId = $parts[1];
    
    // Fetch the warranty end date from the entity data
    $warrantyEndDateStr = $entityData->get('warrantyenddate');
    $warrantyEndDateStr = date('d-m-Y',strtotime($warrantyEndDateStr));

    $ContractEndDateStr = $entityData->get('cf_2810');
    $ContractEndDateStr = date('d-m-Y',strtotime($ContractEndDateStr));

    // Get today's date and reset time to midnight for accurate comparison
    $today = date('d-m-Y');

    // Check if today's date is greater than the warranty end date
    if ($today > $warrantyEndDate) {
        // Update the status to 'Inactive' if warranty has expired
        $sql = "UPDATE vtiger_account SET warrantystatus = 'InActive' WHERE accountid = ?";
        $result = $adb->pquery($sql, array($entityId));
        
        if ($result) {
            $log->debug("Warranty status updated to 'Inactive' for entity ID: $entityId");
        } else {
            $log->error("Failed to update warranty status for entity ID: $entityId");
        }
    } else {
        $log->debug("Warranty is still valid for entity ID: $entityId");
    }

    //contract end date update status
    // Check if today's date is greater than the warranty end date
    if ($today > $ContractEndDate) {
        // Update the status to 'Inactive' if warranty has expired
        $sql = "UPDATE vtiger_account SET e_status = 'InActive' WHERE accountid = ?";
        $result = $adb->pquery($sql, array($entityId));
        
        if ($result) {
            $log->debug("Contract status updated to 'Inactive' for entity ID: $entityId");
        } else {
            $log->error("Failed to update Contract status for entity ID: $entityId");
        }
    } else {
        $log->debug("Contract is still valid for entity ID: $entityId");
    }
}
?>
