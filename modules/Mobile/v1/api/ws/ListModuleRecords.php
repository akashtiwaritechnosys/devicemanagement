<?php
include_once dirname(__FILE__) . '/models/Alert.php';
include_once dirname(__FILE__) . '/models/SearchFilter.php';
include_once dirname(__FILE__) . '/models/Paging.php';

class Mobile_WS_ListModuleRecords extends Mobile_WS_Controller {

	function isCalendarModule($module) {
		return ($module == 'Events' || $module == 'Calendar');
	}

	function getSearchFilterModel($module, $search) {
		return Mobile_WS_SearchFilterModel::modelWithCriterias($module, Zend_JSON::decode($search));
	}

	function getPagingModel(Mobile_API_Request $request) {
		$page = $request->get('page', 0);
		return Mobile_WS_PagingModel::modelWithPageStart($page);
	}
	
	//vaibhavi
	function fetchUserNameById($userId) {
        global $adb;

        if (is_numeric($userId)) {
            $query = "SELECT CONCAT(first_name, ' ', last_name) AS name FROM vtiger_users WHERE id = ?";
            $result = $adb->pquery($query, [$userId]);
            if ($adb->num_rows($result) > 0) {
                $userName = $adb->query_result($result, 0, 'name');
            } else {
                $query = "SELECT groupname AS name FROM vtiger_groups WHERE groupid = ?";
                $result = $adb->pquery($query, [$userId]);
                if ($adb->num_rows($result) > 0) {
                    $userName = $adb->query_result($result, 0, 'name');
                }
            }
        }
        return $userName;
    }
    //end


