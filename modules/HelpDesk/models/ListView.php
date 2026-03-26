<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class HelpDesk_ListView_Model extends Vtiger_ListView_Model {
	

	/**
	 * Function to get the list of Mass actions for the module
	 * @param <Array> $linkParams
	 * @return <Array> - Associative array of Link type to List of  Vtiger_Link_Model instances for Mass Actions
	 */
	public function getListViewMassActions($linkParams) {
		$massActionLinks = parent::getListViewMassActions($linkParams);

		$currentUserModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		$emailModuleModel = Vtiger_Module_Model::getInstance('Emails');

		if($currentUserModel->hasModulePermission($emailModuleModel->getId())) {
			$massActionLink = array(
				'linktype' => 'LISTVIEWMASSACTION',
				'linklabel' => 'LBL_SEND_EMAIL',
				'linkurl' => 'javascript:Vtiger_List_Js.triggerSendEmail("index.php?module='.$this->getModule()->getName().'&view=MassActionAjax&mode=showComposeEmailForm&step=step1","Emails");',
				'linkicon' => ''
			);
			$massActionLinks['LISTVIEWMASSACTION'][] = Vtiger_Link_Model::getInstanceFromValues($massActionLink);
		}

		return $massActionLinks;
	}

	public function getListViewEntries($pagingModel) {
		$db = PearDatabase::getInstance();

		$moduleName = $this->getModule()->get('name');
		$moduleFocus = CRMEntity::getInstance($moduleName);
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);

		$queryGenerator = $this->get('query_generator');
		$listViewContoller = $this->get('listview_controller');

		$searchParams = $this->get('search_params');
		if (empty($searchParams)) {
			$searchParams = array();
		}
		$glue = "";
		if (count($queryGenerator->getWhereFields()) > 0 && (count($searchParams)) > 0) {
			$glue = QueryGenerator::$AND;
		}
		$queryGenerator->parseAdvFilterList($searchParams, $glue);

		$vtFilterIterator = 0;
		global $fetchinFormMobile;
        // if ($fetchinFormMobile && !empty($this->get('searchAllFieldsValue'))) {
        //     $fields = $queryGenerator->getFields();
		// 	$fieldModels = $queryGenerator->getModuleFields();
		// 	$goodFit = [];
		// 	$uniqueFields = [];
		// 	foreach ($fields as $value) {
		// 		$fieldModelOfField = $fieldModels[$value];
        //         if (($fieldModelOfField && ($fieldModelOfField->getFieldDataType() == 'date'|| $fieldModelOfField->getFieldDataType() == 'datetime')) || $value == 'id' || $value == 'starred') {
		// 			continue;
        //         } else {
		// 			if (in_array($value, $uniqueFields)) {
		// 				continue;
		// 			}
		// 			array_push($uniqueFields, $value);
		// 			array_push($goodFit,$value);
		// 		}
        //     }
		// 	$lastField = $goodFit[(count($goodFit) -1)];
		// 	$firstField = $goodFit[0];
		// 	$uniqueFields = [];
		// 	foreach ($fields as $value) {
		// 		if (in_array($value, $uniqueFields)) {
		// 			continue;
		// 		}
		// 		array_push($uniqueFields, $value);
		// 		$fieldModelOfField = $fieldModels[$value];
		// 		if (($fieldModelOfField && ($fieldModelOfField->getFieldDataType() == 'date' || $fieldModelOfField->getFieldDataType() == 'datetime')) || $value == 'id' || $value == 'starred') {
		// 			continue;
		// 		}
		// 		if ($firstField == $value) {
		// 			if (empty($searchParams)) {
		// 				$queryGenerator->startGroup('');
		// 			} else {
		// 				$queryGenerator->startGroup('AND');
		// 			}
		// 			$queryGenerator->addCondition($value, $this->get('searchAllFieldsValue'), 'c', "");
		// 		} else if ($value == $lastField) {
		// 			$queryGenerator->addCondition($value, $this->get('searchAllFieldsValue'), 'c', "OR");
		// 			$queryGenerator->endGroup();
		// 		} else {
		// 			$queryGenerator->addCondition($value, $this->get('searchAllFieldsValue'), 'c', "OR");
		// 		}
		// 		$vtFilterIterator = $vtFilterIterator + 1;
		// 	}
        // }
		
		if ($fetchinFormMobile && !empty($this->get('searchAllFieldsValue'))) {
			$searchValue = trim($this->get('searchAllFieldsValue'));
			$fields = $queryGenerator->getFields();
			$fieldModels = $queryGenerator->getModuleFields();
			
			// Add fields that should be searched
			$searchableFields = [];
			
			foreach ($fields as $value) {
				$fieldModelOfField = $fieldModels[$value];
				// Skip date fields, id fields, and starred fields
				if (($fieldModelOfField && ($fieldModelOfField->getFieldDataType() == 'date' || 
					$fieldModelOfField->getFieldDataType() == 'datetime')) || 
					$value == 'id' || $value == 'starred') {
					continue;
				}
				
				// Include only text, string, phone, email, and reference fields
				if ($fieldModelOfField && in_array($fieldModelOfField->getFieldDataType(), 
					['text', 'string', 'phone', 'email', 'reference'])) {
					$searchableFields[] = $value;
				}
			}
			
			// Make sure we have fields to search
			if (!empty($searchableFields)) {
				if (empty($searchParams)) {
					$queryGenerator->startGroup('');
				} else {
					$queryGenerator->startGroup('AND');
				}
				
				// Add conditions for each searchable field
				$firstField = true;
				foreach ($searchableFields as $field) {
					if ($firstField) {
						$queryGenerator->addCondition($field, $searchValue, 'c', "");
						$firstField = false;
					} else {
						$queryGenerator->addCondition($field, $searchValue, 'c', "OR");
					}
				}
				
				$queryGenerator->endGroup();
			}
		}
		$searchKey = $this->get('search_key');
		$searchValue = $this->get('search_value');
		$operator = $this->get('operator');
		if (!empty($searchKey)) {
			$queryGenerator->addUserSearchConditions(array('search_field' => $searchKey, 'search_text' => $searchValue, 'operator' => $operator));
		}

		$orderBy = $this->getForSql('orderby');
		$sortOrder = $this->getForSql('sortorder');

		if (!empty($orderBy)) {
			$queryGenerator = $this->get('query_generator');
			$fieldModels = $queryGenerator->getModuleFields();
			$orderByFieldModel = $fieldModels[$orderBy];
			if ($orderByFieldModel && ($orderByFieldModel->getFieldDataType() == Vtiger_Field_Model::REFERENCE_TYPE ||
				$orderByFieldModel->getFieldDataType() == Vtiger_Field_Model::OWNER_TYPE)) {
				$queryGenerator->addWhereField($orderBy);
			}
		}
		$listQuery = $this->getQuery();

		$sourceModule = $this->get('src_module');
		if (!empty($sourceModule)) {
			if (method_exists($moduleModel, 'getQueryByModuleField')) {
				$overrideQuery = $moduleModel->getQueryByModuleField($sourceModule, $this->get('src_field'), $this->get('src_record'), $listQuery, $this->get('relationId'));
				if (!empty($overrideQuery)) {
					$listQuery = $overrideQuery;
				}
			}
		}

		$startIndex = $pagingModel->getStartIndex();
		$pageLimit = $pagingModel->getPageLimit();
		$paramArray = array();

		if (!empty($orderBy) && $orderByFieldModel) {
			if ($orderBy == 'roleid' && $moduleName == 'Users') {
				$listQuery .= ' ORDER BY vtiger_role.rolename ' . ' ' . $sortOrder;
			} else {
				$listQuery .= ' ORDER BY ' . $queryGenerator->getOrderByColumn($orderBy) . ' ' . $sortOrder;
			}

			if ($orderBy == 'first_name' && $moduleName == 'Users') {
				$listQuery .= ' , last_name ' . ' ' . $sortOrder . ' ,  email1 ' . ' ' . $sortOrder;
			}
		} else if (empty($orderBy) && empty($sortOrder) && $moduleName != "Users") {
			$listQuery .= ' ORDER BY vtiger_crmentity.modifiedtime DESC';
		}
        // print_r($listQuery);
        // die();

		$viewid = ListViewSession::getCurrentView($moduleName);
		if (empty($viewid)) {
			$viewid = $pagingModel->get('viewid');
		}
		$_SESSION['lvs'][$moduleName][$viewid]['start'] = $pagingModel->get('page');

		ListViewSession::setSessionQuery($moduleName, $listQuery, $viewid);

		$listQuery .= " LIMIT ?, ?";
		array_push($paramArray, $startIndex);
		array_push($paramArray, ($pageLimit + 1));

		$listResult = $db->pquery($listQuery, $paramArray);

		$listViewRecordModels = array();
		$listViewEntries =  $listViewContoller->getListViewRecords($moduleFocus, $moduleName, $listResult);

		$pagingModel->calculatePageRange($listViewEntries);

		if ($db->num_rows($listResult) > $pageLimit) {
			array_pop($listViewEntries);
			$pagingModel->set('nextPageExists', true);
		} else {
			$pagingModel->set('nextPageExists', false);
		}

		$index = 0;
		foreach ($listViewEntries as $recordId => $record) {
			$rawData = $db->query_result_rowdata($listResult, $index++);
			$record['id'] = $recordId;
			$listViewRecordModels[$recordId] = $moduleModel->getRecordFromArray($record, $rawData);
		}
		return $listViewRecordModels;
	}

	public function getListViewCount() {
		$db = PearDatabase::getInstance();

		$queryGenerator = $this->get('query_generator');


		$searchParams = $this->get('search_params');
		if (empty($searchParams)) {
			$searchParams = array();
		}

		// for Documents folders we should filter with folder id as well
		$folderKey = $this->get('folder_id');
		$folderValue = $this->get('folder_value');
		if (!empty($folderValue)) {
			$queryGenerator->addCondition($folderKey, $folderValue, 'e');
		}

		$glue = "";
		if (count($queryGenerator->getWhereFields()) > 0 && (count($searchParams)) > 0) {
			$glue = QueryGenerator::$AND;
		}
		$queryGenerator->parseAdvFilterList($searchParams, $glue);

		$vtFilterIterator = 0;
		global $fetchinFormMobile;
        if ($fetchinFormMobile && !empty($this->get('searchAllFieldsValue'))) {
            $fields = $queryGenerator->getFields();
			$fieldModels = $queryGenerator->getModuleFields();
			$goodFit = [];
			$uniqueFields = [];
			foreach ($fields as $value) {
				$fieldModelOfField = $fieldModels[$value];
                if (($fieldModelOfField && ($fieldModelOfField->getFieldDataType() == 'date'|| $fieldModelOfField->getFieldDataType() == 'datetime')) || $value == 'id' || $value == 'starred') {
					continue;
                } else {
					if (in_array($value, $uniqueFields)) {
						continue;
					}
					array_push($uniqueFields, $value);
					array_push($goodFit,$value);
				}
            }
			$lastField = $goodFit[(count($goodFit) -1)];
			$firstField = $goodFit[0];
			$uniqueFields = [];
			foreach ($fields as $value) {
				if (in_array($value, $uniqueFields)) {
					continue;
				}
				array_push($uniqueFields, $value);
				$fieldModelOfField = $fieldModels[$value];
				if (($fieldModelOfField && ($fieldModelOfField->getFieldDataType() == 'date' || $fieldModelOfField->getFieldDataType() == 'datetime')) || $value == 'id' || $value == 'starred') {
					continue;
				}
				if ($firstField == $value) {
					if (empty($searchParams)) {
						$queryGenerator->startGroup('');
					} else {
						$queryGenerator->startGroup('AND');
					}
					$queryGenerator->addCondition($value, $this->get('searchAllFieldsValue'), 'c', "");
				} else if ($value == $lastField) {
					$queryGenerator->addCondition($value, $this->get('searchAllFieldsValue'), 'c', "OR");
					$queryGenerator->endGroup();
				} else {
					$queryGenerator->addCondition($value, $this->get('searchAllFieldsValue'), 'c', "OR");
				}
				$vtFilterIterator = $vtFilterIterator + 1;
			}
        }

		$searchKey = $this->get('search_key');
		$searchValue = $this->get('search_value');
		$operator = $this->get('operator');
		if (!empty($searchKey)) {
			$queryGenerator->addUserSearchConditions(array('search_field' => $searchKey, 'search_text' => $searchValue, 'operator' => $operator));
		}
		$moduleName = $this->getModule()->get('name');
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);

		$listQuery = $this->getQuery();
		$sourceModule = $this->get('src_module');
		if (!empty($sourceModule)) {
			$moduleModel = $this->getModule();
			if (method_exists($moduleModel, 'getQueryByModuleField')) {
				$overrideQuery = $moduleModel->getQueryByModuleField($sourceModule, $this->get('src_field'), $this->get('src_record'), $listQuery);
				if (!empty($overrideQuery)) {
					$listQuery = $overrideQuery;
				}
			}
		}
		$position = stripos($listQuery, ' from ');
		if ($position) {
			$split = preg_split('/ from /i', $listQuery);
			$splitCount = count($split);
			// If records is related to two records then we'll get duplicates. Then count will be wrong
			$meta = $queryGenerator->getMeta($this->getModule()->getName());
			$columnIndex = $meta->getObectIndexColumn();
			$baseTable = $meta->getEntityBaseTable();
			$listQuery = "SELECT count(distinct($baseTable.$columnIndex)) AS count ";
			for ($i = 1; $i < $splitCount; $i++) {
				$listQuery = $listQuery . ' FROM ' . $split[$i];
			}
		}

		if ($this->getModule()->get('name') == 'Calendar') {
			$listQuery .= ' AND activitytype <> "Emails"';
		}

		require_once('include/utils/GeneralUtils.php');
		global $current_user;
		$data = getUserDetailsBasedOnEmployeeModuleG($current_user->user_name);
		if (empty($data)) {
		} else {
			// List view will be displayed on recently created/modified records
			require_once('include/utils/GeneralUtils.php');
			global $popupEntryFromSEMOdal, $popupEntryFromSEMOdalsourceRecord;
			if ($popupEntryFromSEMOdal == true) {
			} else {
				$functionalLocations = getOnlyLinkedEquimentsSEHelpDesk($data['serviceengineerid']);
				if (empty($data)) {
				} else {
					if ($data['sub_service_manager_role'] == 'EU Personnel') {
						$listQuery = $listQuery . ' AND (vtiger_troubletickets.ticketid IN ("' . implode('","', $functionalLocations) . '") OR vtiger_crmentity.smcreatorid = '.$current_user->id.')';
					}
				}
			}
			$listQuery .= ' ORDER BY vtiger_crmentity.modifiedtime DESC';
		}
		$listResult = $db->pquery($listQuery, array());
		return $db->query_result($listResult, 0, 'count');
	}
}
?>
