<?php

class Mobile_WS_CheckDuplicateTicket extends Mobile_WS_Controller {
	
	function process(Mobile_API_Request $request) {
		global $current_user;
		$current_user = $this->getActiveUser();
		
		$response = new Mobile_API_Response();
		
		// Get individual request parameters directly
		$equipment_id = $request->get('equipment_id');
		$model_number = $request->get('model_number');
		
		// Optional parameters to carry forward
		// $parent_id = $request->get('parent_id');
		// $parent_idLabel = $request->get('parent_idLabel');
		// $date_of_failure = $request->get('date_of_failure');
		// $equip_status = $request->get('equip_status');
		// $sr_equip_model = $request->get('sr_equip_model');
		// $address = $request->get('address');
		// $mobile = $request->get('mobile');
		// $helpdesk_city = $request->get('helpdesk_city');
		// $helpdesk_state = $request->get('helpdesk_state');
		// $helpdesk_district = $request->get('helpdesk_district');
		// $helpdesk_pincode = $request->get('helpdesk_pincode');
		// $helpdesk_country = $request->get('helpdesk_country');
		
		// Validate required parameters
		if (empty($equipment_id) || empty($model_number)) {
			$response->setError(1501, "Equipment ID and Model Number are required parameters!");
			return $response;
		}
		
		try {
			$values = array(
				'equipment_id' => $equipment_id,
				'model_number' => $model_number
			);
			
			$result = $this->checkDuplicateTicket($values);
			
			$data = array(
				'isDuplicate' => $result['isDuplicate'],
				'message' => $result['message'],
			);
			
			$response->setResult($data);
            $response->setApiSucessMessage("Successfully Checked the data");
			return $response;
			
		} catch (Exception $e) {
			$response->setError($e->getCode(), $e->getMessage());
		}
		
		return $response;
	}
	
	/**
	 * Check if a duplicate ticket exists for the given equipment ID and model number
	 * 
	 * @param array $values Array containing equipment_id and model_number
	 * @return array Result with isDuplicate flag and message
	 */
	function checkDuplicateTicket($values) {
		global $adb;
		
		$result = array('isDuplicate' => false, 'message' => '');
		
		$serialNumberWithPrefix = $values['equipment_id'] ?? '';
		$modelNumber = $values['model_number'] ?? '';
	
		if (empty($serialNumberWithPrefix) || empty($modelNumber)) {
			return $result;
		}
		
		$actualId = $serialNumberWithPrefix;
		if (strpos($serialNumberWithPrefix, 'x') !== false) {
			$parts = explode('x', $serialNumberWithPrefix);
			if (count($parts) == 2) {
				$actualId = $parts[1]; 
			}
		}
	
		// Query to check for any ticket that is not closed
		$query = "SELECT vtiger_troubletickets.ticketid, vtiger_troubletickets.ticket_no, 
						 vtiger_troubletickets.equipment_id 
				  FROM vtiger_troubletickets 
				  WHERE vtiger_troubletickets.model_number = ? 
				  AND vtiger_troubletickets.status != 'Closed'";
		
		$queryResult = $adb->pquery($query, array($modelNumber));
		
		$isDuplicate = false;
		$duplicateTicketNo = '';
		
		$numRows = $adb->num_rows($queryResult);
		for ($i = 0; $i < $numRows; $i++) {
			$dbEquipmentId = $adb->query_result($queryResult, $i, 'equipment_id');
			$dbTicketNo = $adb->query_result($queryResult, $i, 'ticket_no');
			
			$dbActualId = $dbEquipmentId;
			if (strpos($dbEquipmentId, 'x') !== false) {
				$dbParts = explode('x', $dbEquipmentId);
				if (count($dbParts) == 2) {
					$dbActualId = $dbParts[1];
				}
			}
	
			if ($dbActualId === $actualId) {
				$isDuplicate = true;
				$duplicateTicketNo = $dbTicketNo;
				break;
			}
		}
	
		if ($isDuplicate) {
			$result['isDuplicate'] = true;
			$result['message'] = "A ticket already exists for this equipment Serial No and Model No and is not yet closed. Existing ticket number: $duplicateTicketNo";
		}

        if (!$isDuplicate) {
			$result['isDuplicate'] = false;
			$result['message'] = "A  new ticket for  this equipment Serial No and Model No is valid to  create.";
		}
		
		return $result;
	}
}