	function processHelpDeskWithRoleFiltering(Mobile_API_Request $request) {
		global $current_user, $adb;
		
		if (!$current_user || empty($current_user->id)) {
			$response = new Mobile_API_Response();
			$response->setError(401, "Unauthorized access");
			return $response;
		}
		
		$roleId = $current_user->roleid;
		$module = 'HelpDesk';
		
		// Get request parameters
		$ticketStatus = $request->get('ticketstatus');
		$searchAllFieldsValue = $request->get('searchAllFieldsValue');
		$searchParams = $request->get('search_params');
		$page = $request->get('page') ? (int)$request->get('page') : 1;
		$limit = 10;
		$offset = ($page - 1) * $limit;
		
		
		// Build search conditions function
		$buildSearchConditions = function($searchParams, &$params) {
			$searchConditions = [];
			
			if (!empty($searchParams)) {
				$searchArray = json_decode($searchParams, true);
				if (is_array($searchArray)) {
					foreach ($searchArray as $searchItem) {
						if (is_array($searchItem) && count($searchItem) >= 3) {
							$field = $searchItem[0];
							$operator = $searchItem[1];
							$value = $searchItem[2];
							
							$fieldMapping = [
								'priority' => 'vtiger_troubletickets.priority',
								'ticketstatus' => 'vtiger_troubletickets.status',
								'status' => 'vtiger_troubletickets.status',
								'ticket_type' => 'vtiger_troubletickets.ticket_type',
								'description' => 'vtiger_crmentity.description',
								'mobile' => 'vtiger_troubletickets.mobile',
								'ticket_no' => 'vtiger_troubletickets.ticket_no',
								'parent_id' => 'vtiger_account.accountname',
								'equipment_id' => 'vtiger_equipment.equipment_serialno',
							];
							
							if (isset($fieldMapping[$field])) {
								$dbField = $fieldMapping[$field];
								
								switch (strtolower($operator)) {
									case 'e':
										$searchConditions[] = "$dbField = ?";
										$params[] = $value;
										break;
									case 'c':
										$searchConditions[] = "$dbField LIKE ?";
										$params[] = '%' . $value . '%';
										break;
									case 'n':
										$searchConditions[] = "$dbField != ?";
										$params[] = $value;
										break;
									default:
										$searchConditions[] = "$dbField = ?";
										$params[] = $value;
										break;
								}
							}
						}
					}
				}
			}
			return $searchConditions;
		};
		
		$baseQuery = "SELECT 
						vtiger_troubletickets.*,
						vtiger_crmentity.crmid,
						vtiger_crmentity.smownerid,
						vtiger_crmentity.smcreatorid,
						vtiger_crmentity.createdtime,
						vtiger_crmentity.modifiedtime,
						vtiger_crmentity.description,
						vtiger_equipment.equipment_serialno,
						vtiger_account.accountname,
						vtiger_users.last_name as assigned_user_name,
						vtiger_users2.last_name as creator_name,
						vtiger_ticketcf.cf_3038
					FROM vtiger_troubletickets
					INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_troubletickets.ticketid
					LEFT JOIN vtiger_equipment ON vtiger_equipment.equipmentid = vtiger_troubletickets.equipment_id
					LEFT JOIN vtiger_account ON vtiger_account.accountid = vtiger_troubletickets.parent_id
					LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid
					LEFT JOIN vtiger_users vtiger_users2 ON vtiger_users2.id = vtiger_crmentity.smcreatorid
					LEFT JOIN vtiger_ticketcf ON vtiger_ticketcf.ticketid = vtiger_troubletickets.ticketid
					WHERE vtiger_crmentity.deleted = 0";
		
		$countQuery = "SELECT COUNT(*) AS total 
					FROM vtiger_troubletickets 
					INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_troubletickets.ticketid
					LEFT JOIN vtiger_equipment ON vtiger_equipment.equipmentid = vtiger_troubletickets.equipment_id
					LEFT JOIN vtiger_account ON vtiger_account.accountid = vtiger_troubletickets.parent_id
					LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid
					LEFT JOIN vtiger_ticketcf ON vtiger_ticketcf.ticketid = vtiger_troubletickets.ticketid
					WHERE vtiger_crmentity.deleted = 0";
		
		$params = [];
		$countParams = [];
		
		// Apply role-based filtering
		if ($roleId === 'H378') {
			// Customer role - filter by linked account
			$getAccountQuery = $adb->pquery(
				"SELECT vtiger_account.accountid
				FROM vtiger_users
				INNER JOIN vtiger_account ON vtiger_account.email1 = vtiger_users.email1
				WHERE vtiger_users.id = ?",
				[$current_user->id]
			);
			
			if ($adb->num_rows($getAccountQuery) > 0) {
				$customerId = $adb->query_result($getAccountQuery, 0, 'accountid');
				if (!empty($customerId)) {
					$baseQuery .= " AND vtiger_troubletickets.parent_id = ?";
					$countQuery .= " AND vtiger_troubletickets.parent_id = ?";
					$params[] = $customerId;
					$countParams[] = $customerId;
				} else {
					// No account found, return empty result
					$response = new Mobile_API_Response();
					$response->setResult([
						'records' => [],
						'headers' => $this->getHelpDeskHeaders(),
						'pagination' => ['total' => 0, 'page' => 1, 'limit' => $limit, 'total_pages' => 0, 'moreRecords' => false]
					]);
					return $response;
				}
			}
		} elseif (in_array($roleId, ['H352','H354','H356','H360','H361','H362','H366','H369','H372'])) {
			// Service Engineer role - filter by assigned engineer
			$baseQuery .= " AND vtiger_crmentity.smownerid = ?";
			$countQuery .= " AND vtiger_crmentity.smownerid = ?";
			$params[] = $current_user->id;
			$countParams[] = $current_user->id;
		}
		
		$searchConditions = $buildSearchConditions($searchParams, $params);
		$searchConditionsCount = $buildSearchConditions($searchParams, $countParams);
		
		if (!empty($searchConditions)) {
			$baseQuery .= " AND " . implode(" AND ", $searchConditions);
			$countQuery .= " AND " . implode(" AND ", $searchConditionsCount);
		}
		
		if (!empty($ticketStatus)) {
			error_log("DEBUG: Filtering by ticket status: " . $ticketStatus);
			$baseQuery .= " AND vtiger_troubletickets.status = ?";
			$countQuery .= " AND vtiger_troubletickets.status = ?";
			$params[] = $ticketStatus;
			$countParams[] = $ticketStatus;
		}
		
		// Add global search filter
		if (!empty($searchAllFieldsValue)) {
			$globalSearch = " AND (vtiger_troubletickets.ticket_no LIKE ? OR vtiger_account.accountname LIKE ? OR vtiger_equipment.equipment_serialno LIKE ? OR vtiger_crmentity.description LIKE ?)";
			$baseQuery .= $globalSearch;
			$countQuery .= $globalSearch;
			
			$searchValue = '%' . $searchAllFieldsValue . '%';
			$params = array_merge($params, [$searchValue, $searchValue, $searchValue, $searchValue]);
			$countParams = array_merge($countParams, [$searchValue, $searchValue, $searchValue, $searchValue]);
		}
		
		// Get total count
		$countResult = $adb->pquery($countQuery, $countParams);
		$totalRecords = $adb->query_result($countResult, 0, 'total');
		
		// Add ordering and pagination
		$baseQuery .= " ORDER BY vtiger_troubletickets.ticketid DESC LIMIT ? OFFSET ?";
		$params[] = $limit;
		$params[] = $offset;
		
		
		// Execute main query
		$result = $adb->pquery($baseQuery, $params);
		$records = [];
		
		while ($row = $adb->fetch_array($result)) {
			
			// Handle date formatting
			$formatDate = function($date) {
				if (empty($date) || $date === '0000-00-00' || $date === '0000-00-00 00:00:00') {
					return '';
				}
				return $date;
			};
			
			$records[] = [

				'id' => '17x' . $row['ticketid'],
				'ticketid' => $row['ticketid'],
				'ticket_no' => $row['ticket_no'] ?: '',
				'parent_id' => $row['accountname'] ?: '',
				'parent_id_idofreference' => !empty($row['parent_id']) ? '11x' . $row['parent_id'] : '',
				'parent_id_Label' => $row['accountname'] ?: '',
				'ticketstatus' => $row['status'] ?: '',  
				'equipment_id' => $row['equipment_serialno'] ?: '',
				'equipment_id_idofreference' => !empty($row['equipment_id']) ? '38x' . $row['equipment_id'] : '',
				'equipment_id_Label' => $row['equipment_serialno'] ?: '',
				'model_number' => $row['model_number'] ?: '',
				'product_name' => $row['product_name'] ?: '',
				'product_modal' => $row['product_modal'] ?: '',
				'product_category' => $row['product_category'] ?: '',
				'product_subcategory' => $row['product_subcategory'] ?: '',
				'mobile' => $row['mobile'] ?: '',
				'customer_name' => $row['customer_name'] ?: '',
				'address' => $row['address'] ?: '',
				'helpdesk_city' => $row['helpdesk_city'] ?: '',
				'helpdesk_state' => $row['helpdesk_state'] ?: '',
				'helpdesk_pincode' => $row['helpdesk_pincode'] ?: '',
				'helpdesk_country' => $row['helpdesk_country'] ?: '',
				'helpdesk_district' => $row['helpdesk_district'] ?: '',
				'title' => $row['title'] ?: '',
				'ticket_title' => $row['title'] ?: '',
				'description' => $row['description'] ?: '',
				'warrenty_period' => $row['warrenty_period'] ?: '',
				'warranty_status' => $row['warranty_status'] ?: '',
				'war_start_date' => $formatDate($row['war_start_date']),
				'war_end_date' => $formatDate($row['war_end_date']),
				'days_left_in_war' => $row['days_left_in_war'] ?: '',
				'amc_start_date' => $formatDate($row['amc_start_date']),
				'amc_end_date' => $formatDate($row['amc_end_date']),
				'amc_status' => $row['amc_status'] ?: '',
				'contract_period' => $row['contract_period'] ?: '',
				'service_offered' => $row['service_offered'] ?: '',
				'ticket_type' => $row['cf_3038'] ?: $row['ticket_type'] ?: '',
				'ticket_date' => $formatDate($row['ticket_date']),
				'mode_of_payment' => $row['mode_of_payment'] ?: '',
				't_comment' => $row['t_comment'] ?: '',
				'm_comment' => $row['m_comment'] ?: '',
				'approvepart_comment' => $row['approvepart_comment'] ?: '',
				'approvepart_service' => $row['approvepart_service'] ?: '',
				'resolved_date' => $formatDate($row['resolved_date']),
				'resolved_time' => $row['resolved_time'] ?: '',
				'ticket_closedate' => $formatDate($row['ticket_closedate']),
				't_breakdown' => $row['t_breakdown'] ?: '',
				'rating' => $row['rating'] ?: '0',
				'customer_feedback' => $row['customer_feedback'] ?: '',
				'smownerid' => $row['smownerid'] ?: '',
				'smcreatorid' => $row['smcreatorid'] ?: '',
				'assigned_user_id' => $row['smownerid'],
				'assigned_person' => $row['assigned_user_name'] ?: '',
				'createdtime' => $row['createdtime'] ?: '',
				'modifiedtime' => $row['modifiedtime'] ?: '',
				
			
			];
		}
		
		$response = new Mobile_API_Response();
		$result = [
			'records' => $records,
			'headers' => $this->getHelpDeskHeaders(),
			'selectedFilter' => "13",
			'records_per_page' => $limit,
			'moreRecords' => ($page < ceil($totalRecords / $limit)),
			'orderBy' => false,
			'sortOrder' => false,
			'page' => (string)$page,
			'pagination' => [
				'total' => (int)$totalRecords,
				'page' => $page,
				'limit' => $limit,
				'total_pages' => ceil($totalRecords / $limit),
				'moreRecords' => ($page < ceil($totalRecords / $limit))
			]
		];
		
		$appliedFilters = [];
		if (!empty($ticketStatus)) {
			$appliedFilters['ticketstatus'] = $ticketStatus;
		}
		if (!empty($searchAllFieldsValue)) {
			$appliedFilters['searchAllFieldsValue'] = $searchAllFieldsValue;
		}
		if (!empty($appliedFilters)) {
			$result['applied_filters'] = $appliedFilters;
		}
		
		$response->setResult($result);
		$response->setApiSucessMessage('Successfully Fetched Data');
		return $response;
	}



