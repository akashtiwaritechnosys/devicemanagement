<?php
/* +**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.2
 * ("License.txt"); You may not use this file except in compliance with the License
 * The Original Code is: Vtiger CRM Open Source
 * The Initial Developer of the Original Code is Vtiger.
 * Portions created by Vtiger are Copyright (C) Vtiger.
 * All Rights Reserved.
 * ***********************************************************************************/

class Portal_FetchRecord_API extends Portal_Default_API {

	public function process(Portal_Request $request) {

		$module = $request->getModule();
		$language = $request->getLanguage();
		if (null !== ($request->get('parentId'))) {
			$parentId = $request->get('parentId');
			$result = Vtiger_Connector::getInstance()->fetchRecord($request->get('id'), $module, $parentId);
		} else {
			$result = Vtiger_Connector::getInstance()->fetchRecord($request->get('id'), $module, '');
		}

		$response = new Portal_Response();
		$response->setResult($this->processResponse($result, $module, $language));
		return $response;
	}

	public function processResponse($result, $module, $language) {
		$moduleMeta = array();
		$recordMeta = parent::processResponse($module, $language);
		$editFieldNames = array();
		if (!empty($result) && isset($result['record'])) {
			$result['recordInfo'] = $result['record'];
			foreach ($result['record'] as $key => $value) {
				$result['record']['identifierName'] = $recordMeta['labelField'];
				$name = $recordMeta[$key]['label'];
				$editFieldNames[$key] = $recordMeta[$key]['label'];
				if ($recordMeta[$key]['type'] == 'double' || $recordMeta[$key]['type'] == 'currency') {
					$value = round($value, 2);
				} else if ($recordMeta[$key]['type'] == 'picklist' || $recordMeta[$key]['type'] == 'metricpicklist') {
					foreach ($recordMeta[$key]['picklistValues'] as $key1 => $value1) {
						if ($module == 'HelpDesk' && $key == 'ticketstatus') {
							$result['HelpDesk']['isStatusEditable'] = $recordMeta[$key]['editable'];
							if ($value1['value'] == 'Closed') {
								$result['HelpDesk']['closeLabel'] = $value1['label'];
							}
						}

						if ($module == 'Quotes' && $key == 'quotestage') {
							if ($value1['value'] == 'Accepted') {
								$result['Quotes']['acceptLabel'] = $value1['label'];
							}
						}
						if ($result['record'][$key] == $value1['value']) {

							if ($module == 'HelpDesk' && $key == 'ticketstatus' && $value == 'Closed') {
								$result['HelpDesk']['status'] = 'Closed';
							}
							if ($module == 'HelpDesk' && $key == 'ticketstatus' && $value !== 'Closed') {
								$result['HelpDesk']['status'] = 'Open';
							}

							if ($module == 'Quotes' && $key == 'quotestage' && $value == 'Accepted') {
								$result['Quotes']['stage'] = 'Accepted';
							}
							if ($module == 'Quotes' && $key == 'quotestage' && $value !== 'Accepted') {
								$result['Quotes']['stage'] = 'Created';
							}
							$value = $value1['label'];
						}
					}
				} else if ($recordMeta[$key]['type'] == 'multipicklist') {
					$value = str_replace(' |##| ', ",", $value);
				} else if ($recordMeta[$key]['type'] == 'text') {
					$value = strip_tags($value);
					$value = preg_replace('/<br(\s+)?\/?>/i', "\n", $value);
				} else if ($recordMeta[$key]['type'] == 'boolean') {
					$value = $value == 1 ? "Yes" : "No";
				} else if ($recordMeta[$key]['type'] == 'integer' && $module == "Documents" && $key == 'filesize') {
					$value = round(($value / 1024), 2) . 'KB';
				} else if ($recordMeta[$key]['type'] == 'string' && $key == 'filelocationtype' && $module == 'Documents') {
					if ($value !== '' && $value == "I") {
						$value = "Internal";
					}
					if ($value !== '' && $value == "E") {
						$value = "External";
					}
				} else if ($recordMeta[$key]['type'] == 'file' && $key == 'filename' && $module == 'Documents') {
					$docExists = true;
					if ($value == '') {
						$docExists = false;
					}
				} else if ($recordMeta[$key]['type'] == 'reference') {
					$result[$module]['referenceFields'][$name] = $value;
				} else if ($recordMeta[$key]['type'] == 'string' || $recordMeta[$key]['type'] == 'string') {
					$value = strip_tags($value);
				}

				if ($key !== 'id') {
					$result['record'][$name] = $value;
					unset($result['record'][$key]);
				}
				if (is_array($value)) {
					$result['record'][$name] = $value['label'];
					unset($result['record'][$key]);
				}
				if ($docExists && $module == 'Documents') {
					$result['record']['documentExists'] = true;
				}
			}
			$result['editLabels'] = $editFieldNames;
		}
		$moduleFieldGroups = $result['moduleFieldGroups'];
		$fieldsOfCategory = $result['fieldsOfCategory'];
		$modFieldModule = [];
		foreach ($moduleFieldGroups as $blocklabel => $fieldgroups) {
			$blocks = [];
			$blocks['fields'] = [];
			$blocks['blocklabel'] = $blocklabel;
			foreach ($fieldgroups as $fieldname => $fieldinfo) {
				if (!in_array($fieldname, $fieldsOfCategory)) {
					continue;
				}
				$fieldinfo['fieldValue'] = $result['recordInfo'][$fieldname];
				if ($fieldinfo['uitype'] == '10') {
					if (!empty($fieldinfo['fieldValue'])) {
						$fieldinfo['fieldValue'] = $fieldinfo['fieldValue']['label'];
					}
				}
				array_push($blocks['fields'], $fieldinfo);
			}
			array_push($modFieldModule, $blocks);
		}
		$result['moduleFieldGroups'] = $modFieldModule;
		return $result;
	}
}
