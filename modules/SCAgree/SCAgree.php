<?php

class SCAgree extends CRMEntity {

    var $table_name = 'vtiger_scagree';
    var $table_index = 'scagreeid';
    var $moduleName = 'SCAgree';
    var $customFieldTable = Array('vtiger_scagreecf', 'scagreeid');
    var $tab_name = Array('vtiger_crmentity', 'vtiger_scagree', 'vtiger_scagreecf', 'vtiger_inventoryproductrel');
    var $tab_name_index = Array(
        'vtiger_crmentity' => 'crmid',
        'vtiger_scagree' => 'scagreeid',
        'vtiger_scagreecf' => 'scagreeid',
        'vtiger_inventoryproductrel' => 'id');
    var $list_fields = Array(
        'Name' => Array('SCAgree', 'creditnote_name'),
        'Assigned To' => Array('crmentity', 'smownerid')
    );
    var $list_fields_name = Array(
        'Name' => 'creditnote_name',
        'Assigned To' => 'assigned_user_id',
    );
    var $list_link_field = 'creditnote_name';
    var $search_fields = Array(
        'Name' => Array('SCAgree', 'creditnote_name'),
        'Assigned To' => Array('crmentity', 'assigned_user_id'),
    );
    var $search_fields_name = Array(
        'Name' => 'creditnote_name',
        'Assigned To' => 'assigned_user_id',
    );
    var $popup_fields = Array('creditnote_name');
    var $def_basicsearch_col = 'creditnote_name';
    var $def_detailview_recname = 'creditnote_name';
    var $mandatory_fields = Array('creditnote_name', 'creditnote_status', 'assigned_user_id', 'createdtime', 'modifiedtime', 'quantity', 'productid', 'netprice');
    var $default_order_by = 'creditnote_name';
    var $default_sort_order = 'ASC';
    var $isLineItemUpdate = true;

    function SCAgree() {
        $this->db = PearDatabase::getInstance();
        $this->column_fields = getColumnFields('SCAgree');
    }

    public function vtlib_handler($moduleName, $eventType) {
        require_once('include/utils/utils.php');
        if ($eventType == 'module.postinstall') {
            $this->addLinks();
            $this->registerHandlers();
            $this->enableModtracker();
            $this->setModuleSeqNumber('configure', $this->moduleName, 'CN-', 1);
            vtws_addModuleTypeWebserviceEntity('SCAgree', 'include/Webservices/VtigerModuleOperation.php', 'VtigerModuleOperation');
            $this->applyRelateModuleChanges();
            $this->applyPostInstallSchemaChanges();
            $this->addRelatedFields();
            $this->enableProfileUtilities();
            $this->addTaxFields($eventType);
            $db = PearDatabase::getInstance();
            $tandC = $db->pquery('SELECT 1 FROM vtiger_inventory_tandc where type=?', array('SCAgree'));
            if (!($db->num_rows($tandC))) {
                $db->pquery('INSERT INTO vtiger_inventory_tandc(id, type) values(?,?)', array($db->getUniqueId("vtiger_inventory_tandc"), 'SCAgree'));
            }
        } else if ($eventType == 'module.preuninstall') {
            $this->disableModtracker();
            $this->deleteLinks();
            $this->unregisterEventHandlers();
            $this->revertRelateModuleChanges();
            $this->removeTaxFields();
        } else if ($eventType == 'module.enabled') {
            $this->addLinks();
            $this->registerHandlers();
        } else if ($eventType == 'module.disabled') {
            $this->deleteLinks();
            $this->unregisterEventHandlers();
        } else if ($eventType == 'module.postupdate') {
            $this->addLinks();
            $this->registerHandlers();
            $this->enableProfileUtilities();
            $this->addTaxFields($eventType);
        }
    }