	private function getHelpDeskHeaders() {
		return [
			['name' => 'parent_id', 'label' => 'Customer', 'fieldType' => 'reference', 'referesTo' => ['Accounts']],
			['name' => 'mobile', 'label' => 'Mobile Phone', 'fieldType' => 'phone'],
			['name' => 'ticket_no', 'label' => 'Service Request Number', 'fieldType' => 'string'],
			['name' => 'assigned_user_id', 'label' => 'Assigned To', 'fieldType' => 'owner'],
			['name' => 'ticketstatus', 'label' => 'Ticket Status', 'fieldType' => 'picklist'],
			['name' => 'equipment_id', 'label' => 'Equipment Serial No.', 'fieldType' => 'reference', 'referesTo' => ['Equipment']],
			['name' => 'model_number', 'label' => 'EQUIPMENT MODEL NAME', 'fieldType' => 'picklist'],
			['name' => 'ticket_title', 'label' => 'Service Description/Problem Reported', 'fieldType' => 'string'],
			['name' => 'ticketpriorities', 'label' => 'Priority', 'fieldType' => 'picklist'],
			['name' => 'createdtime', 'label' => 'Created Time', 'fieldType' => 'datetime'],
			['name' => 'modifiedtime', 'label' => 'Modified Time', 'fieldType' => 'datetime']
		];
	}

