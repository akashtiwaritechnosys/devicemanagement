<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Accounts_RelationListView_Model extends Vtiger_RelationListView_Model {

	public function getCreateViewUrl() {
		$relationModel = $this->getRelationModel();
		$relatedModel = $relationModel->getRelationModuleModel();
		$parentRecordModule = $this->getParentRecordModel();
		$parentModule = $parentRecordModule->getModule();

		$createViewUrl = $relatedModel->getCreateRecordUrl() . '&returnmode=showRelatedList&returntab_label=' . $this->tab_label .
			'&returnrecord=' . $parentRecordModule->getId() . '&returnmodule=' . $parentModule->getName() .
			'&returnview=Detail&returnrelatedModuleName=' . $this->getRelatedModuleModel()->getName() .
			'&returnrelationId=' . $relationModel->getId();

		if (in_array($relatedModel->getName(), getInventoryModules())) {
			$createViewUrl .= '&relationOperation=true';
		}
		//To keep the reference fieldname and record value in the url if it is direct relation
		if ($relationModel->isDirectRelation()) {
			$relationField = $relationModel->getRelationField();
			$createViewUrl .= '&' . $relationField->getName() . '=' . $parentRecordModule->getId();
		}

		//if parent module has auto fill data it should be automatically filled
		$autoFillData = $parentModule->getAutoFillModuleAndField($parentModule->getName());
		$relatedAutoFillData = $relatedModel->getAutoFillModuleAndField($parentModule->getName());

		if ($autoFillData) {
			//There can be more than one auto-filled field.
			foreach ($autoFillData as $autoFilledField) {
				$parentAutoFillField  = $autoFilledField['fieldname'];
				$parentAutoFillModule = $autoFilledField['module'];
				if ($parentRecordModule->get($parentAutoFillField)) {
					if ($relatedAutoFillData) {
						foreach ($relatedAutoFillData as $relatedAutoFilledField) {
							$relatedAutoFillFieldName = $relatedAutoFilledField['fieldname'];
							$relatedAutoFillModuleName = $relatedAutoFilledField['module'];
							if ($parentAutoFillModule === $relatedAutoFillModuleName) {
								$createViewUrl .= '&' . $relatedAutoFillFieldName . '=' . $parentRecordModule->get($parentAutoFillField);
							}
						}
					}
				}
			}
		}

		return $createViewUrl . "&account_id=".$parentRecordModule->getId();
	}
}