    public function addTaxFields($eventType) {
        $db = PearDatabase::getInstance();
        $moduleInstance = Vtiger_Module_Model::getInstance('SCAgree');
        $productTaxes = Inventory_TaxRecord_Model::getProductTaxes();
        $itemsBlock = Vtiger_Block_Model::getInstance('LBL_ITEM_DETAILS', $moduleInstance);

        if ($itemsBlock) {
            foreach ($productTaxes as $taxInfo) {
                $fieldInstance = Vtiger_Field_Model::getInstance($taxInfo->get('taxname'), $moduleInstance);
                if (!$fieldInstance) {
                    $taxField = new Vtiger_Field();
                    $taxField->name = $taxInfo->get('taxname');
                    $taxField->label = $taxInfo->get('taxlabel');
                    $taxField->column = $taxInfo->get('taxname');
                    $taxField->uitype = 83;
                    $taxField->typeofdata = 'V~O';
                    $taxField->readonly = 1;
                    $taxField->presence = 2;
                    $taxField->displaytype = 5;
                    $taxField->table = 'vtiger_inventoryproductrel';
                    $itemsBlock->addField($taxField);
                    if ($eventType == 'module.postinstall') {
                        $db->pquery('UPDATE vtiger_profile2field SET readonly=? WHERE tabid=? AND fieldid=? AND readonly=?', array(1, $taxField->getModuleId(), $taxField->id, 0));
                    }
                }
            }
        }
    }

    public function removeTaxFields() {
        $moduleInstance = Vtiger_Module_Model::getInstance('SCAgree');
        $productTaxes = Inventory_TaxRecord_Model::getProductTaxes();
        foreach ($productTaxes as $taxInfo) {
            $fieldInstance = Vtiger_Field_Model::getInstance($taxInfo->get('taxname'), $moduleInstance);
            if ($fieldInstance) {
                $fieldInstance->delete();
            }
        }
    }

    public function enableProfileUtilities() {
        $db = PearDatabase::getInstance();
        $moduleModel = Vtiger_Module_Model::getInstance($this->moduleName);
        $allowed_tools = array('Export', 'PrintTemplates', 'Reopen', 'DuplicatesHandling', 'Create List');
        $actionMappingRes = $db->pquery('SELECT actionid, actionname FROM vtiger_actionmapping WHERE actionname '
                . 'IN (' . generateQuestionMarks($allowed_tools) . ')', $allowed_tools);

        $actionMappingInfo = array();
        while ($row = $db->fetchByAssoc($actionMappingRes)) {
            $actionMappingInfo[$row['actionname']] = $row['actionid'];
        }

        foreach ($allowed_tools as $tool) {
            $result = $db->pquery('SELECT 1 FROM vtiger_profile2utility WHERE tabid = ? AND activityid = ?', array($moduleModel->getId(), $actionMappingInfo[$tool]));
            $rows = $db->num_rows($result);
            if (!$rows) {
                Vtiger_Access::updateTool($moduleModel, $tool, true);
            }
        }
    }

    function addLinks() {
        
    }

    function deleteLinks() {
        
    }

    public function registerHandlers() {
        
    }

    function unregisterEventHandlers() {
        
    }

    public function enableModtracker() {
        include_once 'modules/ModTracker/ModTracker.php';
        $tabId = getTabid($this->moduleName);
        ModTracker::enableTrackingForModule($tabId);
    }

    public function disableModtracker() {
        include_once 'modules/ModTracker/ModTracker.php';
        $tabId = getTabid($this->moduleName);
        ModTracker::disableTrackingForModule($tabId);
    }