	function process(Mobile_API_Request $request) {
		$module = $request->get('module');
		$filterId = $request->get('filterid');
		$page = $request->get('page', '1');
		$orderBy = $request->getForSql('orderBy');
		$sortOrder = $request->getForSql('sortOrder');

		$moduleModel = Vtiger_Module_Model::getInstance($module);
		$headerFieldModels = $moduleModel->getHeaderViewFieldsList();
	if ($module == 'HelpDesk') {
			return $this->processHelpDeskWithRoleFiltering($request);
		}
		$headerFields = array();
		$fields = array();
		$headerFieldColsMap = array();

		$nameFields = $moduleModel->getNameFields();
		$listViewGeneralisedModules = [
			'ServiceOrders', 'StockTransferOrders',
			'Invoice', 'DeliveryNotes',
			'ReturnSaleOrders', 'BankGuarantee', 'Equipment',
			'EquipmentAvailability', 'ServiceReports', 'RecommissioningReports',
			'Documents', 'HelpDesk'
		];
		if (in_array($module, $listViewGeneralisedModules)) {
			$headerFieldStatusValue = 'All-Mobile-Field-List';
			$nameFields = $this->getConfiguredStatusFields($headerFieldStatusValue, $module);
		}

		if (is_string($nameFields)) {
			$nameFieldModel = $moduleModel->getField($nameFields);
			$headerFields[] = $nameFields;
			$fields = array('name' => $nameFieldModel->get('name'), 'label' => vtranslate($nameFieldModel->get('label'), $module), 'fieldType' => $nameFieldModel->getFieldDataType());
		} else if (is_array($nameFields)) {
			foreach ($nameFields as $nameField) {
				$nameFieldModel = $moduleModel->getField($nameField);
				if (empty($nameFieldModel)) {
					$fields[] = array(
						'name' => $nameField,
					);
					$headerFields[] = $nameField;
					continue;
				}
				$headerFields[] = $nameField;
				$fieldType = $nameFieldModel->getFieldDataType();
				if ($fieldType == 'reference') {
					$fields[] = array(
						'name' => $nameFieldModel->get('name'),
						'label' => vtranslate($nameFieldModel->get('label'), $module),
						'fieldType' => $nameFieldModel->getFieldDataType(),
						'referesTo' => $nameFieldModel->getReferenceList()
					);
				} else {
					$fields[] = array(
						'name' => $nameFieldModel->get('name'),
						'label' => vtranslate($nameFieldModel->get('label'), $module),
						'fieldType' => $nameFieldModel->getFieldDataType()
					);
				}
			}
		}

		foreach ($headerFieldModels as $fieldName => $fieldModel) {
			$headerFields[] = $fieldName;
			$fieldType = $fieldModel->getFieldDataType();
			if ($fieldType == 'reference') {
				$fields[] = array(
					'name' => $fieldName,
					'label' => vtranslate($fieldModel->get('label'), $module),
					'fieldType' => $fieldType,
					'referesTo' => $fieldModel->getReferenceList()
				);
			} else {
				$fields[] = array(
					'name' => $fieldName,
					'label' => vtranslate($fieldModel->get('label'), $module),
					'fieldType' => $fieldType,
				);
			}
			$headerFieldColsMap[$fieldModel->get('column')] = $fieldName;
		}

		if ($module == 'HelpDesk') $headerFieldColsMap['title'] = 'ticket_title';
		if ($module == 'Documents') $headerFieldColsMap['notes_title'] = 'notes_title';
		
		global $fetchinFormMobile;
		$fetchinFormMobile = true;
		$listViewModel = Vtiger_ListView_Model::getInstance($module, $filterId, $headerFields);
		if (!empty($request->get('search_key'))) {
			$listViewModel->set('search_key', $request->get('search_key'));
			$listViewModel->set('search_value', $request->get('search_value'));
			$listViewModel->set('operator', $request->get('operator'));
		}

		if ($module == 'HelpDesk' && !empty($request->get('ticketstatus')) && empty($request->get('search_key'))) {
			$listViewModel->set('search_key', 'ticketstatus');
			$listViewModel->set('search_value', $request->get('ticketstatus'));
			$listViewModel->set('operator', 'e');
		}

		$response = new Mobile_API_Response();

		if (!empty($request->get('search_params'))) {
			$searchParams = json_decode($request->get('search_params'));
			if (empty($searchParams)) {
				$searchParams = [];
			}
			if(empty($searchParams) && !empty($request->get('search_params'))){
				$response->setError(100, "Invalid search_params Format ");
				return $response;
			}
			$searchParams = array($searchParams);
			$transformedSearchParams = $this->transferListSearchParamsToFilterCondition($searchParams, $listViewModel->getModule());

			$existingParams = $listViewModel->get('search_params', []);
			if (!empty($transformedSearchParams)) {
				$listViewModel->set('search_params', array_merge($existingParams, $transformedSearchParams));
			}
		}

		$listViewModel->set('searchAllFieldsValue', $request->get('searchAllFieldsValue'));

		$pagingModel = new Vtiger_Paging_Model();
		$pageLimit = $pagingModel->getPageLimit();
		$pagingModel->set('page', $page);
		$pagingModel->set('limit', $pageLimit);
		$listViewEntries = $listViewModel->getListViewEntries($pagingModel);

		if (empty($filterId)) {
			$customView = new CustomView($module);
			$filterId = $customView->getViewId($module);
		}

		if ($listViewEntries) {
			$moduleWSID = Mobile_WS_Utils::getEntityModuleWSId($module);
			$dateFields = $this->getDateFields($fields);
			$referenceFieldsWithCode = $this->getReferenceFields($fields);
			$referenceFields = array_keys($referenceFieldsWithCode);
			$multiPicklistFields = $this->getMultiPickListFields($fields);
			$focusObj = CRMEntity::getInstance($module);
			$moduleIdColumn = $focusObj->table_index;
			global $site_URL_NonHttp;
			
			foreach ($listViewEntries as $index => $listViewEntryModel) {
				$data = $listViewEntryModel->getRawData();
				$recordID = $data[$moduleIdColumn];
				
				// Get assigned person 
				$assignedPerson = $this->fetchUserNameById($data['smownerid']);
				$data['assigned_person'] = trim($assignedPerson);
				
				$record = array('id' => $moduleWSID . 'x' . $recordID);
				
				foreach ($data as $i => $value) {
					if (is_string($i)) {
						if (isset($headerFieldColsMap[$i])) {
							$i = $headerFieldColsMap[$i];
						}
						if ($i === 'cf_3038') {
							$record['ticket_type'] = decode_html($value);
						} else {
							$record[$i] = decode_html($value);
						}
						
						if (in_array($i, $referenceFields)) {
							if (!empty($value)) {
								$record[$i] = Vtiger_Functions::getCRMRecordLabel($value);
								$record[$i . '_idofreference'] = $referenceFieldsWithCode[$i] . 'x' . $value;
								$record[$i . '_Label'] = $record[$i];
							} else {
								$record[$i] = "";
								$record[$i . '_idofreference'] = "";
							}
						} else if (in_array($i, $dateFields) && !empty($record[$i])) {
							$record[$i] = Vtiger_Date_UIType::getDisplayDateValue($record[$i]);
						} else if (in_array($i, $multiPicklistFields) && !empty($record[$i])) {
							$record[$i] = str_replace('|##|', ',', $record[$i]);
						} else if ($i == 'is_submitted') {
							if ($record[$i] == '1') {
								$record['report_status'] = 'Submitted';
								$record['report_url'] = $site_URL_NonHttp . "modules/Mobile/v1/DownloadPDFReport?module=PDFMaker&source_module=ServiceReports&action=IndexAjax&record=$recordID&mode=getPreviewContent&language=en_us&generate_type=attachment&igtempid=1&access_token=".$request->get('access_token')."&useruniqueid=".$request->get('useruniqueid');
							} else {
								$record['report_status'] = 'In Progress';
								$record['report_url'] = NULL;
							}
							if ($data['is_recommisionreport'] == '1') {
								$record['report_status'] = 'Closed : Recommissioning Is Pending';
							}
						} else if ($i == 'notesid') {
							$record['doc_url'] = $site_URL_NonHttp . 'modules/Mobile/v1/DownloadFile?record='.$data['notesid'].'&access_token='.$request->get('access_token').'&useruniqueid='.$request->get('useruniqueid');
						} else if($i == 'createdtime' || $i == 'modifiedtime'){
							$record[$i] = $listViewEntryModel->get($i);
						}
					}
				}
				$records[] = $record;
			}
		}

		$moreRecords = false;
		if ((count($listViewEntries) + 1) > $pageLimit) {
			$moreRecords = true;
		}

		if (empty($records)) {
			$records = array();
		}

		$result = array(
			'records' => $records,
			'headers' => $fields,
			'selectedFilter' => $filterId,
			'records_per_page' => $pageLimit,
			'nameFields' => $nameFields,
			'moreRecords' => $moreRecords,
			'orderBy' => $orderBy,
			'sortOrder' => $sortOrder,
			'page' => $page
		);

		
		$response->setResult($result);
		$response->setApiSucessMessage('Successfully Fetched Data');
		return $response;
	}

