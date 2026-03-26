<?php

class Inventory_RecordQuickPreview_View extends Vtiger_RecordQuickPreview_View {

    protected $record = false;

    function __construct() {
        parent::__construct();
    }

    function process(Vtiger_Request $request) {

        $moduleName = $request->getModule();
        $viewer = $this->getViewer($request);
        $recordId = $request->get('record');

        if (!$this->record) {
            $this->record = Vtiger_DetailView_Model::getInstance($moduleName, $recordId);
        }
        if ($request->get('navigation') == 'true') {
            $this->assignNavigationRecordIds($viewer, $recordId);
        }

        $recordModel = $this->record->getRecord();
        $recordStrucure = Vtiger_RecordStructure_Model::getInstanceFromRecordModel($recordModel, Vtiger_RecordStructure_Model::RECORD_STRUCTURE_MODE_SUMMARY);
        $moduleModel = $recordModel->getModule();

        $viewer->assign('RECORD', $recordModel);
        $viewer->assign('MODULE_MODEL', $moduleModel);
        $viewer->assign('BLOCK_LIST', $moduleModel->getBlocks());
        $viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
        $viewer->assign('MODULE_NAME', $moduleName);
        $viewer->assign('SUMMARY_RECORD_STRUCTURE', $recordStrucure->getStructure());
        $viewer->assign('$SOCIAL_ENABLED', false);
        $viewer->assign('LIST_PREVIEW', true);
        $appName = $request->get('app');
        if (!empty($appName)) {
            $viewer->assign('SELECTED_MENU_CATEGORY', $appName);
        }
        $pageNumber = 1;
        $limit = 5;

        $pagingModel = new Vtiger_Paging_Model();
        $pagingModel->set('page', $pageNumber);
        $pagingModel->set('limit', $limit);
        if ($moduleModel->isCommentEnabled()) {
            $recentComments = ModComments_Record_Model::getRecentComments($recordId, $pagingModel);
            $viewer->assign('COMMENTS', $recentComments);
            $modCommentsModel = Vtiger_Module_Model::getInstance('ModComments');
            $viewer->assign('COMMENTS_MODULE_MODEL', $modCommentsModel);
            $currentUserModel = Users_Record_Model::getCurrentUserModel();
            $viewer->assign('CURRENTUSER', $currentUserModel);
        }
        $viewer->assign('SHOW_ENGAGEMENTS', 'false');
        $recentActivities = ModTracker_Record_Model::getUpdates($recordId, $pagingModel, $moduleName);
        if (count($recentActivities) >= 5) {
            $pagingModel->set('nextPageExists', true);
        } else {
            $pagingModel->set('nextPageExists', false);
        }
        $viewer->assign('PAGING_MODEL', $pagingModel);
        $viewer->assign('RECENT_ACTIVITIES', $recentActivities);

        $relatedProducts = $recordModel->getProducts();
        $finalDetails = $relatedProducts[1]['final_details'];
        $taxtype = $finalDetails['taxtype'];
        if ($taxtype == 'group') {
            $taxDetails = $finalDetails['taxes'];
            $taxCount = count($taxDetails);
            foreach ($taxDetails as $key => $taxInfo) {
                $taxDetails[$key]['amount'] = Vtiger_Currency_UIType::transformDisplayValue($taxInfo['amount'], null, true);
            }
            $finalDetails['taxes'] = $taxDetails;
        }
        $deductTaxes = $finalDetails['deductTaxes'];
        foreach ($deductTaxes as $taxId => $taxInfo) {
            $deductTaxes[$taxId]['taxAmount'] = Vtiger_Currency_UIType::transformDisplayValue($deductTaxes[$taxId]['taxAmount'], null, true);
        }
        $finalDetails['deductTaxes'] = $deductTaxes;
        $currencyFieldsList = array(
            'adjustment', 'grandTotal', 'hdnSubTotal', 'preTaxTotal', 'tax_totalamount', 'pre_tax_total',
            'shtax_totalamount', 'discountTotal_final', 'discount_amount_final', 'shipping_handling_charge', 'totalAfterDiscount', 'deductTaxesTotalAmount'
        );
        foreach ($currencyFieldsList as $fieldName) {
            $finalDetails[$fieldName] = Vtiger_Currency_UIType::transformDisplayValue($finalDetails[$fieldName], null, true);
        }
        $relatedProducts[1]['final_details'] = $finalDetails;
        $productsCount = count($relatedProducts);
        for ($i = 1; $i <= $productsCount; $i++) {
            $product = $relatedProducts[$i];
            if ($taxtype == 'individual') {
                $taxDetails = $product['taxes'];
                $taxCount = count($taxDetails);
                for ($j = 0; $j < $taxCount; $j++) {
                    $taxDetails[$j]['amount'] = Vtiger_Currency_UIType::transformDisplayValue($taxDetails[$j]['amount'], null, true);
                }
                $product['taxes'] = $taxDetails;
            }
            $currencyFieldsList = array(
                'taxTotal', 'netPrice', 'listPrice', 'unitPrice', 'productTotal', 'purchaseCost', 'margin',
                'discountTotal', 'discount_amount', 'totalAfterDiscount'
            );
            foreach ($currencyFieldsList as $fieldName) {
                $product[$fieldName . $i] = Vtiger_Currency_UIType::transformDisplayValue($product[$fieldName . $i], null, true);
            }
            $relatedProducts[$i] = $product;
        }
        $selectedChargesAndItsTaxes = $relatedProducts[1]['final_details']['chargesAndItsTaxes'];
        if (!$selectedChargesAndItsTaxes) {
            $selectedChargesAndItsTaxes = array();
        }
        $shippingTaxes = array();
        $allShippingTaxes = getAllTaxes('all', 'sh');
        foreach ($allShippingTaxes as $shTaxInfo) {
            $shippingTaxes[$shTaxInfo['taxid']] = $shTaxInfo;
        }
        $selectedTaxesList = array();
        foreach ($selectedChargesAndItsTaxes as $chargeId => $chargeInfo) {
            if ($chargeInfo['taxes']) {
                foreach ($chargeInfo['taxes'] as $taxId => $taxPercent) {
                    $taxInfo = array();
                    $amount = $calculatedOn = $chargeInfo['value'];

                    if ($shippingTaxes[$taxId]['method'] === 'Compound') {
                        $compoundTaxes = Zend_Json::decode(html_entity_decode($shippingTaxes[$taxId]['compoundon']));
                        if (is_array($compoundTaxes)) {
                            foreach ($compoundTaxes as $comTaxId) {
                                $calculatedOn += ((float) $amount * (float) $chargeInfo['taxes'][$comTaxId]) / 100;
                            }
                            $taxInfo['method'] = 'Compound';
                            $taxInfo['compoundon'] = $compoundTaxes;
                        }
                    }
                    $calculatedAmount = ((float) $calculatedOn * (float) $taxPercent) / 100;

                    $taxInfo['name'] = $shippingTaxes[$taxId]['taxlabel'];
                    $taxInfo['percent'] = $taxPercent;
                    $taxInfo['amount'] = Vtiger_Currency_UIType::transformDisplayValue($calculatedAmount, null, true);

                    $selectedTaxesList[$chargeId][$taxId] = $taxInfo;
                }
            }
        }

        $selectedChargesList = Inventory_Charges_Model::getChargeModelsList(array_keys($selectedChargesAndItsTaxes));
        foreach ($selectedChargesList as $chargeId => $chargeModel) {
            $chargeInfo['name'] = $chargeModel->getName();
            $chargeInfo['amount'] = Vtiger_Currency_UIType::transformDisplayValue($selectedChargesAndItsTaxes[$chargeId]['value'], null, true);
            $chargeInfo['percent'] = $selectedChargesAndItsTaxes[$chargeId]['percent'];
            $chargeInfo['taxes'] = $selectedTaxesList[$chargeId];
            $chargeInfo['deleted'] = $chargeModel->get('deleted');

            $selectedChargesList[$chargeId] = $chargeInfo;
        }

        $viewer = $this->getViewer($request);
        $viewer->assign('RELATED_PRODUCTS', $relatedProducts);
        $viewer->assign('SELECTED_CHARGES_AND_ITS_TAXES', $selectedChargesList);
        $viewer->assign('RECORD', $recordModel);
        $viewer->assign('MODULE_NAME', $moduleName);

        $viewer->view('ListViewQuickPreview.tpl', 'Inventory');
    }

    public function assignNavigationRecordIds($viewer, $recordId) {
        $navigationInfo = ListViewSession::getListViewNavigation($recordId);
        $prevRecordId = null;
        $nextRecordId = null;
        $found = false;
        if ($navigationInfo) {
            foreach ($navigationInfo as $page => $pageInfo) {
                foreach ($pageInfo as $index => $record) {
                    if ($found) {
                        $nextRecordId = $record;
                        break;
                    }
                    if ($record == $recordId) {
                        $found = true;
                    }
                    if (!$found) {
                        $prevRecordId = $record;
                    }
                }
                if ($found && !empty($nextRecordId)) {
                    break;
                }
            }
        }
        $viewer->assign('IG_CURRENT_RECORD_ID', $recordId);
        $viewer->assign('PREVIOUS_RECORD_ID', $prevRecordId);
        $viewer->assign('NEXT_RECORD_ID', $nextRecordId);
        $viewer->assign('NAVIGATION', true);
    }

    public function validateRequest(Vtiger_Request $request) {
        $request->validateReadAccess();
    }
}
