<?php
error_reporting(0);

class HelpDesk_ApproveOrReject_Action extends Vtiger_IndexAjax_View {

	public function requiresPermission(\Vtiger_Request $request) {
		$permissions = parent::requiresPermission($request);
		$permissions[] = array('module_parameter' => 'source_module', 'action' => 'DetailView', 'record_parameter' => 'record');
		return $permissions;
	}

	public function process(Vtiger_Request $request) {
	    $_REQUEST['action'] = 'HelpDeskAjax';
		$record = $request->get('record');
		$sourceModule = $request->get('source_module');
		$statusValue = $request->get('apStatus');
		$response = new Vtiger_Response();

		$recordModel = Vtiger_Record_Model::getInstanceById($record, $sourceModule);
		if (!empty($recordModel)) {
			$recordModel->set('mode', 'edit');
			global $ajaxEditingInSEmod;
			$ajaxEditingInSEmod = true;
			$recordModel->set('approval_status', $statusValue);
			if ($statusValue == 'Reopen') {
				$rejectionReason = $request->get('m_comment');
				if (empty($rejectionReason)) {
					$response->setResult(array('success' => false, 'message' => 'Rejection Reason Is Empty'));
				}
				
				$recordModel->set('m_comment', $rejectionReason);
				global $adb;
				 $res = $adb->pquery(
					 "INSERT INTO vtiger_troubletickets_comments_history (
						 ticketid, 
						 status,
						 m_comment,  
						 updated_at
					 ) VALUES (?, ?, ?, ?)",
					 array($record, 'Reject', $rejectionReason, date('Y-m-d H:i:s'))
				 );
				 $recordModel->save();
				$recordModel->set('ticketstatus', 'Open');
			}
			else if($statusValue == 'Accepted'){
				$rejectionReason = $request->get('m_comment');
				if (empty($rejectionReason)) {
					$response->setResult(array('success' => false, 'message' => 'Rejection Reason Is Empty'));
				}
				$recordModel->set('m_comment', $rejectionReason);
				global $adb;
				 $res = $adb->pquery(
					 "INSERT INTO vtiger_troubletickets_comments_history (
						 ticketid, 
						 status,
						 m_comment,  
						 updated_at
					 ) VALUES (?, ?, ?, ?)",
					 array($record, 'Accepted', $rejectionReason, date('Y-m-d H:i:s'))
				 );
				 $recordModel->save();
				$recordModel->set('ticketstatus', 'Closed');
			}
			else if ($statusValue == 'Approve') {
				$rejectionReason = $request->get('approvepart_comment');
				if (empty($rejectionReason)) {
					$response->setResult(array('success' => false, 'message' => 'Reason Is Empty'));
				}
				$recordModel->set('approvepart_comment', $rejectionReason);
				
				 global $adb;
				 $res = $adb->pquery(
					 "INSERT INTO vtiger_troubletickets_comments_history (
						 ticketid, 
						 status,
						 approvepart_comment,  
						 updated_at
					 ) VALUES (?, ?, ?, ?)",
					 array($record, $statusValue, $rejectionReason, date('Y-m-d H:i:s'))
				 );
				 $recordModel->save();
			