	public function transferListSearchParamsToFilterCondition($listSearchParams, $moduleModel) {
		return Vtiger_Util_Helper::transferListSearchParamsToFilterCondition($listSearchParams, $moduleModel);
	}

	function getDateFields($headerFields) {
		$dateFields = [];
		foreach ($headerFields as $index => $headerField) {
			if ($headerField['fieldType'] == 'date') {
				array_push($dateFields, $headerField['name']);
			}
		}
		return $dateFields;
	}

	function getReferenceFields($headerFields) {
		$fields = [];
		foreach ($headerFields as $index => $headerField) {
			if ($headerField['fieldType'] == 'reference') {
				$fields[$headerField['name']] = Mobile_WS_Utils::getEntityModuleWSId($headerField['referesTo'][0]);
			}
		}
		return $fields;
	}

	function getMultiPickListFields($headerFields) {
		$fields = [];
		foreach ($headerFields as $index => $headerField) {
			if ($headerField['fieldType'] == 'multipicklist') {
				array_push($fields, $headerField['name']);
			}
		}
		return $fields;
	}

	function getConfiguredStatusFields($statusFilterName, $moduleName) {
		global $adb;
		$sql = "SELECT columnname FROM `vtiger_customview` inner join vtiger_cvcolumnlist " .
			"on vtiger_cvcolumnlist.cvid = vtiger_customview.cvid " .
			"where vtiger_customview.viewname = ? and vtiger_customview.userid = 1 
			and vtiger_customview.entitytype = ? 
			ORDER BY `vtiger_cvcolumnlist`.`columnindex` ASC";
		$result = $adb->pquery($sql, array($statusFilterName, $moduleName));
		$columns = [];
		while ($row = $adb->fetch_array($result)) {
			$columnname = $row['columnname'];
			$columnname = explode(':', $columnname);
			array_push($columns, $columnname[2]);
		}
		return $columns;
	}

