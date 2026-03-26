<?php


class Inventory_BasicAjax_Action extends Vtiger_BasicAjax_Action {

	public function process(Vtiger_Request $request) {
		$searchValue = $request->get('search_value');
		$searchModule = $request->get('search_module');

		$parentRecordId = $request->get('parent_id');
		$parentModuleName = $request->get('parent_module');
		$relatedModule = $request->get('module');
                $warehouse = $request->get('ware_house');
		$searchModuleModel = Vtiger_Module_Model::getInstance($searchModule);
		$records = $searchModuleModel->searchRecord($searchValue, $parentRecordId, $parentModuleName, $relatedModule,$warehouse);

		//Supporting sequence based search in updation of Inventory record
		$isLineItem = false;
		$sequenceBasedRecords = array();
		if (in_array($searchModule, array('Products', 'Services'))) {
			$isLineItem = true;
			foreach ($records as $moduleName => $recordModels) {
				foreach ($recordModels as $recordId => $recordModel) {
					$records[$moduleName][$recordId] = Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
				}
			}

			$sequenceBasedRecords = $searchModuleModel->searchRecordsOnSequenceNumber($searchValue, $relatedModule);
			if ($sequenceBasedRecords) {
				foreach ($sequenceBasedRecords as $recordId => $recordModel) {
					$records[$searchModule][$recordId] = $recordModel;
				}
			}

			$fieldName = 'product_no';
			if ($searchModule === 'Services') {
				$fieldName = 'service_no';
			}
		}

		$baseRecordId = $request->get('base_record');
		$result = array();
		foreach($records as $moduleName => $recordModels) {
			foreach($recordModels as $recordModel) {
				if($recordModel->getId() != $baseRecordId) {
					$recordLabel = decode_html($recordModel->getName());
					if ($isLineItem) {
						$recordLabel = $recordModel->get($fieldName)." - $recordLabel";
					}
					$result[] = array('label' => $recordLabel, 'value' => $recordLabel, 'id' => $recordModel->getId());
				}
			}
		}

		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	}
}
