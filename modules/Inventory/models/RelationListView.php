<?php

class Inventory_RelationListView_Model extends Vtiger_RelationListView_Model {

    public function getCreateViewUrl() {
        $createViewUrl = parent::getCreateViewUrl();
        $currentUserModel = Users_Record_Model::getCurrentUserModel();
        $parentRecordModel = $this->getParentRecordModel();
        $currencyValue = $parentRecordModel->get('hdnGrandTotal');
        $parentRecordModelCurrencyId = $parentRecordModel->get('currency_id');

        if ($parentRecordModelCurrencyId == $currentUserModel->get('currency_id')) {
            $amount = CurrencyField::convertToUserFormat($currencyValue, null, true);
        } else {
            $baseCurrencyId = CurrencyField::getDBCurrencyId();
            $allCurrencies = getAllCurrencies();

            foreach ($allCurrencies as $currencyInfo) {
                if ($parentRecordModelCurrencyId == $currencyInfo['currency_id']) {
                    $currencyValue = CurrencyField::convertToDollar($currencyValue, $currencyInfo['conversionrate']);
                }
            }

            foreach ($allCurrencies as $currencyInfo) {
                if ($baseCurrencyId == $currencyInfo['currency_id']) {
                    $currencyValue = CurrencyField::convertFromMasterCurrency($currencyValue, $currencyInfo['conversionrate']);
                }
            }

            $amount = CurrencyField::convertToUserFormat($currencyValue);
        }
        $accountId = ($parentRecordModel->getModuleName() == 'PurchaseOrder') ? $parentRecordModel->get('accountid') : $parentRecordModel->get('account_id');

        return $createViewUrl . '&relatedcontact=' . $parentRecordModel->get('contact_id') . '&relatedorganization=' . $accountId . '&amount=' . $amount;
    }

}

?>