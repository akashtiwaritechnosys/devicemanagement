<?php

class PeriodicalMaintainence_Field_Model extends Vtiger_Field_Model {

    function getValidator() {
        $validator = array();
        $fieldName = $this->getName();
    
        switch ($fieldName) {
            case 'payment_date': 
                $validator[] = array('name' => 'validateEndDate');
                break;			
        }
        
        return $validator;
    }
    
    public function isAjaxEditable() {
        return false;
    }
}

