<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

function AccountsWarrantyCountdownUpdate($entityData) {
    global $adb, $log;
    $adb = PearDatabase::getInstance();
    
    $moduleName = $entityData->getModuleName();
    $wsId = $entityData->getId();
    $parts = explode('x', $wsId);
    $entityId = $parts[1];
    
    // Fetch the warranty dates from the entity data
    $warrantyStartDateStr = $entityData->get('warrantystartdate');
    $warrantyEndDateStr = $entityData->get('warrantyenddate');

    // Convert date strings to DateTime objects for accurate comparisons
    $warrantyStartDate = new DateTime($warrantyStartDateStr);
    $warrantyEndDate = new DateTime($warrantyEndDateStr);
    $today = new DateTime(); // Current date and time
    
    // Convert DateTime objects to Y-m-d format for SQL comparisons
    $todayFormatted = $today->format('Y-m-d');
    $warrantyStartDateFormatted = $warrantyStartDate->format('Y-m-d');
    $warrantyEndDateFormatted = $warrantyEndDate->format('Y-m-d');


    // Update dayleftinwarranty based on the conditions
    if ($todayFormatted >= $warrantyStartDateFormatted && $todayFormatted <= $warrantyEndDateFormatted) {
        // Warranty is active: Calculate days left in warranty
        $sql = "UPDATE vtiger_account
                SET dayleftinwarranty = ABS(DATEDIFF(warrantystartdate, CURDATE()))
                WHERE accountid = ?";
        $result = $adb->pquery($sql, array($entityId));
        
        if ($result) {
            $log->debug("Day left in warranty updated for entity ID: $entityId");
        } else {
            $log->error("Failed to update day left in warranty for entity ID: $entityId");
        }
    } elseif ($todayFormatted > $warrantyEndDateFormatted) {
        // Warranty is expired: Calculate negative days past warranty
        $sql = "UPDATE vtiger_account
                SET dayleftinwarranty = -DATEDIFF(CURDATE(), warrantyenddate)
                WHERE accountid = ?";
        $result = $adb->pquery($sql, array($entityId));
        
        if ($result) {
            $log->debug("Day left in warranty updated to negative value for entity ID: $entityId");
        } else {
            $log->error("Failed to update day left in warranty for entity ID: $entityId");
        }
    } else {
        // Warranty hasn't started yet or expired before today
        $log->debug("Warranty status does not require update for entity ID: $entityId");
    }
}
?>
