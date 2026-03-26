<?php

require_once 'modules/Emails/mail.php';
class Inventory_Save_Action extends Vtiger_Save_Action {
    
    protected function getRecordModelFromRequest(Vtiger_Request $request) {
		return parent::getRecordModelFromRequest($request);
		
	}
    
}