				$recordModel->set('ticketstatus', 'Spare Part By Head');
			}
			else if ($statusValue == 'Reject') {
				$rejectionReason = $request->get('approvepart_comment');
				if (empty($rejectionReason)) {
					$response->setResult(array('success' => false, 'message' => 'Reason Is Empty'));
				}
				$recordModel->set('approvepart_comment', $rejectionReason);
				global $adb;
				 $res = $adb->pquery(
					 "INSERT INTO vtiger_troubletickets_comments_history (
						 ticketid, 
						 status,
						 approvepart_comment,  
						 updated_at
					 ) VALUES (?, ?, ?, ?)",
					 array($record, $statusValue, $rejectionReason, date('Y-m-d H:i:s'))
				 );
				 $recordModel->save();
				$recordModel->set('ticketstatus', 'InProgress');
			}
			else if ($statusValue == 'ApproveByHead') {
				$rejectionReason = $request->get('approvepart_service');
				if (empty($rejectionReason)) {
					$response->setResult(array('success' => false, 'message' => 'Reason Is Empty'));
				}
				$recordModel->set('approvepart_service', $rejectionReason);
				global $adb;
				$res = $adb->pquery(
					"INSERT INTO vtiger_troubletickets_comments_history (
						ticketid, 
						status,
						approvepart_service,  
						updated_at
					) VALUES (?, ?, ?, ?)",
					array($record, 'Approve', $rejectionReason, date('Y-m-d H:i:s'))
				);
				$recordModel->save();
				$recordModel->set('ticketstatus', 'InProgress');
			}
			else if ($statusValue == 'RejectByHead') {
				$rejectionReason = $request->get('approvepart_service');
				if (empty($rejectionReason)) {
					$response->setResult(array('success' => false, 'message' => 'Reason Is Empty'));
				}
				$recordModel->set('approvepart_service', $rejectionReason);
				global $adb;
				$res = $adb->pquery(
					"INSERT INTO vtiger_troubletickets_comments_history (
						ticketid, 
						status,
						approvepart_service,  
						updated_at
					) VALUES (?, ?, ?, ?)",
					array($record, $statusValue, $rejectionReason, date('Y-m-d H:i:s'))
				);
				$recordModel->save();
				$recordModel->set('ticketstatus', 'InProgress');
			}
			$recordModel->save();
			$ajaxEditingInSEmod = false;
			if ($statusValue == 'Reopen') {
			    header("Location: index.php?module=HelpDesk&view=Detail&record=$record&app=SUPPORT");
			    exit();
				$response->setResult(array('success' => true, 'message' => 'Successfuly Rejected'));
			} else {
			    header("Location: index.php?module=HelpDesk&view=Detail&record=$record&app=SUPPORT");
			    exit();
				$response->setResult(array('success' => true, 'message' => 'Successfuly Approved'));
			}
		} else {
		     header("Location: index.php?module=HelpDesk&view=Detail&record=$record&app=SUPPORT");
			 exit();
			$response->setResult(array('success' => false, 'message' => 'Not Able To Approve Or Reject'));
		}
		$response->emit();
	}

	// public function process(Vtiger_Request $request) {
	// 	$_REQUEST['action'] = 'HelpDeskAjax';
	// 	$record = $request->get('record');
	// 	$sourceModule = $request->get('source_module');
	// 	$statusValue = $request->get('apStatus');
	// 	$response = new Vtiger_Response();
	
	// 	$recordModel = Vtiger_Record_Model::getInstanceById($record, $sourceModule);
	// 	if (!empty($recordModel)) {
	// 		$recordModel->set('mode', 'edit');
	// 		global $ajaxEditingInSEmod;
	// 		$ajaxEditingInSEmod = true;
	// 		$recordModel->set('approval_status', $statusValue);
			
	// 		// Get equipment warranty status
	// 		global $adb;
	// 		$result = $adb->pquery('SELECT e.eq_run_war_st, e.warranty_status, e.amc_status 
	// 							FROM vtiger_troubletickets t
	// 							JOIN vtiger_equipment e ON t.equipment_id = e.equipmentid
	// 							WHERE t.ticketid = ?', array($record));
	// 		$warrantyStatus = 'Unknown';
			
	// 		if ($adb->num_rows($result) > 0) {
	// 			$row = $adb->fetch_array($result);
	// 			if ($row['eq_run_war_st'] == 'Under Warranty' || $row['warranty_status'] == 'Under Warranty' || $row['eq_run_war_st'] == 'Under Contract') {
	// 				$warrantyStatus = $row['eq_run_war_st']; // Either "Under Warranty" or "Under Contract"
	// 			} else if ($row['amc_status'] == 'Under AMC') {
	// 				$warrantyStatus = 'Under AMC';
	// 			} else {
	// 				$warrantyStatus = 'Outside Warranty';
	// 			}
	// 		}
			
	// 		// Handle different statuses
	// 		if ($statusValue == 'Reopen') {
	// 			$rejectionReason = $request->get('m_comment');
	// 			if (empty($rejectionReason)) {
	// 				$response->setResult(array('success' => false, 'message' => 'Rejection Reason Is Empty'));
	// 				return $response;
	// 			}
				
	// 			$recordModel->set('m_comment', $rejectionReason);
	// 			$res = $adb->pquery(
	// 				"INSERT INTO vtiger_troubletickets_comments_history (
	// 					ticketid, 
	// 					status,
	// 					m_comment,  
	// 					updated_at
	// 				) VALUES (?, ?, ?, ?)",
	// 				array($record, 'Reject', $rejectionReason, date('Y-m-d H:i:s'))
	// 			);
	// 			$recordModel->save();
	// 			$recordModel->set('ticketstatus', 'Open');
	// 		}
	// 		else if($statusValue == 'Accepted'){
	// 			$rejectionReason = $request->get('m_comment');
	// 			if (empty($rejectionReason)) {
	// 				$response->setResult(array('success' => false, 'message' => 'Reason Is Empty'));
	// 				return $response;
	// 			}
	// 			$recordModel->set('m_comment', $rejectionReason);
	// 			$res = $adb->pquery(
	// 				"INSERT INTO vtiger_troubletickets_comments_history (
	// 					ticketid, 
	// 					status,
	// 					m_comment,  
	// 					updated_at
	// 				) VALUES (?, ?, ?, ?)",
	// 				array($record, 'Accepted', $rejectionReason, date('Y-m-d H:i:s'))
	// 			);
	// 			$recordModel->save();
	// 			$recordModel->set('ticketstatus', 'Closed');
	// 		}
	// 		else if ($statusValue == 'Approve') {
	// 			$rejectionReason = $request->get('approvepart_comment');
	// 			if (empty($rejectionReason)) {
	// 				$response->setResult(array('success' => false, 'message' => 'Reason Is Empty'));
	// 				return $response;
	// 			}
	// 			$recordModel->set('approvepart_comment', $rejectionReason);
				
	// 			$res = $adb->pquery(
	// 				"INSERT INTO vtiger_troubletickets_comments_history (
	// 					ticketid, 
	// 					status,
	// 					approvepart_comment,  
	// 					updated_at
	// 				) VALUES (?, ?, ?, ?)",
	// 				array($record, $statusValue, $rejectionReason, date('Y-m-d H:i:s'))
	// 			);
	// 			$recordModel->save();
			
	// 			// Set next status based on warranty
	// 			if ($warrantyStatus == 'Under Warranty' || $warrantyStatus == 'Under Contract') {
	// 				// For Under Warranty/Contract, goes from Senior Manager to Manager
	// 				$recordModel->set('ticketstatus', 'Spare Part By Head');
	// 			} else {
	// 				// For Under AMC/out of warranty/contract, also goes from Manager to Service Head
	// 				$recordModel->set('ticketstatus', 'Spare Part By Head');
	// 			}
	// 		}
	// 		else if ($statusValue == 'Reject') {
	// 			$rejectionReason = $request->get('approvepart_comment');
	// 			if (empty($rejectionReason)) {
	// 				$response->setResult(array('success' => false, 'message' => 'Reason Is Empty'));
	// 				return $response;
	// 			}
	// 			$recordModel->set('approvepart_comment', $rejectionReason);
	// 			$res = $adb->pquery(
	// 				"INSERT INTO vtiger_troubletickets_comments_history (
	// 					ticketid, 
	// 					status,
	// 					approvepart_comment,  
	// 					updated_at
	// 				) VALUES (?, ?, ?, ?)",
	// 				array($record, $statusValue, $rejectionReason, date('Y-m-d H:i:s'))
	// 			);
	// 			$recordModel->save();
	// 			$recordModel->set('ticketstatus', 'InProgress');
	// 		}
	// 		else if ($statusValue == 'ApproveByHead') {
	// 			$rejectionReason = $request->get('approvepart_service');
	// 			if (empty($rejectionReason)) {
	// 				$response->setResult(array('success' => false, 'message' => 'Reason Is Empty'));
	// 				return $response;
	// 			}
	// 			$recordModel->set('approvepart_service', $rejectionReason);
	// 			$res = $adb->pquery(
	// 				"INSERT INTO vtiger_troubletickets_comments_history (
	// 					ticketid, 
	// 					status,
	// 					approvepart_service,  
	// 					updated_at
	// 				) VALUES (?, ?, ?, ?)",
	// 				array($record, 'Approve', $rejectionReason, date('Y-m-d H:i:s'))
	// 			);
	// 			$recordModel->save();
	// 			$recordModel->set('ticketstatus', 'InProgress');
	// 		}
	// 		else if ($statusValue == 'RejectByHead') {
	// 			$rejectionReason = $request->get('approvepart_service');
	// 			if (empty($rejectionReason)) {
	// 				$response->setResult(array('success' => false, 'message' => 'Reason Is Empty'));
	// 				return $response;
	// 			}
	// 			$recordModel->set('approvepart_service', $rejectionReason);
	// 			$res = $adb->pquery(
	// 				"INSERT INTO vtiger_troubletickets_comments_history (
	// 					ticketid, 
	// 					status,
	// 					approvepart_service,  
	// 					updated_at
	// 				) VALUES (?, ?, ?, ?)",
	// 				array($record, $statusValue, $rejectionReason, date('Y-m-d H:i:s'))
	// 			);
	// 			$recordModel->save();
	// 			$recordModel->set('ticketstatus', 'InProgress');
	// 		}
	// 		$recordModel->save();
	// 		$ajaxEditingInSEmod = false;
			
	// 		header("Location: index.php?module=HelpDesk&view=Detail&record=$record&app=SUPPORT");
	// 		exit();
	// 	} else {
	// 		header("Location: index.php?module=HelpDesk&view=Detail&record=$record&app=SUPPORT");
	// 		exit();
	// 		$response->setResult(array('success' => false, 'message' => 'Not Able To Approve Or Reject'));
	// 	}
	// 	$response->emit();
	// }
	
}