	function processSearchRecordLabelForCalendar(Mobile_API_Request $request, $pagingModel = false) {
		$current_user = $this->getActiveUser();

		// Fetch both Calendar (Todo) and Event information
		$moreMetaFields = array('date_start', 'time_start', 'activitytype', 'location');
		$eventsRecords = $this->fetchRecordLabelsForModule('Events', $current_user, $moreMetaFields, false, $pagingModel);
		$calendarRecords = $this->fetchRecordLabelsForModule('Calendar', $current_user, $moreMetaFields, false, $pagingModel);

		// Merge the Calendar & Events information
		$records = array_merge($eventsRecords, $calendarRecords);

		$modifiedRecords = array();
		foreach ($records as $record) {
			$modifiedRecord = array();
			$modifiedRecord['id'] = $record['id'];
			unset($record['id']);
			$modifiedRecord['eventstartdate'] = $record['date_start'];
			unset($record['date_start']);
			$modifiedRecord['eventstarttime'] = $record['time_start'];
			unset($record['time_start']);
			$modifiedRecord['eventtype'] = $record['activitytype'];
			unset($record['activitytype']);
			$modifiedRecord['eventlocation'] = $record['location'];
			unset($record['location']);

			$modifiedRecord['label'] = implode(' ', array_values($record));

			$modifiedRecords[] = $modifiedRecord;
		}

		$response = new Mobile_API_Response();
		$response->setResult(array('records' => $modifiedRecords, 'module' => 'Calendar'));

		return $response;
	}

