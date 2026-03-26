<?php

class PeriodicalMaintainence_Detail_View extends Inventory_Detail_View {

    public function showModuleDetailView(Vtiger_Request $request) {
        $recordId = $request->get('record');
        $moduleName = $request->getModule();
        $recordModel = Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
        $viewer = $this->getViewer($request);
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
        if (!empty($recordId)) {
            $relatedLines = $recordModel->getProductsOther2();
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
                $viewer->assign('RELATED_PRODUCTS_OTHER1', $relatedProductsAnother);
            }
        }

        return parent::showModuleDetailView($request);
    }

    function showModuleBasicView(Vtiger_Request $request) {

        $recordId = $request->get('record');
        $moduleName = $request->getModule();

        if (!$this->record) {
            $this->record = Vtiger_DetailView_Model::getInstance($moduleName, $recordId);
        }
        $recordModel = $this->record->getRecord();

        $detailViewLinkParams = array('MODULE' => $moduleName, 'RECORD' => $recordId);
        $detailViewLinks = $this->record->getDetailViewLinks($detailViewLinkParams);

        $viewer = $this->getViewer($request);
        $viewer->assign('RECORD', $recordModel);
        $viewer->assign('MODULE_SUMMARY', $this->showModuleSummaryView($request));

        $viewer->assign('DETAILVIEW_LINKS', $detailViewLinks);
        $viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
        $viewer->assign('IS_AJAX_ENABLED', $this->isAjaxEnabled($recordModel));
        $viewer->assign('MODULE_NAME', $moduleName);

        $recordStrucure = Vtiger_RecordStructure_Model::getInstanceFromRecordModel($recordModel, Vtiger_RecordStructure_Model::RECORD_STRUCTURE_MODE_DETAIL);
        $structuredValues = $recordStrucure->getStructure();

        $moduleModel = $recordModel->getModule();
        $viewer->assign('CURRENT_USER_MODEL', Users_Record_Model::getCurrentUserModel());
        $viewer->assign('RECORD_STRUCTURE', $structuredValues);
        $viewer->assign('BLOCK_LIST', $moduleModel->getBlocks());
        $viewer = $this->getViewer($request);
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
        if (!empty($recordId)) {
            $relatedLines = $recordModel->getProductsOther2();
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
                $viewer->assign('RELATED_PRODUCTS_OTHER1', $relatedProductsAnother);
            }
        }

        echo $viewer->view('DetailViewSummaryContents.tpl', $moduleName, true);
    }

}