    public function applyRelateModuleChanges() {
        $db = PearDatabase::getInstance();

        $moduleInstance = Vtiger_Module::getInstance($this->moduleName);
        $modtrackerModule = Vtiger_Module::getInstance('ModTracker');
        if (!Vtiger_Relation_Model::isRelationEntryExist($moduleInstance->name, $modtrackerModule->name, 'N:N')) {
            $moduleInstance->setRelatedList($modtrackerModule, 'LBL_UPDATES');
        }

        $modCommentsModule = Vtiger_Module::getInstance('ModComments');
        if (!Vtiger_Relation_Model::isRelationEntryExist($moduleInstance->name, $modCommentsModule->name, '1:N')) {
            $modCommentsModModel = Vtiger_Module_Model::getInstance('ModComments');
            $related_to = $modCommentsModModel->getField('related_to');
            $related_to->setRelatedModules(array($this->moduleName));
            $moduleInstance->setRelatedList($modCommentsModule, 'ModComments', false, 'get_comments', $related_to->getId());
        }

        $moduleModel = Vtiger_Module_Model::getInstance('SCAgree');
        $orgModule = Vtiger_Module::getInstance('Accounts');
        if (!Vtiger_Relation_Model::isRelationEntryExist($orgModule->name, $moduleInstance->name, '1:N')) {
            $account_id = $moduleModel->getField('account_id');
            $account_id->setRelatedModules(array('Accounts'));
            $orgModule->setRelatedList($moduleInstance, 'SCAgree', false, 'get_dependents_list', $account_id->getId());
        }

        $contModule = Vtiger_Module::getInstance('Contacts');
        if (!Vtiger_Relation_Model::isRelationEntryExist($contModule->name, $moduleInstance->name, '1:N')) {
            $contact_id = $moduleModel->getField('contact_id');
            $contact_id->setRelatedModules(array('Contacts'));
            $contModule->setRelatedList($moduleInstance, 'SCAgree', false, 'get_dependents_list', $contact_id->getId());
        }

    }

    public function revertRelateModuleChanges() {
        $moduleInstance = Vtiger_Module::getInstance($this->moduleName);
        $modtrackerModule = Vtiger_Module::getInstance('ModTracker');
        if (Vtiger_Relation_Model::isRelationEntryExist($moduleInstance->name, $modtrackerModule->name, 'N:N')) {
            $moduleInstance->unsetRelatedList($modtrackerModule, 'LBL_UPDATES', 'get_related_list');
        }

        $modCommentsModule = Vtiger_Module::getInstance('ModComments');
        if (Vtiger_Relation_Model::isRelationEntryExist($moduleInstance->name, $modCommentsModule->name, '1:N')) {
            $modCommentsModModel = Vtiger_Module_Model::getInstance('ModComments');
            $related_to = $modCommentsModModel->getField('related_to');
            $related_to->unsetRelatedModules(array($this->moduleName));
            $moduleInstance->unsetRelatedList($modCommentsModule, 'ModComments', 'get_comments');
        }

        $moduleModel = Vtiger_Module_Model::getInstance('SCAgree');
        $orgModule = Vtiger_Module::getInstance('Accounts');
        if (Vtiger_Relation_Model::isRelationEntryExist($orgModule->name, $moduleInstance->name, '1:N')) {
            $account_id = $moduleModel->getField('account_id');
            $account_id->unsetRelatedModules(array('Accounts'));
            $orgModule->unsetRelatedList($moduleInstance, 'SCAgree', 'get_dependents_list');
        }

        $contModule = Vtiger_Module::getInstance('Contacts');
        if (Vtiger_Relation_Model::isRelationEntryExist($contModule->name, $moduleInstance->name, '1:N')) {
            $contact_id = $moduleModel->getField('contact_id');
            $contact_id->unsetRelatedModules(array('Contacts'));
            $contModule->unsetRelatedList($moduleInstance, 'SCAgree', 'get_dependents_list');
        }

        $invoiceModule = Vtiger_Module_Model::getInstance('Invoice');
        if (Vtiger_Relation_Model::isRelationEntryExist($moduleInstance->name, $invoiceModule->getName(), 'N:N')) {
            $moduleInstance->unsetRelatedList($invoiceModule, 'Invoice', 'get_related_list');
        }
        if (Vtiger_Relation_Model::isRelationEntryExist($invoiceModule->getName(), $moduleInstance->name, 'N:N')) {
            $invoiceModule->unsetRelatedList($moduleInstance, 'SCAgree', 'get_related_list');
        }

        $paymentsModule = Vtiger_Module_Model::getInstance('Payments');
        if ($paymentsModule) {
            $related_to = $paymentsModule->getField('related_to');
            $referenceList = $related_to->getReferenceList();
            if (in_array('SCAgree', $referenceList)) {
                $related_to->unsetRelatedModules(array('Payments' => 'SCAgree'));
                $moduleModel->unsetRelatedListForField($related_to->getId());
            }
        }
    }

    public function applyPostInstallSchemaChanges() {
    }

