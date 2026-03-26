<?php
require_once('include/utils/GeneralUtils.php');
class HelpDesk_GetAllInfoCust_Action extends Vtiger_IndexAjax_View {

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
		$referenceFields = array('parent_id');
		foreach($referenceFields as $referenceField){
			$data[$referenceField.'_label'] = Vtiger_Functions::getCRMRecordLabel($data[$referenceField]);
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
		$sql = "SELECT * FROM `vtiger_account` INNER JOIN `vtiger_contactdetails` ON vtiger_account.accountid = vtiger_contactdetails.accountid where accountid = ?";
		$sqlResult = $adb->pquery($sql, array($data['accountid']));
		$num_rows = $adb->num_rows($sqlResult);
		$rowsValue = [];
		if ($num_rows > 0) {
			while ($row = $adb->fetch_array($sqlResult)) {
				$rowsValue = $row;
			}
		}
		$data['firstname'] = $rowsValue['firstname'];
		$data['contactid'] = $rowsValue['contactid'];
		$data['email1'] = $rowsValue['email1'];
		$data['phone'] = $rowsValue['phone'];
        //echo "<pre>"; print_r($response); exit;
		$response->setResult(array('success'=>true, 'data'=>array_map('decode_html',$data)));
		
		$response->emit();
	}
}