	function fetchRecordLabelsForModule($module, $user, $morefields = array(), $filterOrAlertInstance = false, $pagingModel = false) {
		if ($this->isCalendarModule($module)) {
			$fieldnames = Mobile_WS_Utils::getEntityFieldnames('Calendar');
		} else {
			$fieldnames = Mobile_WS_Utils::getEntityFieldnames($module);
		}

		if (!empty($morefields)) {
			foreach ($morefields as $fieldname) $fieldnames[] = $fieldname;
		}

		if ($filterOrAlertInstance === false) {
			$filterOrAlertInstance = Mobile_WS_SearchFilterModel::modelWithCriterias($module);
			$filterOrAlertInstance->setUser($user);
		}

		return $this->queryToSelectFilteredRecords($module, $fieldnames, $filterOrAlertInstance, $pagingModel);
	}

	function queryToSelectFilteredRecords($module, $fieldnames, $filterOrAlertInstance, $pagingModel) {

		if ($filterOrAlertInstance instanceof Mobile_WS_SearchFilterModel) {
			return $filterOrAlertInstance->execute($fieldnames, $pagingModel);
		}

		global $adb;

		$moduleWSId = Mobile_WS_Utils::getEntityModuleWSId($module);
		$columnByFieldNames = Mobile_WS_Utils::getModuleColumnTableByFieldNames($module, $fieldnames);

		// Build select clause similar to Webservice query
		$selectColumnClause = "CONCAT('{$moduleWSId}','x',vtiger_crmentity.crmid) as id,";
		foreach ($columnByFieldNames as $fieldname => $fieldinfo) {
			$selectColumnClause .= sprintf("%s.%s as %s,", $fieldinfo['table'], $fieldinfo['column'], $fieldname);
		}
		$selectColumnClause = rtrim($selectColumnClause, ',');

		$query = $filterOrAlertInstance->query();
		$query = preg_replace("/SELECT.*FROM(.*)/i", "SELECT $selectColumnClause FROM $1", $query);

		if ($pagingModel !== false) {
			$query .= sprintf(" LIMIT %s, %s", $pagingModel->currentCount(), $pagingModel->limit());
		}

		$prequeryResult = $adb->pquery($query, $filterOrAlertInstance->queryParameters());
		return new SqlResultIterator($adb, $prequeryResult);
	}
	
}