    public function addRelatedFields() {
      
    }

    function save_module() {
        global $adb;


        if (isset($_REQUEST['REQUEST_FROM_WS']) && $_REQUEST['REQUEST_FROM_WS']) {
            unset($_REQUEST['totalProductCount']);
        }

        if ($_REQUEST['action'] != 'SCAgreeAjax' && $_REQUEST['ajxaction'] != 'DETAILVIEW' && $_REQUEST['action'] != 'MassEditSave' && $_REQUEST['action'] != 'ProcessDuplicates' && $_REQUEST['action'] != 'SaveAjax' && $this->isLineItemUpdate != false && $_REQUEST['action'] != 'FROM_WS') {
            saveInventoryProductDetails($this, 'SCAgree');
        }

        $update_query = "update vtiger_scagree set currency_id=?, conversion_rate=? where scagreeid=?";
        $update_params = array($this->column_fields['currency_id'], $this->column_fields['conversion_rate'], $this->id);
        $adb->pquery($update_query, $update_params);
    }

    function insertIntoEntityTable($table_name, $module, $fileid = '') {
        if ($table_name == 'vtiger_inventoryproductrel') {
            return;
        }
        parent::insertIntoEntityTable($table_name, $module, $fileid);
    }

    function createRecords($obj) {
        $createRecords = createRecords($obj);
        return $createRecords;
    }

    function importRecord($obj, $inventoryFieldData, $lineItemDetails) {
        $entityInfo = importRecord($obj, $inventoryFieldData, $lineItemDetails);
        return $entityInfo;
    }

    function getImportStatusCount($obj) {
        $statusCount = getImportStatusCount($obj);
        return $statusCount;
    }

    function undoLastImport($obj, $user) {
        $undoLastImport = undoLastImport($obj, $user);
    }

    function getMandatoryImportableFields() {
        return getInventoryImportableMandatoryFeilds($this->moduleName);
    }

    function create_export_query($where) {
        global $log;
        global $current_user;
        $log->debug("Entering create_export_query(" . $where . ") method ...");

        include("include/utils/ExportUtils.php");

        $sql = getPermittedFieldsQuery("Quotes", "detail_view");
        $fields_list = getFieldsListFromQuery($sql);
        $fields_list .= getInventoryFieldsForExport($this->table_name);
        $query = "SELECT $fields_list FROM " . $this->entity_table . "
				INNER JOIN vtiger_scagree ON vtiger_scagree.scagreeid = vtiger_crmentity.crmid
				LEFT JOIN vtiger_scagreecf ON vtiger_scagreecf.scagreeid = vtiger_scagree.scagreeid
				LEFT JOIN vtiger_inventoryproductrel ON vtiger_inventoryproductrel.id = vtiger_quotes.quoteid
				LEFT JOIN vtiger_products ON vtiger_products.productid = vtiger_inventoryproductrel.productid
				LEFT JOIN vtiger_service ON vtiger_service.serviceid = vtiger_inventoryproductrel.productid
				LEFT JOIN vtiger_contactdetails ON vtiger_contactdetails.contactid = vtiger_scagree.contactid
				LEFT JOIN vtiger_account ON vtiger_account.accountid = vtiger_scagree.accountid
				LEFT JOIN vtiger_currency_info ON vtiger_currency_info.id = vtiger_scagree.currency_id
				LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid
				LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid";

        $query .= $this->getNonAdminAccessControlQuery('Quotes', $current_user);
        $where_auto = " vtiger_crmentity.deleted=0";

        if ($where != "") {
            $query .= " where ($where) AND " . $where_auto;
        } else {
            $query .= " where " . $where_auto;
        }

        $log->debug("Exiting create_export_query method ...");
        return $query;
    }

    function checkACPermission($linkData) {
        return false;
    }

