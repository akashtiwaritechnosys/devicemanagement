<?php


class Inventory_MassSave_Action extends Vtiger_MassSave_Action {

	public function process(Vtiger_Request $request) {
		$response = new Vtiger_Response();
		try {
			vglobal('VTIGER_TIMESTAMP_NO_CHANGE_MODE', $request->get('_timeStampNoChangeMode',false));
			$moduleName = $request->getModule();
			$recordModels = $this->getRecordModelsFromRequest($request);
			foreach($recordModels as $recordId => $recordModel) {
				if(Users_Privileges_Model::isPermitted($moduleName, 'Save', $recordId)) {
					//Inventory line items getting wiped out
					$_REQUEST['ajxaction'] = 'DETAILVIEW';
					$recordModel->save();
				}
			}
			vglobal('VTIGER_TIMESTAMP_NO_CHANGE_MODE', false);
			$response->setResult(true);
		} catch (DuplicateException $e) {
			$response->setError($e->getMessage(), $e->getDuplicationMessage(), $e->getMessage());
		} catch (Exception $e) {
			$response->setError($e->getMessage());
		}
		$response->emit();
	}
}
