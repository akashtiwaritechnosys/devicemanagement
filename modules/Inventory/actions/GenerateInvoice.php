<?php

class Inventory_GenerateInvoice_Action extends Vtiger_IndexAjax_View {

    public function process(Vtiger_Request $request) {
       
        $salesorder_id = $request->get('record');
        $response = new Vtiger_Response();
        require_once('include/utils/utils.php');
        require_once('modules/Quotes/Quotes.php');
        require_once('modules/Invoice/Invoice.php');
        require_once('modules/Users/Users.php');

        global $current_user;
        if (!$current_user) {
            $current_user = Users::getActiveAdminUser();
        }
        $so_focus = new Quotes();
        $so_focus->id = $salesorder_id;
        $so_focus->ignite_retrieve_entity_info($salesorder_id, "Quotes");
        foreach ($so_focus->column_fields as $fieldname => $value) {
            $so_focus->column_fields[$fieldname] = decode_html($value);
        }
       
        $focus = new Invoice();
        $focus = getConvertQuoteToSO($focus, $so_focus, $salesorder_id);
        $focus->id = '';
        $focus->mode = '';
        $focus->column_fields['quote_id'] = $salesorder_id;
        $focus->column_fields['invoicestatus'] = 'Created';
        $invoice_so_fields = array(
            'txtAdjustment' => 'txtAdjustment',
            'hdnSubTotal' => 'hdnSubTotal',
            'hdnGrandTotal' => 'hdnGrandTotal',
            'hdnTaxType' => 'hdnTaxType',
            'hdnDiscountPercent' => 'hdnDiscountPercent',
            'hdnDiscountAmount' => 'hdnDiscountAmount',
            'hdnS_H_Amount' => 'hdnS_H_Amount',
            'assigned_user_id' => 'assigned_user_id',
            'currency_id' => 'currency_id',
            'conversion_rate' => 'conversion_rate',
        );
        foreach ($invoice_so_fields as $invoice_field => $so_field) {
            $focus->column_fields[$invoice_field] = $so_focus->column_fields[$so_field];
        }
        $focus->_salesorderid = $salesorder_id;
        $focus->_recurring_mode = 'recurringinvoice_from_so';
        $focus->save("Invoice");
        $savedProjectId = $focus->id;

        $response->setResult(array('success' => true, 'data' => "Reacod is created succefly" ,
            "record" => $savedProjectId,"module" => 'Invoice'));
        $response->emit();
    }

}
