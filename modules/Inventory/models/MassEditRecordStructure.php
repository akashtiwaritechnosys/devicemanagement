<?php


/**
 * Mass Edit Record Structure Model
 */
class Inventory_MassEditRecordStructure_Model extends Vtiger_MassEditRecordStructure_Model {

	/**
	 * Function to get the values in stuctured format
	 * @return <array> - values in structure array('block'=>array(fieldinfo));
	 */
	public function getStructure() {
		if(!empty($this->structuredValues)) {
			return $this->structuredValues;
		}

		$values = array();
		$recordModel = $this->getRecord();
		$recordExists = !empty($recordModel);
		$moduleModel = $this->getModule();
		$blockModelList = $moduleModel->getBlocks();
		foreach($blockModelList as $blockLabel=>$blockModel) {
			$fieldModelList = $blockModel->getFields();
			if (!empty ($fieldModelList)) {
				$values[$blockLabel] = array();
				foreach($fieldModelList as $fieldName=>$fieldModel) {
					if($fieldModel->isEditable() && $fieldModel->isMassEditable()) {
						if($fieldModel->isViewable() && $this->isFieldRestricted($fieldModel)) {
							if ($fieldModel->isMandatory()) {
								$dataType = $fieldModel->get('typeofdata');
								$explodeDataType = explode('~', $dataType);
								$fieldModel->set('typeofdata', $explodeDataType[0] . '~O');
							}

							if($recordExists) {
								$fieldModel->set('fieldvalue', $recordModel->get($fieldName));
								if ($fieldName == 'terms_conditions') {
									$fieldModel->set('fieldvalue', $recordModel->getInventoryTermsAndConditions());
								}
							}
							$values[$blockLabel][$fieldName] = $fieldModel;
						}
					}
				}
			}
		}
		$this->structuredValues = $values;
		return $values;
	}
	 
}