    function generateReportsQuery($module, $queryplanner) {
        global $current_user;
        $matrix = $queryplanner->newDependencyMatrix();

        $matrix->setDependency('vtiger_inventoryproductreltmpSCAgree', array('vtiger_productsSCAgree', 'vtiger_serviceSCAgree'));

        $query = "from vtiger_scagree
        inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_scagree.scagreeid";

        if ($queryplanner->requireTable("vtiger_currency_info$module")) {
            $query .= " left join vtiger_currency_info as vtiger_currency_info$module on vtiger_currency_info$module.id = vtiger_scagree.currency_id";
        }
        if ($type !== 'COLUMNSTOTOTAL' || $this->lineItemFieldsInCalculation == true) {
            if ($queryplanner->requireTable("vtiger_inventoryproductreltmpSCAgree", $matrix) || $queryplanner->requireTable("vtiger_inventoryproductrelSCAgree", $matrix)) {
                $query .= " left join vtiger_inventoryproductrel as vtiger_inventoryproductreltmpSCAgree on vtiger_scagree.scagreeid = vtiger_inventoryproductreltmpSCAgree.id";
            }
            if ($queryplanner->requireTable("vtiger_productsSCAgree")) {
                $query .= " left join vtiger_products as vtiger_productsSCAgree on vtiger_productsSCAgree.productid = vtiger_inventoryproductreltmpSCAgree.productid";
            }
            if ($queryplanner->requireTable("vtiger_serviceSCAgree")) {
                $query .= " left join vtiger_service as vtiger_serviceSCAgree on vtiger_serviceSCAgree.serviceid = vtiger_inventoryproductreltmpSCAgree.productid";
            }
        }
        if ($queryplanner->requireTable("vtiger_scagreecf")) {
            $query .= " left join vtiger_scagreecf on vtiger_scagree.scagreeid = vtiger_scagreecf.scagreeid";
        }
        if ($queryplanner->requireTable("vtiger_groupsSCAgree")) {
            $query .= " left join vtiger_groups as vtiger_groupsSCAgree on vtiger_groupsSCAgree.groupid = vtiger_crmentity.smownerid";
        }
        if ($queryplanner->requireTable("vtiger_usersSCAgree")) {
            $query .= " left join vtiger_users as vtiger_usersSCAgree on vtiger_usersSCAgree.id = vtiger_crmentity.smownerid";
        }

        $query .= " left join vtiger_groups on vtiger_groups.groupid = vtiger_crmentity.smownerid";
        $query .= " left join vtiger_users on vtiger_users.id = vtiger_crmentity.smownerid";

        if ($queryplanner->requireTable("vtiger_lastModifiedBySCAgree")) {
            $query .= " left join vtiger_users as vtiger_lastModifiedBySCAgree on vtiger_lastModifiedBySCAgree.id = vtiger_crmentity.modifiedby";
        }
        if ($queryplanner->requireTable('vtiger_createdbySCAgree')) {
            $query .= " left join vtiger_users as vtiger_createdbySCAgree on vtiger_createdbySCAgree.id = vtiger_crmentity.smcreatorid";
        }
        if ($queryplanner->requireTable("vtiger_accountSCAgree")) {
            $query .= " left join vtiger_account as vtiger_accountSCAgree on vtiger_accountSCAgree.accountid = vtiger_scagree.account_id";
        }
        if ($queryplanner->requireTable("vtiger_contactdetailsSCAgree")) {
            $query .= " left join vtiger_contactdetails as vtiger_contactdetailsSCAgree on vtiger_contactdetailsSCAgree.contactid = vtiger_scagree.contact_id";
        }
        $focus = CRMEntity::getInstance($module);
        $relQuery = $focus->getReportsUiType10Query($module, $queryplanner);
        $query .= ' ' . $relQuery;
        return $query;
    }

