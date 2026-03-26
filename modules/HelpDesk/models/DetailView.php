<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class HelpDesk_DetailView_Model extends Inventory_DetailView_Model {

	/**
	 * Function to get the detail view links (links and widgets)
	 * @param <array> $linkParams - parameters which will be used to calicaulate the params
	 * @return <array> - array of link models in the format as below
	 *                   array('linktype'=>list of link models);
	 */
	public function getDetailViewLinks($linkParams) {
		global $current_user;
		$currentUserRole = $current_user->roleid;
		$userhasApprovePermission = $this->getApprovePermission($currentUserRole, "Closed");
		$currentUserModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();

		$linkModelList = parent::getDetailViewLinks($linkParams);
		$recordModel = $this->getRecord();
		$recordId = $recordModel->getId();
		$currentStatus = $this->getStatusbyRecord($recordId);
		if ($currentStatus == "Spare Part" && $userhasApprovePermission == true){
		       // Define the allowed roles
            $allowedRoles = ['H351', 'H353', 'H355', 'H357', 'H359','H344'];
            
            // Check if the current user's role is in the allowed roles
            if (in_array($currentUserRole, $allowedRoles)) {
			$basicActionLink = array(
				'linktype' => 'DETAILVIEWBASIC',
				'linklabel' => 'Approve Part',
				'linkurl' => "javascript:HelpDesk_Detail_Js.approveOrReject('index.php?module=" . $this->getModule()->getName() .
					"&action=StatusUpdate&record=$recordId&source_module=HelpDesk','Approve')",
				'linkicon' => ''
			);
			$linkModelList['DETAILVIEWBASIC'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);
            
            	$basicActionLink = array(
				'linktype' => 'DETAILVIEWBASIC',
				'linklabel' => 'Reject Part',
				'linkurl' => "javascript:HelpDesk_Detail_Js.approveOrReject('index.php?module=" . $this->getModule()->getName() .
					"&action=StatusUpdate&record=$recordId&source_module=HelpDesk','Reject')",
				'linkicon' => ''
			);
			$linkModelList['DETAILVIEWBASIC'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);
            }
		}
		if ($currentStatus == "Spare Part By Head" && $userhasApprovePermission == true){
		    if($currentUserRole == "H344"){
			$basicActionLink = array(
				'linktype' => 'DETAILVIEWBASIC',
				'linklabel' => 'Approve Part',
				'linkurl' => "javascript:HelpDesk_Detail_Js.approveOrReject('index.php?module=" . $this->getModule()->getName() .
					"&action=StatusUpdate&record=$recordId&source_module=HelpDesk','ApproveByHead')",
				'linkicon' => ''
			);
			$linkModelList['DETAILVIEWBASIC'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);
            
            	$basicActionLink = array(
				'linktype' => 'DETAILVIEWBASIC',
				'linklabel' => 'Reject Part',
				'linkurl' => "javascript:HelpDesk_Detail_Js.approveOrReject('index.php?module=" . $this->getModule()->getName() .
					"&action=StatusUpdate&record=$recordId&source_module=HelpDesk','RejectByHead')",
				'linkicon' => ''
			);
			$linkModelList['DETAILVIEWBASIC'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);
		    }
		}
		if ($currentStatus == "Resolved" && $userhasApprovePermission == true) {
		      // Define the allowed roles
                $allowedRoles = ['H351', 'H353', 'H355', 'H357', 'H359', 'H377'];
                
                // Check if the current user's role is in the allowed roles
                if (in_array($currentUserRole, $allowedRoles)) {
			$basicActionLink = array(
				'linktype' => 'DETAILVIEWBASIC',
				'linklabel' => 'Approve',
				'linkurl' => "javascript:HelpDesk_Detail_Js.approveOrReject('index.php?module=" . $this->getModule()->getName() .
					"&action=StatusUpdate&record=$recordId&source_module=HelpDesk','Accepted')",
				'linkicon' => ''
			);
			$linkModelList['DETAILVIEWBASIC'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);

			$basicActionLink = array(
				'linktype' => 'DETAILVIEWBASIC',
				'linklabel' => 'Reject',
				'linkurl' => "javascript:HelpDesk_Detail_Js.approveOrReject('index.php?module=" . $this->getModule()->getName() .
					"&action=StatusUpdate&record=$recordId&source_module=HelpDesk', 'Reopen')",
				'linkicon' => ''
			);
			$linkModelList['DETAILVIEWBASIC'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);
		    }
		}
		// $invoiceModuleModel = Vtiger_Module_Model::getInstance('Invoice');
		// if($currentUserModel->hasModuleActionPermission($invoiceModuleModel->getId(), 'CreateView')) {
		// 	$basicActionLink = array(
		// 		'linktype' => 'DETAILVIEW',
		// 		'linklabel' => vtranslate('LBL_GENERATE').' '.vtranslate($invoiceModuleModel->getSingularLabelKey(), 'Invoice'),
		// 		'linkurl' => $recordModel->getCreateInvoiceUrl(),
		// 		'linkicon' => ''
		// 	);
		// 	$linkModelList['DETAILVIEW'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);
		// }
		
		// $salesOrderModuleModel = Vtiger_Module_Model::getInstance('SalesOrder');
		// if($currentUserModel->hasModuleActionPermission($salesOrderModuleModel->getId(), 'CreateView')) {
		// 	$basicActionLink = array(
		// 		'linktype' => 'DETAILVIEW',
		// 		'linklabel' => vtranslate('LBL_GENERATE').' '.vtranslate($salesOrderModuleModel->getSingularLabelKey(), 'SalesOrder'),
		// 		'linkurl' => $recordModel->getCreateSalesOrderUrl(),
		// 		'linkicon' => ''
		// 	);
		// 	$linkModelList['DETAILVIEW'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);
		// }

		// $purchaseOrderModuleModel = Vtiger_Module_Model::getInstance('PurchaseOrder');
		// if($currentUserModel->hasModuleActionPermission($purchaseOrderModuleModel->getId(), 'CreateView')) {
		// 	$basicActionLink = array(
		// 		'linktype' => 'DETAILVIEW',
		// 		'linklabel' => vtranslate('LBL_GENERATE').' '.vtranslate($purchaseOrderModuleModel->getSingularLabelKey(), 'PurchaseOrder'),
		// 		'linkurl' => $recordModel->getCreatePurchaseOrderUrl(),
		// 		'linkicon' => ''
		// 	);
		// 	$linkModelList['DETAILVIEW'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);
		// }

		return $linkModelList;
	}
	// public function getDetailViewLinks($linkParams) {
	// 	global $current_user;
	// 	$currentUserRole = $current_user->roleid;
	// 	$userhasApprovePermission = $this->getApprovePermission($currentUserRole, "Closed");
	// 	$currentUserModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
	
	// 	$linkModelList = parent::getDetailViewLinks($linkParams);
	// 	$recordModel = $this->getRecord();
	// 	$recordId = $recordModel->getId();
	// 	$currentStatus = $this->getStatusbyRecord($recordId);
		
	// 	// Get equipment warranty status
	// 	$warrantyStatus = $this->getEquipmentWarrantyStatus($recordId);
		
	// 	// For Spare Part tickets
	// 	if ($currentStatus == "Spare Part") {
	// 		// Define the allowed roles
	// 		$allowedRoles = [];
			
	// 		// Check warranty status to determine approval path
	// 		if ($warrantyStatus == "Under Warranty" || $warrantyStatus == "Under Contract") {
	// 			// For Under Warranty/Contract, Senior Manager approves
	// 			// Role H377 is Senior Manager
	// 			$allowedRoles = ['H377'];
	// 		} else {
	// 			// For Under AMC/out of warranty/contract, Zonal Manager approves
	// 			$allowedRoles = ['H351', 'H353', 'H355', 'H357', 'H359'];
	// 		}
			
	// 		// Check if the current user's role is in the allowed roles
	// 		if (in_array($currentUserRole, $allowedRoles)) {
	// 			$basicActionLink = array(
	// 				'linktype' => 'DETAILVIEWBASIC',
	// 				'linklabel' => 'Approve Part',
	// 				'linkurl' => "javascript:HelpDesk_Detail_Js.approveOrReject('index.php?module=" . $this->getModule()->getName() .
	// 					"&action=StatusUpdate&record=$recordId&source_module=HelpDesk','Approve')",
	// 				'linkicon' => ''
	// 			);
	// 			$linkModelList['DETAILVIEWBASIC'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);
				
	// 			$basicActionLink = array(
	// 				'linktype' => 'DETAILVIEWBASIC',
	// 				'linklabel' => 'Reject Part',
	// 				'linkurl' => "javascript:HelpDesk_Detail_Js.approveOrReject('index.php?module=" . $this->getModule()->getName() .
	// 					"&action=StatusUpdate&record=$recordId&source_module=HelpDesk','Reject')",
	// 				'linkicon' => ''
	// 			);
	// 			$linkModelList['DETAILVIEWBASIC'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);
	// 		}
	// 	}
		
	// 	// For Spare Part By Head (second level approval)
	// 	if ($currentStatus == "Spare Part By Head") {
	// 		$approvalRole = "H344";
			
	// 		// // Check warranty status to determine approval path
	// 		// if ($warrantyStatus == "Under Warranty" || $warrantyStatus == "Under Contract") {
	// 		// 	// For Under Warranty/Contract, goes to Manager after Senior Manager
	// 		// 	// Zonal Managers should approve
	// 		// 	$allowedRoles = ['H351', 'H353', 'H355', 'H357', 'H359'];
	// 		// 	if (in_array($currentUserRole, $allowedRoles)) {
	// 		// 		$approvalRole = $currentUserRole;
	// 		// 	}
	// 		// } else {
	// 			// For Under AMC/out of warranty/contract, Service Head approves
	// 			// if ($currentUserRole == "H344") { // Service Head role
	// 			// 	$approvalRole = $currentUserRole;
	// 			// }
	// 		// }
			
	// 		if (!empty($approvalRole)) {
	// 			$basicActionLink = array(
	// 				'linktype' => 'DETAILVIEWBASIC',
	// 				'linklabel' => 'Approve Part',
	// 				'linkurl' => "javascript:HelpDesk_Detail_Js.approveOrReject('index.php?module=" . $this->getModule()->getName() .
	// 					"&action=StatusUpdate&record=$recordId&source_module=HelpDesk','ApproveByHead')",
	// 				'linkicon' => ''
	// 			);
	// 			$linkModelList['DETAILVIEWBASIC'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);
				
	// 			$basicActionLink = array(
	// 				'linktype' => 'DETAILVIEWBASIC',
	// 				'linklabel' => 'Reject Part',
	// 				'linkurl' => "javascript:HelpDesk_Detail_Js.approveOrReject('index.php?module=" . $this->getModule()->getName() .
	// 					"&action=StatusUpdate&record=$recordId&source_module=HelpDesk','RejectByHead')",
	// 				'linkicon' => ''
	// 			);
	// 			$linkModelList['DETAILVIEWBASIC'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);
	// 		}
	// 	}
		
	// 	if ($currentStatus == "Resolved" && $userhasApprovePermission == true) {

	// 		$allowedRoles = ['H351', 'H353', 'H355', 'H357', 'H359', 'H377'];
			
	// 		// Check if the current user's role is in the allowed roles
	// 		if (in_array($currentUserRole, $allowedRoles)) {
	// 			$basicActionLink = array(
	// 				'linktype' => 'DETAILVIEWBASIC',
	// 				'linklabel' => 'Approve',
	// 				'linkurl' => "javascript:HelpDesk_Detail_Js.approveOrReject('index.php?module=" . $this->getModule()->getName() .
	// 					"&action=StatusUpdate&record=$recordId&source_module=HelpDesk','Accepted')",
	// 				'linkicon' => ''
	// 			);
	// 			$linkModelList['DETAILVIEWBASIC'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);
	
	// 			$basicActionLink = array(
	// 				'linktype' => 'DETAILVIEWBASIC',
	// 				'linklabel' => 'Reject',
	// 				'linkurl' => "javascript:HelpDesk_Detail_Js.approveOrReject('index.php?module=" . $this->getModule()->getName() .
	// 					"&action=StatusUpdate&record=$recordId&source_module=HelpDesk','Reopen')",
	// 				'linkicon' => ''
	// 			);
	// 			$linkModelList['DETAILVIEWBASIC'][] = Vtiger_Link_Model::getInstanceFromValues($basicActionLink);
	// 		}
	// 	}
	
	// 	return $linkModelList;
	// }
	
	// function getEquipmentWarrantyStatus($recordId) {
	// 	global $adb;
	// 	$result = $adb->pquery('SELECT e.eq_run_war_st, e.warranty_status, e.amc_status 
	// 							FROM vtiger_troubletickets t
	// 							JOIN vtiger_equipment e ON t.equipment_id = e.equipmentid
	// 							WHERE t.ticketid = ?', array($recordId));
		
	// 	if ($adb->num_rows($result) > 0) {
	// 		$row = $adb->fetch_array($result);
			
	// 		// Check warranty status
	// 		if ($row['eq_run_war_st'] == 'Under Warranty' || $row['warranty_status'] == 'Under Warranty' || $row['eq_run_war_st'] == 'Under Contract') {
	// 			return $row['eq_run_war_st']; 
	// 		} else if ($row['amc_status'] == 'Under AMC') {
	// 			return 'Under AMC';
	// 		} else {
	// 			return 'Outside Warranty';
	// 		}
	// 	}
		
	// 	return 'Unknown';
	// }

	function getStatusbyRecord($recordId) {
		global $adb;
		$result = $adb->pquery('SELECT `status` FROM `vtiger_troubletickets` where ticketid = ?', array($recordId));
		$num_rows = $adb->num_rows($result);
		if ($num_rows > 0) {
			$dataRow = $adb->fetchByAssoc($result, 0);
			return $dataRow['status'];
		}
	}

	function getApprovePermission($roleid, $ticketstatus) {
		global $adb;
		$sql = "SELECT picklistvalueid FROM `vtiger_role2picklist` INNER JOIN vtiger_ticketstatus ON vtiger_role2picklist.picklistvalueid = vtiger_ticketstatus.picklist_valueid where roleid=? and vtiger_ticketstatus.ticketstatus=?";
		$result = $adb->pquery($sql, array($roleid, $ticketstatus));
		$num_rows = $adb->num_rows($result);
		if($num_rows==0){
			return false;
		}else{
			return true;
		}
	}
		
}
