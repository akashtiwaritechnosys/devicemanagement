<?php
require_once('include/utils/GeneralUtils.php');
class PeriodicalMaintainence_GetAllInfoEquipment_Action extends Vtiger_IndexAjax_View {

    public function requiresPermission(\Vtiger_Request $request) {
		$permissions = parent::requiresPermission($request);
		$permissions[] = array('module_parameter' => 'source_module', 'action' => 'DetailView', 'record_parameter' => 'record');
		$permissions = [];
		return $permissions;
	}

	public function process(Vtiger_Request $request) {
		$record = $request->get('record');
		$sourceModule = $request->get('source_module');
		$response = new Vtiger_Response();

		$recordModel = Vtiger_Record_Model::getInstanceById($record, $sourceModule);
		$data = $recordModel->getData();
		$referenceFields = array('account_id');
		foreach ($referenceFields as $referenceField) {
			$data[$referenceField . '_label'] = Vtiger_Functions::getCRMRecordLabel($data[$referenceField]);
		}

		// $data['product_name'] = '';
		// if(!empty($data['equipment_id'])){
		//     $dataArr = getSingleColumnValue(array(
		//         'table' => 'vtiger_equipment',
		//         'columnId' => 'equipmentid',
		//         'idValue' => $data['equipment_id'],
		//         'expectedColValue' => 'productname'
		//     ));
		//     $data['product_name'] = $dataArr[0]['productname'];
		// }

		global $adb;
		$sql = "SELECT productname,model_number,warrenty_period FROM 
		`vtiger_equipment` where equipmentid = ?";
		$sqlResult = $adb->pquery($sql, array($data['equipment_id']));
		$num_rows = $adb->num_rows($sqlResult);
		$rowsValue = [];
		if ($num_rows > 0) {
			while ($row = $adb->fetch_array($sqlResult)) {
				$rowsValue = $row;
			}
		}

		$organisationId = $data['account_id'];
		if (!empty($organisationId) && isRecordExists($organisationId)) {
			$orgRecord = Vtiger_Record_Model::getInstanceById($organisationId);
			$data['email1'] = $orgRecord->get('email1');
			$data['bill_street'] = $orgRecord->get('bill_street');
			$data['phone'] = $orgRecord->get('phone');
			$data['helpdesk_district'] = $orgRecord->get('account_district');
			$data['helpdesk_state'] = $orgRecord->get('bill_state');
			$data['helpdesk_pincode'] = $orgRecord->get('bill_code');
			$data['helpdesk_country'] = $orgRecord->get('bill_country');
			$data['helpdesk_city'] = $orgRecord->get('bill_city');

		}
		$data['warrenty_period'] = $rowsValue['warrenty_period'];
		$data['productname'] = $rowsValue['productname'];

		$response->setResult(array('success' => true, 'data' => array_map('decode_html', $data)));

		$response->emit();
	}
}

