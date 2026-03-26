<?php

class SCAgree_Record_Model extends Inventory_Record_Model {

    public static $OPEN = '';
    public static $PARTIALLY_REDEEMED = 'Partially';
    public static $FULLY_REDEEMED = 'Fully';
    public static $VOID = 'Void';
    public static $CREDIT_TYPE = 'credited';
    public static $REFUNDED_TYPE = 'refunded';

    public function getStatus() {
        return '';
    }

    public function isOpen() {
        $status = $this->getStatus();
        return $status == self::$OPEN;
    }

    public function isUsed() {
        $used = false;
        $status = $this->getStatus();
        if (in_array($status, array(self::$PARTIALLY_REDEEMED, self::$FULLY_REDEEMED))) {
            $used = true;
        }
        return $used;
    }

    public function isEditable() {
        $status = $this->getStatus();
        if (in_array($status, array(self::$PARTIALLY_REDEEMED, self::$FULLY_REDEEMED))) {
            return false;
        }
        return parent::isEditable();
    }

    public function isDeletable() {
        $status = $this->getStatus();
        if ($status !== self::$OPEN) {
            return false;
        }
        return parent::isDeletable();
    }

    public function getParentRecord() {
        $related_to = false;
        $rel_acc = $this->get('account_id');
        $rel_cont = $this->get('contact_id');
        if ($rel_acc && isRecordExists($rel_acc)) {
            $related_to = $rel_acc;
        } else if ($rel_cont && isRecordExists($rel_cont)) {
            $related_to = $rel_cont;
        }
        return $related_to ? Vtiger_Record_Model::getInstanceById($related_to) : $related_to;
    }

}