    function generateReportsSecQuery($module, $secmodule, $queryPlanner) {
        $matrix = $queryPlanner->newDependencyMatrix();
        $matrix->setDependency('vtiger_crmentitySCAgree', array('vtiger_usersSCAgree', 'vtiger_groupsSCAgree', 'vtiger_lastModifiedBySCAgree'));
        $matrix->setDependency('vtiger_inventoryproductrelSCAgree', array('vtiger_productsSCAgree', 'vtiger_serviceSCAgree'));


        if (!$queryPlanner->requireTable('vtiger_scagree', $matrix) && !$queryPlanner->requireTable('vtiger_crmentitySCAgree', $matrix)) {
            return '';
        }
        $matrix->setDependency('vtiger_scagree', array('vtiger_crmentitySCAgree', "vtiger_currency_info$secmodule",
            'vtiger_scagreecf', 'vtiger_inventoryproductrelSCAgree', 'vtiger_contactdetailsSCAgree', 'vtiger_accountSCAgree',
            'vtiger_usersRel1'));

        $query = $this->getRelationQuery($module, $secmodule, "vtiger_scagree", "scagreeid", $queryPlanner);
        if ($queryPlanner->requireTable("vtiger_crmentitySCAgree", $matrix)) {
            $query .= " left join vtiger_crmentity as vtiger_crmentitySCAgree on vtiger_crmentitySCAgree.crmid=vtiger_scagree.scagreeid and vtiger_crmentitySCAgree.deleted=0";
        }
        if ($queryPlanner->requireTable("vtiger_scagreecf")) {
            $query .= " left join vtiger_scagreecf on vtiger_scagree.scagreeid = vtiger_scagreecf.scagreeid";
        }
        if ($queryPlanner->requireTable("vtiger_currency_info$secmodule")) {
            $query .= " left join vtiger_currency_info as vtiger_currency_info$secmodule on vtiger_currency_info$secmodule.id = vtiger_scagree.currency_id";
        }
        if ($queryPlanner->requireTable("vtiger_inventoryproductrelSCAgree", $matrix)) {
            if ($module !== "Products" && $module !== "Services") {
                $query .= " LEFT JOIN vtiger_inventoryproductrel AS vtiger_inventoryproductreltmpSCAgree ON vtiger_scagree.scagreeid = vtiger_inventoryproductreltmpSCAgree.id";
            }
        }

        if ($queryPlanner->requireTable("vtiger_productsSCAgree")) {
            $query .= " left join vtiger_products as vtiger_productsSCAgree on vtiger_productsSCAgree.productid = vtiger_inventoryproductreltmpSCAgree.productid";
        }
        if ($queryPlanner->requireTable("vtiger_serviceSCAgree")) {
            $query .= " left join vtiger_service as vtiger_serviceSCAgree on vtiger_serviceSCAgree.serviceid = vtiger_inventoryproductreltmpSCAgree.productid";
        }
        if ($queryPlanner->requireTable("vtiger_groupsSCAgree")) {
            $query .= " left join vtiger_groups as vtiger_groupsSCAgree on vtiger_groupsSCAgree.groupid = vtiger_crmentitySCAgree.smownerid";
        }
        if ($queryPlanner->requireTable("vtiger_usersSCAgree")) {
            $query .= " left join vtiger_users as vtiger_usersSCAgree on vtiger_usersSCAgree.id = vtiger_crmentitySCAgree.smownerid";
        }
        if ($queryPlanner->requireTable("vtiger_usersRel1")) {
            $query .= " left join vtiger_users as vtiger_usersRel1 on vtiger_usersRel1.id = vtiger_quotes.inventorymanager";
        }
        if ($queryPlanner->requireTable("vtiger_contactdetailsSCAgree")) {
            $query .= " left join vtiger_contactdetails as vtiger_contactdetailsSCAgree on vtiger_contactdetailsSCAgree.contactid = vtiger_scagree.contact_id";
        }
        if ($queryPlanner->requireTable("vtiger_accountSCAgree")) {
            $query .= " left join vtiger_account as vtiger_accountSCAgree on vtiger_accountSCAgree.accountid = vtiger_scagree.account_id";
        }
        if ($queryPlanner->requireTable("vtiger_lastModifiedBySCAgree")) {
            $query .= " left join vtiger_users as vtiger_lastModifiedBySCAgree on vtiger_lastModifiedBySCAgree.id = vtiger_crmentitySCAgree.modifiedby ";
        }
        if ($queryPlanner->requireTable("vtiger_createdbySCAgree")) {
            $query .= " left join vtiger_users as vtiger_createdbySCAgree on vtiger_createdbySCAgree.id = vtiger_crmentitySCAgree.smcreatorid ";
        }

        $query .= parent::getReportsUiType10Query($secmodule, $queryPlanner);
        return $query;
    }

}
