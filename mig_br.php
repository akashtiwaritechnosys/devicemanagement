<?php
require_once("modules/com_vtiger_workflow/include.inc");
require_once("modules/com_vtiger_workflow/tasks/VTEntityMethodTask.inc");
require_once("modules/com_vtiger_workflow/VTEntityMethodManager.inc");
require_once("include/database/PearDatabase.php");
$adb = PearDatabase::getInstance();
$emm = new VTEntityMethodManager($adb);
require_once 'vtlib/Vtiger/Module.php';
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('CUSTOMER_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('helpdesk_city', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'helpdesk_city';
        $field->column = 'helpdesk_city';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'City';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- helpdesk_city in HelpDesk --- <br>";
    }
} else {
    echo "Block Does not exits -- CUSTOMER_DETAILS in HelpDesk -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;


$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('CUSTOMER_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('helpdesk_state', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'helpdesk_state';
        $field->column = 'helpdesk_state';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'State';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- helpdesk_state in HelpDesk --- <br>";
    }
} else {
    echo "Block Does not exits -- CUSTOMER_DETAILS in HelpDesk -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('CUSTOMER_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('helpdesk_pincode', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'helpdesk_pincode';
        $field->column = 'helpdesk_pincode';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Pincode';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- helpdesk_pincode in HelpDesk --- <br>";
    }
} else {
    echo "Block Does not exits -- CUSTOMER_DETAILS in HelpDesk -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('CUSTOMER_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('helpdesk_country', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'helpdesk_country';
        $field->column = 'helpdesk_country';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Country';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- helpdesk_country in HelpDesk --- <br>";
    }
} else {
    echo "Block Does not exits -- CUSTOMER_DETAILS in HelpDesk -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('CUSTOMER_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('helpdesk_district', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'helpdesk_district';
        $field->column = 'helpdesk_district';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'District';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- helpdesk_district in HelpDesk --- <br>";
    }
} else {
    echo "Block Does not exits -- CUSTOMER_DETAILS in HelpDesk -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;


$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('LBL_TICKET_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('resolved_date', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'resolved_date';
        $fieldInstance->label = 'Resolved Date';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'resolved_date';
        $fieldInstance->uitype = 5;
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- resolved_date in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_TICKET_INFORMATION -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;


$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('LBL_TICKET_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('resolved_time', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'resolved_time';
        $fieldInstance->label = 'Resolved Time';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'resolved_time';
        $fieldInstance->uitype = 2;
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'T~O';
        $fieldInstance->columntype = 'Time';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- resolved_time in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_TICKET_INFORMATION -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('LBL_TICKET_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('t_breakdown', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 't_breakdown';
        $fieldInstance->label = 'Status';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 't_breakdown';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('Electrical/Electronics','Mechanical','Software'));
    } else {
        echo "field is already Present --- t_breakdown in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_TICKET_INFORMATION -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('LBL_TICKET_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('t_comment', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 't_comment';
        $fieldInstance->label = 'Comment';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 't_comment';
        $fieldInstance->uitype = '19';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- t_comment in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_TICKET_INFORMATION -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('LBL_TICKET_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('m_comment', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'm_comment';
        $fieldInstance->label = 'Comment By Manager';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'm_comment';
        $fieldInstance->uitype = '19';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- m_comment in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_TICKET_INFORMATION -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('LBL_TICKET_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('approvepart_comment', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'approvepart_comment';
        $fieldInstance->label = 'Comment By Manager for Approve Part';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'approvepart_comment';
        $fieldInstance->uitype = '19';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- approvepart_comment in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_TICKET_INFORMATION -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('LBL_TICKET_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('approvepart_service', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'approvepart_service';
        $fieldInstance->label = 'Comment By Service Head for Approve Part';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'approvepart_service';
        $fieldInstance->uitype = '19';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- approvepart_service in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_TICKET_INFORMATION -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;



$emm = new VTEntityMethodManager($adb);
$result = $adb->pquery("SELECT function_name FROM com_vtiger_workflowtasks_entitymethod WHERE module_name=? AND method_name=?", array('HelpDesk', 'helpDeskStatusComment'));

if ($adb->num_rows($result) == 0) {
    $emm->addEntityMethod("HelpDesk", "helpDeskStatusComment", "modules/HelpDesk/helpDeskStatusComment.php", "helpDeskStatusComment");
    echo "Workflow function 'helpDeskStatusComment' registered successfully in HelpDesk Module.<br>";
} else {
    echo "Workflow function 'helpDeskStatusComment' already exists in HelpDesk Module.<br>";
}

$emm = null;


$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('PeriodicalMaintainence');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('pm_month', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'pm_month';
        $fieldInstance->label = 'Choose Month';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'pm_month';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('6','12','24','36','48'));
    } else {
        echo "field is already Present --- pm_month in PeriodicalMaintainence Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_BLOCK_GENERAL_INFORMATION -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('PeriodicalMaintainence');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('pm_enddate', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'pm_enddate';
        $fieldInstance->label = 'End Date';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'pm_enddate';
        $fieldInstance->uitype = '5';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        echo "Field pm_enddate added successfully! <br>";
    } else {
        echo "Field is already present --- pm_enddate in PeriodicalMaintenance Module --- <br>";
    }
} else {
    echo "Error: BlockInstance is null or not found.<br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;


$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('war_end_date', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'war_end_date';
        $fieldInstance->label = 'Warranty End Date';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'war_end_date';
        $fieldInstance->uitype = '5';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        echo "Field war_end_date added successfully! <br>";
    } else {
        echo "Field is already present --- war_end_date in PeriodicalMaintenance Module --- <br>";
    }
} else {
    echo "Error: BlockInstance is null or not found.<br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;



$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('war_start_date', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'war_start_date';
        $fieldInstance->label = 'Warranty Start Date';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'war_start_date';
        $fieldInstance->uitype = '5';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        echo "Field war_start_date added successfully! <br>";
    } else {
        echo "Field is already present --- war_start_date in PeriodicalMaintenance Module --- <br>";
    }
} else {
    echo "Error: BlockInstance is null or not found.<br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;



$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('days_left_in_war', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'days_left_in_war';
        $fieldInstance->label = 'Days Left in Warranty';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'days_left_in_war';
        $fieldInstance->uitype = '1';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'I~O';
        $fieldInstance->columntype = 'DATE';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        echo "Field days_left_in_war added successfully! <br>";
    } else {
        echo "Field is already present --- days_left_in_war in PeriodicalMaintenance Module --- <br>";
    }
} else {
    echo "Error: BlockInstance is null or not found.<br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('warranty_status', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'warranty_status';
        $fieldInstance->label = 'Warranty Status';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'warranty_status';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('Active','In Active'));
    } else {
        echo "field is already Present --- warranty_status in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_TICKET_INFORMATION -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('Contact Person details', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('amc_start_date', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'amc_start_date';
        $fieldInstance->label = 'AMC/CMC START DATE';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'amc_start_date';
        $fieldInstance->uitype = 5;
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- amc_start_date in HelpDesk Module --- <br>";
    }
} else {
    echo "block does not exits --- in HelpDesk-- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('Contact Person details', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('amc_end_date', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'amc_end_date';
        $fieldInstance->label = 'AMC/CMC START DATE';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'amc_end_date';
        $fieldInstance->uitype = 5;
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- amc_end_date in HelpDesk Module --- <br>";
    }
} else {
    echo "block does not exits --- in HelpDesk-- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('Contact Person details', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('amc_status', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'amc_status';
        $fieldInstance->label = 'AMC/CMC STATUS';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'amc_status';
        $fieldInstance->uitype = '16';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('In Active', 'Active'));
    } else {
        echo "field is already Present --- amc_status in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- Contact Person details in HelpDesk -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('Contact Person details', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('contract_period', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'contract_period';
        $fieldInstance->label = 'Contract Period in Month';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'contract_period';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('3','6','12','36'));
    } else {
        echo "field is already Present --- Contact Person details in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- Contact Person details -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('Contact Person details', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('service_offered', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'service_offered';
        $fieldInstance->label = 'Service Offered';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'service_offered';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('AMC','CMC','Per Call'));
    } else {
        echo "field is already Present --- product_category in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- Contact Person details -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;