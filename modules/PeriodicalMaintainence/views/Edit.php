<?php

Class PeriodicalMaintainence_Edit_View extends Inventory_Edit_View {

    public function process(Vtiger_Request $request) {
        $viewer = $this->getViewer($request);
        $moduleName = $request->getModule();
        $record = $request->get('record');
        $sourceRecord = $request->get('sourceRecord');
        $sourceModule = $request->get('sourceModule');
        if (empty($sourceRecord) && empty($sourceModule)) {
            $sourceRecord = $request->get('returnrecord');
            $sourceModule = $request->get('returnmodule');
        }

        $viewer->assign('MODE', '');
        $viewer->assign('IS_DUPLICATE', false);
        if ($request->has('totalProductCount')) {
            if ($record) {
                $recordModel = Vtiger_Record_Model::getInstanceById($record);
            } else {
                $recordModel = Vtiger_Record_Model::getCleanInstance($moduleName);
            }
            $relatedProducts = $recordModel->convertRequestToProducts($request);
            $taxes = $relatedProducts[1]['final_details']['taxes'];
        } else if (!empty($record) && $request->get('isDuplicate') == true) {
            $recordModel = Inventory_Record_Model::getInstanceById($record, $moduleName);
            $currencyInfo = '';//$recordModel->getCurrencyInfo();
            $taxes = '';//$recordModel->getProductTaxes();
            $relatedProducts = '';//$recordModel->getProducts();

            //While Duplicating record, If the related record is deleted then we are removing related record info in record model
            $mandatoryFieldModels = $recordModel->getModule()->getMandatoryFieldModels();
            foreach ($mandatoryFieldModels as $fieldModel) {
                if ($fieldModel->isReferenceField()) {
                    $fieldName = $fieldModel->get('name');
                    if (Vtiger_Util_Helper::checkRecordExistance($recordModel->get($fieldName))) {
                        $recordModel->set($fieldName, '');
                    }
                }
            }
            $viewer->assign('IS_DUPLICATE', true);
        } elseif (!empty($record)) {
            $recordModel = Inventory_Record_Model::getInstanceById($record, $moduleName);
            $currencyInfo = '';//$recordModel->getCurrencyInfo();
            $taxes = '';//$recordModel->getProductTaxes();
            $relatedProducts = '';// $recordModel->getProducts();
            $viewer->assign('RECORD_ID', $record);
            $viewer->assign('MODE', 'edit');
        } elseif (($request->get('salesorder_id') || $request->get('quote_id') || $request->get('invoice_id')) && ($moduleName == 'PurchaseOrder')) {
            if ($request->get('salesorder_id')) {
                $referenceId = $request->get('salesorder_id');
            } elseif ($request->get('invoice_id')) {
                $referenceId = $request->get('invoice_id');
            } else {
                $referenceId = $request->get('quote_id');
            }

            $parentRecordModel = Inventory_Record_Model::getInstanceById($referenceId);
            $currencyInfo = $parentRecordModel->getCurrencyInfo();

            $relatedProducts = $parentRecordModel->getProductsForPurchaseOrder();
            $taxes = $parentRecordModel->getProductTaxes();

            $recordModel = Vtiger_Record_Model::getCleanInstance($moduleName);
            $recordModel->setRecordFieldValues($parentRecordModel);
        } elseif ($request->get('salesorder_id') || $request->get('quote_id') || $request->get('potential_id') || $request->get('invoice_id')) {
            if ($request->get('salesorder_id')) {
                $referenceId = $request->get('salesorder_id');
            } else if ($request->get('invoice_id')) {
                $referenceId = $request->get('invoice_id');
            } else if ($request->get('potential_id')) {
                $referenceId = $request->get('potential_id');
            } else {
                $referenceId = $request->get('quote_id');
            }

            $parentRecordModel = Inventory_Record_Model::getInstanceById($referenceId);
            $currencyInfo = $parentRecordModel->getCurrencyInfo();
            $taxes = $parentRecordModel->getProductTaxes();
            $relatedProducts = $parentRecordModel->getProducts();
            $recordModel = Vtiger_Record_Model::getCleanInstance($moduleName);
            $recordModel->setRecordFieldValues($parentRecordModel);
        } else {
            $taxes = Inventory_Module_Model::getAllProductTaxes();
            $recordModel = Vtiger_Record_Model::getCleanInstance($moduleName);

            //The creation of Inventory record from action and Related list of product/service detailview the product/service details will calculated by following code
            if ($request->get('product_id') || $sourceModule === 'Products' || $request->get('productid')) {
                if ($sourceRecord) {
                    $productRecordModel = Products_Record_Model::getInstanceById($sourceRecord);
                } else if ($request->get('product_id')) {
                    $productRecordModel = Products_Record_Model::getInstanceById($request->get('product_id'));
                } else if ($request->get('productid')) {
                    $productRecordModel = Products_Record_Model::getInstanceById($request->get('productid'));
                }
                $relatedProducts = $productRecordModel->getDetailsForInventoryModule($recordModel);
            } elseif ($request->get('service_id') || $sourceModule === 'Services') {
                if ($sourceRecord) {
                    $serviceRecordModel = Services_Record_Model::getInstanceById($sourceRecord);
                } else {
                    $serviceRecordModel = Services_Record_Model::getInstanceById($request->get('service_id'));
                }
                $relatedProducts = $serviceRecordModel->getDetailsForInventoryModule($recordModel);
            } elseif ($sourceRecord && in_array($sourceModule, array('Accounts', 'Contacts', 'Potentials', 'Vendors', 'PurchaseOrder', 'Leads'))) {
                $parentRecordModel = Vtiger_Record_Model::getInstanceById($sourceRecord, $sourceModule);
                $recordModel->setParentRecordData($parentRecordModel);
                if ($sourceModule !== 'PurchaseOrder') {
                    $relatedProducts = $recordModel->getParentRecordRelatedLineItems($parentRecordModel);
                }
            } elseif ($sourceRecord && in_array($sourceModule, array('HelpDesk', 'Leads'))) {
                $parentRecordModel = Vtiger_Record_Model::getInstanceById($sourceRecord, $sourceModule);
                $relatedProducts = $recordModel->getParentRecordRelatedLineItems($parentRecordModel);
            }
        }

        $deductTaxes = $relatedProducts[1]['final_details']['deductTaxes'];
        if (!$deductTaxes) {
            $deductTaxes = Inventory_TaxRecord_Model::getDeductTaxesList();
        }

        $taxType = $relatedProducts[1]['final_details']['taxtype'];
        $moduleModel = $recordModel->getModule();
        $fieldList = $moduleModel->getFields();
        $requestFieldList = array_intersect_key($request->getAllPurified(), $fieldList);

        //get the inventory terms and conditions
        $inventoryRecordModel = Inventory_Record_Model::getCleanInstance($moduleName);
        $termsAndConditions = '';// $inventoryRecordModel->getInventoryTermsAndConditions();

        foreach ($requestFieldList as $fieldName => $fieldValue) {
            $fieldModel = $fieldList[$fieldName];
            if ($fieldModel->isEditable()) {
                $recordModel->set($fieldName, $fieldModel->getDBInsertValue($fieldValue));
            }
        }
        $recordStructureInstance = Vtiger_RecordStructure_Model::getInstanceFromRecordModel($recordModel, Vtiger_RecordStructure_Model::RECORD_STRUCTURE_MODE_EDIT);

        $viewer->assign('VIEW_MODE', "fullForm");

        $isRelationOperation = $request->get('relationOperation');

        //if it is relation edit
        $viewer->assign('IS_RELATION_OPERATION', $isRelationOperation);
        if ($isRelationOperation) {
            $viewer->assign('SOURCE_MODULE', $sourceModule);
            $viewer->assign('SOURCE_RECORD', $sourceRecord);
        }
        if (!empty($record) && $request->get('isDuplicate') == true) {
            $viewer->assign('IS_DUPLICATE', true);
        } else {
            $viewer->assign('IS_DUPLICATE', false);
        }
        $currencies = Inventory_Module_Model::getAllCurrencies();
        $picklistDependencyDatasource = Vtiger_DependencyPicklist::getPicklistDependencyDatasource($moduleName);

        $recordStructure = $recordStructureInstance->getStructure();

        $viewer->assign('PICKIST_DEPENDENCY_DATASOURCE', Vtiger_Functions::jsonEncode($picklistDependencyDatasource));
        $viewer->assign('RECORD', $recordModel);
        $viewer->assign('RECORD_STRUCTURE_MODEL', $recordStructureInstance);
        $viewer->assign('RECORD_STRUCTURE', $recordStructure);
        $viewer->assign('MODULE', $moduleName);
        $viewer->assign('CURRENTDATE', date('Y-n-j'));
        $viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());

        $taxRegions = [];// $recordModel->getRegionsList();
        $defaultRegionInfo = $taxRegions[0];
        unset($taxRegions[0]);

        $viewer->assign('TAX_REGIONS', $taxRegions);
        $viewer->assign('DEFAULT_TAX_REGION_INFO', $defaultRegionInfo);
        // $viewer->assign('INVENTORY_CHARGES', Inventory_Charges_Model::getInventoryCharges());
        $viewer->assign('RELATED_PRODUCTS', $relatedProducts);
        $viewer->assign('DEDUCTED_TAXES', $deductTaxes);
        $viewer->assign('TAXES', $taxes);
        $viewer->assign('TAX_TYPE', $taxType);
        $viewer->assign('CURRENCINFO', $currencyInfo);
        $viewer->assign('CURRENCIES', $currencies);
        $viewer->assign('TERMSANDCONDITIONS', $termsAndConditions);

        $productModuleModel = Vtiger_Module_Model::getInstance('Products');
        $viewer->assign('PRODUCT_ACTIVE', $productModuleModel->isActive());

        $serviceModuleModel = Vtiger_Module_Model::getInstance('Services');
        $viewer->assign('SERVICE_ACTIVE', $serviceModuleModel->isActive());
        if ($moduleName == 'PurchaseOrder') {
            $viewer->assign('WAREHOUSELOCATIONS', $this->getAllWareHouseLocations());
        }
        // added to set the return values
        if ($request->get('returnview')) {
            $request->setViewerReturnValues($viewer);
        }
        global $section_values;
        $section_values = explode(',', $section_values);
        $viewer->assign('SECTION_VALUES', $section_values);
        $warehosues = Vtiger_Util_Helper::getPickListValues('product_warehouse');
        $viewer->assign('WAREHOUSE_VALUES', $warehosues);

        global $adb;
        $tabId = getTabId($moduleName);
        $sql = "SELECT * FROM `vtiger_field` LEFT JOIN vtiger_blocks
			on vtiger_blocks.blockid = vtiger_field.block where vtiger_field.tabid = ? 
			and helpinfo = 'li_lg_1' and blocklabel = ? and presence != 1 ORDER BY `vtiger_field`.`sequence` ASC;";
        $result = $adb->pquery($sql, array($tabId, 'Periodic_Schedule'));
        $fields = [];
        $fieldNames = [];
        $pickListFields = [];
        $dependentList = array();
        while ($row = $adb->fetch_array($result)) {
            if ($row['uitype'] == '16' || $row['uitype'] == '999') {
                array_push($pickListFields, $row['fieldname']);
                $row['picklistValues'] = getAllPickListValues($row['fieldname']);
            }
            if (in_array($row['fieldname'], $dependentList)) {
                $row['hideInitialDisplay'] = 'true';
            }
            array_push($fieldNames, $row['fieldname']);
            array_push($fields, $row);
        }

        $viewer->assign('LINEITEM_CUSTOM_FIELDNAMES_OTHER1', $fieldNames);
        $viewer->assign('LINEITEM_CUSTOM_OTHER_PICK_FIELDS1', $pickListFields);
        $viewer->assign('LINEITEM_CUSTOM_FIELDS_OTHER1', $fields);
        if (!empty($record)) {
            $relatedLines = $recordModel->getProductsOther2();
            // print_r($relatedLines);
            // die();
            $noOfYearsOfContract = (int) $recordModel->get('no_of_installments') + 1;
            $i = 1;
            for ($i = 1; $i < $noOfYearsOfContract; $i++) {
                if ($i == 1) {
                    $relatedProductsAnother[1]['pay_sch_sl_no1'] = $relatedLines[$i]['pay_sch_sl_no' . $i];
                    $relatedProductsAnother[1]['payment_date1'] = $relatedLines[$i]['payment_date' . $i];
                    $relatedProductsAnother[1]['pay_amount1'] = $relatedLines[$i]['pay_amount' . $i];
                } else {
                    array_push($relatedProductsAnother, array(
                        'pay_sch_sl_no' . $i => $relatedLines[$i]['pay_sch_sl_no' . $i],
                        'payment_date' . $i => $relatedLines[$i]['payment_date' . $i],
                        'pay_amount' . $i => $relatedLines[$i]['pay_amount' . $i]
                    ));
                }
            }
            if (empty($noOfYearsOfContract)) {
                $viewer->assign('RELATED_PRODUCTS_OTHER1', []);
            } else {
                // print_r($relatedProductsAnother);
                // die();
                $viewer->assign('RELATED_PRODUCTS_OTHER1', $relatedProductsAnother);
            }
        }

        if ($request->get('displayMode') == 'overlay') {
            $viewer->assign('SCRIPTS', $this->getOverlayHeaderScripts($request));
            echo $viewer->view('OverlayEditView.tpl', $moduleName);
        } else {
            // global $psch;
            // if ($psch == 'true') {
                $viewer->view('EditView.tpl', 'PeriodicalMaintainence');
            // } else {
            //     $viewer->view('EditView.tpl', 'Inventory');
            // }
        }
    }

}
