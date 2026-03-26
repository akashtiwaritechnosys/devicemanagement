<?php
require_once("modules/com_vtiger_workflow/include.inc");
require_once("modules/com_vtiger_workflow/tasks/VTEntityMethodTask.inc");
require_once("modules/com_vtiger_workflow/VTEntityMethodManager.inc");
require_once("include/database/PearDatabase.php");
$adb = PearDatabase::getInstance();
$emm = new VTEntityMethodManager($adb);
require_once 'vtlib/Vtiger/Module.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('LBL_ITEM_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('discount_amount', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'discount_amount';
        $fieldInstance->column = 'discount_amount';
        $fieldInstance->uitype = 71;
        $fieldInstance->table = 'vtiger_inventoryproductrel';
        $fieldInstance->label = 'Item Discount Amount';
        $fieldInstance->readonly = 0;
        $fieldInstance->presence = 2;
        $fieldInstance->typeofdata = 'N~O';
        $fieldInstance->columntype = 'decimal(25,8)';
        $fieldInstance->quickcreate = 1;
        $fieldInstance->displaytype = 5;
        $fieldInstance->masseditable = 0;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- discount_amount in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_ITEM_DETAILS in HelpDesk -- <br>";
}

$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('LBL_ITEM_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('discount_percent', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'discount_percent';
        $fieldInstance->column = 'discount_percent';
        $fieldInstance->uitype = 71;
        $fieldInstance->table = 'vtiger_inventoryproductrel';
        $fieldInstance->label = 'Item Discount Percent';
        $fieldInstance->readonly = 0;
        $fieldInstance->presence = 2;
        $fieldInstance->typeofdata = 'N~O';
        $fieldInstance->columntype = 'decimal(25,8)';
        $fieldInstance->quickcreate = 1;
        $fieldInstance->displaytype = 5;
        $fieldInstance->masseditable = 0;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- discount_percent in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_ITEM_DETAILS in HelpDesk -- <br>";
}

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('CUSTOMER_DETAILS', $moduleInstance);
if ($blockInstance) {
    echo " block does not exits --- CUSTOMER_DETAILS   -- <br>";
} else {
    $blockInstance = new Vtiger_Block();
    $blockInstance->label = 'CUSTOMER_DETAILS';
    $moduleInstance->addBlock($blockInstance);
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('CUSTOMER_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('mobile', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'mobile';
        $field->column = 'mobile';
        $field->uitype = 11;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Mobile Phone';
        $field->summaryfield = 1;
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(30)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- mobile HelpDesk --- <br>";
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
    $fieldInstance = Vtiger_Field::getInstance('customer_name', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'customer_name';
        $field->column = 'customer_name';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Customer Name';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- customer_name in HelpDesk --- <br>";
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
    $fieldInstance = Vtiger_Field::getInstance('address', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'address';
        $field->column = 'address';
        $field->uitype = 21;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Address';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'TEXT';
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- address In HelpDesk Module --- <br>";
    }
} else {
    echo "Block Does not exits -- CUSTOMER_DETAILS -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $moduleInstance);
if ($blockInstance) {
    echo " block does not exits --- PRODUCT_DETAILS   -- <br>";
} else {
    $blockInstance = new Vtiger_Block();
    $blockInstance->label = 'PRODUCT_DETAILS';
    $moduleInstance->addBlock($blockInstance);
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('product_name', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'product_name';
        $field->column = 'product_name';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Product Name';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- product_name in HelpDesk --- <br>";
    }
} else {
    echo "Block Does not exits -- PRODUCT_DETAILS in HelpDesk -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('product_modal', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'product_modal';
        $field->column = 'product_modal';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Product Model';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- product_modal in HelpDesk --- <br>";
    }
} else {
    echo "Block Does not exits -- PRODUCT_DETAILS in HelpDesk -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('product_category', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'product_category';
        $fieldInstance->label = 'Product Category';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'product_category';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('test value'));
    } else {
        echo "field is already Present --- product_category in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- PRODUCT_DETAILS -- <br>";
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
    $fieldInstance = Vtiger_Field::getInstance('product_subcategory', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'product_subcategory';
        $fieldInstance->label = 'Product Subcategory';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'product_subcategory';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('test value'));
    } else {
        echo "field is already Present --- product_subcategory in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- PRODUCT_DETAILS -- <br>";
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
    $fieldInstance = Vtiger_Field::getInstance('warrenty_period', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'warrenty_period';
        $fieldInstance->column = 'warrenty_period';
        $fieldInstance->uitype = 7;
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->label = 'Warranty Period';
        $fieldInstance->readonly = 1;
        $fieldInstance->presence = 2;
        $fieldInstance->typeofdata = 'I~O';
        $fieldInstance->columntype = 'INT(5)';
        $fieldInstance->quickcreate = 3;
        $fieldInstance->displaytype = 1;
        $fieldInstance->masseditable = 1;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- warrenty_period in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- PRODUCT_DETAILS in HelpDesk -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('productname', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'productname';
        $field->column = 'productname';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Product Name';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- productname in Equipment --- <br>";
    }
} else {
    echo "Block Does not exits -- LBL_BLOCK_GENERAL_INFORMATION in Equipment -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('Sale_Details', $moduleInstance);
if ($blockInstance) {
    echo " block does not exits --- Sale_Details   -- <br>";
} else {
    $blockInstance = new Vtiger_Block();
    $blockInstance->label = 'Sale_Details';
    $moduleInstance->addBlock($blockInstance);
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('Sale_Details', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('saled_date', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'saled_date';
        $fieldInstance->label = 'Sold Date';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'saled_date';
        $fieldInstance->uitype = 5;
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- saled_date in Accounts Module --- <br>";
    }
} else {
    echo " block does not exits --- Sale_Details -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('Sale_Details', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('seller_name', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'seller_name';
        $field->column = 'seller_name';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Seller Name';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- seller_name in Accounts --- <br>";
    }
} else {
    echo "Block Does not exits -- Sale_Details in Accounts -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('Sale_Details', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('final_amount', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'final_amount';
        $fieldInstance->column = 'final_amount';
        $fieldInstance->uitype = 7;
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->label = 'Amount';
        $fieldInstance->readonly = 1;
        $fieldInstance->presence = 2;
        $fieldInstance->typeofdata = 'I~O';
        $fieldInstance->columntype = 'decimal(25,8)';
        $fieldInstance->quickcreate = 3;
        $fieldInstance->displaytype = 1;
        $fieldInstance->masseditable = 1;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- final_amount in Accounts Module --- <br>";
    }
} else {
    echo " block does not exits --- Sale_Details in Accounts -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('LBL_ACCOUNT_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('address', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'address';
        $field->column = 'address';
        $field->uitype = 21;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Address';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'TEXT';
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- address In Accounts Module --- <br>";
    }
} else {
    echo "Block Does not exits -- LBL_ACCOUNT_INFORMATION -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $moduleInstance);
if ($blockInstance) {
    echo " block does not exits --- PRODUCT_DETAILS   -- <br>";
} else {
    $blockInstance = new Vtiger_Block();
    $blockInstance->label = 'PRODUCT_DETAILS';
    $moduleInstance->addBlock($blockInstance);
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('product_category', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'product_category';
        $fieldInstance->label = 'Product Category';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'product_category';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('test value'));
    } else {
        echo "field is already Present --- product_category in Accounts Module --- <br>";
    }
} else {
    echo " block does not exits --- PRODUCT_DETAILS -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('product_subcategory', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'product_subcategory';
        $fieldInstance->label = 'Product Subcategory';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'product_subcategory';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('test value'));
    } else {
        echo "field is already Present --- product_subcategory in Accounts Module --- <br>";
    }
} else {
    echo " block does not exits --- PRODUCT_DETAILS -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('warrenty_period', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'warrenty_period';
        $fieldInstance->column = 'warrenty_period';
        $fieldInstance->uitype = 7;
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->label = 'Warranty Period';
        $fieldInstance->readonly = 1;
        $fieldInstance->presence = 2;
        $fieldInstance->typeofdata = 'I~O';
        $fieldInstance->columntype = 'INT(5)';
        $fieldInstance->quickcreate = 3;
        $fieldInstance->displaytype = 1;
        $fieldInstance->masseditable = 1;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- warrenty_period in Accounts Module --- <br>";
    }
} else {
    echo " block does not exits --- PRODUCT_DETAILS in Accounts -- <br>";
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
    $fieldInstance = Vtiger_Field::getInstance('ticket_date', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'ticket_date';
        $fieldInstance->label = 'Ticket Date ';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'ticket_date';
        $fieldInstance->uitype = 5;
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->displaytype = 2;
        $fieldInstance->columntype = 'DATE';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- ticket_date in HelpDesk Module --- <br>";
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
    $fieldInstance = Vtiger_Field::getInstance('ticket_type', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'ticket_type';
        $fieldInstance->label = 'Type';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'ticket_type';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('Repair', 'Others', 'Service'));
    } else {
        echo "field is already Present --- ticket_type in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_TICKET_INFORMATION -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('model_number', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'model_number';
        $field->column = 'model_number';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Model Number';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- model_number in Accounts --- <br>";
    }
} else {
    echo "Block Does not exits -- PRODUCT_DETAILS in Accounts -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('serial_number', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'serial_number';
        $field->column = 'serial_number';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Serial Number';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- serial_number in Accounts --- <br>";
    }
} else {
    echo "Block Does not exits -- PRODUCT_DETAILS in Accounts -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('product_brand', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'product_brand';
        $fieldInstance->label = 'Brand';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'product_brand';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('test value'));
    } else {
        echo "field is already Present --- product_brand in Accounts Module --- <br>";
    }
} else {
    echo " block does not exits --- PRODUCT_DETAILS -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('model_number', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'model_number';
        $field->column = 'model_number';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Model Number';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- model_number in Accounts --- <br>";
    }
} else {
    echo "Block Does not exits -- PRODUCT_DETAILS in Accounts -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('serial_number', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'serial_number';
        $field->column = 'serial_number';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Serial Number';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- serial_number in Accounts --- <br>";
    }
} else {
    echo "Block Does not exits -- PRODUCT_DETAILS in Accounts -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;


$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('model_number', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'model_number';
        $fieldInstance->label = 'Model Number';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'model_number';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('test value'));
    } else {
        echo "field is already Present --- model_number in Equipment Module --- <br>";
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
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('product_category', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'product_category';
        $fieldInstance->label = 'Product Category';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'product_category';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('test value'));
    } else {
        echo "field is already Present --- product_category in Equipment Module --- <br>";
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
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('product_subcategory', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'product_subcategory';
        $fieldInstance->label = 'Product Subcategory';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'product_subcategory';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('test value'));
    } else {
        echo "field is already Present --- product_subcategory in Equipment Module --- <br>";
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
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('product_brand', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'product_brand';
        $fieldInstance->label = 'Manufacturer';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'product_brand';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('test value'));
    } else {
        echo "field is already Present --- product_brand in Equipment Module --- <br>";
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
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('final_amount', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'final_amount';
        $fieldInstance->column = 'final_amount';
        $fieldInstance->uitype = 7;
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->label = 'Amount';
        $fieldInstance->readonly = 1;
        $fieldInstance->presence = 2;
        $fieldInstance->typeofdata = 'I~O';
        $fieldInstance->columntype = 'decimal(25,8)';
        $fieldInstance->quickcreate = 3;
        $fieldInstance->displaytype = 1;
        $fieldInstance->masseditable = 1;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- final_amount in Equipment Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_BLOCK_GENERAL_INFORMATION in Equipment -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('warrenty_period', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'warrenty_period';
        $fieldInstance->column = 'warrenty_period';
        $fieldInstance->uitype = 7;
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->label = 'Warranty Period';
        $fieldInstance->readonly = 1;
        $fieldInstance->presence = 2;
        $fieldInstance->typeofdata = 'I~O';
        $fieldInstance->columntype = 'INT(5)';
        $fieldInstance->quickcreate = 3;
        $fieldInstance->displaytype = 1;
        $fieldInstance->masseditable = 1;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- warrenty_period in Equipment Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_BLOCK_GENERAL_INFORMATION in Equipment -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('LBL_CUSTOM_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('equipment_id', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'equipment_id';
        $field->column = 'equipment_id';
        $field->uitype = 10;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Equipment Serial No.';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'I~O';
        $field->columntype = 'INT(10)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $id = $blockInstance->addFieldWithReturn($field);
        echo "created field --- $id ";
        $tom = "INSERT INTO `vtiger_fieldmodulerel` (`fieldid`, `module`, `relmodule`, `status`, `sequence`) VALUES ('$id', 'Accounts', 'Equipment', NULL, NULL)";
        $adb->pquery($tom);
    } else {
        echo "field is present -- equipment_id  in Accounts --- <br>";
    }
} else {
    echo "Block Does not exits -- LBL_CUSTOM_INFORMATION in Accounts -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('zone', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'zone';
        $fieldInstance->label = 'Zone';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'zone';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('North 1', 'North 2', 'East', 'West','South', 'DR'));
    } else {
        echo "field is already Present --- product_brand in Accounts Module --- <br>";
    }
} else {
    echo " block does not exits --- PRODUCT_DETAILS -- <br>";
}

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('equipmentsupplied', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'equipmentsupplied';
        $field->column = 'equipmentsupplied';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Equipment Supplied';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- seller_name in Accounts --- <br>";
    }
} else {
    echo "Block Does not exits -- Sale_Details in Accounts -- <br>";
}

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('equipmentserialno', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'equipmentserialno';
        $field->column = 'equipmentserialno';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Equipment Sl. No.';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- seller_name in Accounts --- <br>";
    }
} else {
    echo "Block Does not exits -- Sale_Details in Accounts -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('institutionname', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'institutionname';
        $field->column = 'institutionname';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Name of Institution';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- seller_name in Accounts --- <br>";
    }
} else {
    echo "Block Does not exits -- Sale_Details in Accounts -- <br>";
}

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('addressline1', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'addressline1';
        $field->column = 'addressline1';
        $field->uitype = 21;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Address Line1';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'TEXT';
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- address In HelpDesk Module --- <br>";
    }
} else {
    echo "Block Does not exits -- CUSTOMER_DETAILS -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('district', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'district';
        $field->column = 'district';
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
        echo "field is present -- seller_name in Accounts --- <br>";
    }
} else {
    echo "Block Does not exits -- Sale_Details in Accounts -- <br>";
}

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('warrentyperiod', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'warrentyperiod';
        $fieldInstance->column = 'warrentyperiod';
        $fieldInstance->uitype = 7;
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->label = 'Warranty Period (In Months)';
        $fieldInstance->readonly = 1;
        $fieldInstance->presence = 2;
        $fieldInstance->typeofdata = 'I~O';
        $fieldInstance->columntype = 'INT(5)';
        $fieldInstance->quickcreate = 3;
        $fieldInstance->displaytype = 1;
        $fieldInstance->masseditable = 1;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- warrentyperiod in Accounts Module --- <br>";
    }
} else {
    echo " block does not exits --- PRODUCT_DETAILS in Accounts -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('doi', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'doi';
        $fieldInstance->label = 'DOI';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'doi';
        $fieldInstance->uitype = 5;
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- saled_date in Accounts Module --- <br>";
    }
} else {
    echo " block does not exits --- Sale_Details -- <br>";
}

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('warrantyenddate', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'warrantyenddate';
        $fieldInstance->label = 'Warranty End Date';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'warrantyenddate';
        $fieldInstance->uitype = 5;
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- warrantyenddate in Accounts Module --- <br>";
    }
} else {
    echo " block does not exits --- Sale_Details -- <br>";
}


$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('installedby', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'installedby';
        $field->column = 'installedby';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Installed By';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- installedby in Accounts --- <br>";
    }
} else {
    echo "Block Does not exits -- Sale_Details in Accounts -- <br>";
}

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('dayleftinwarranty', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'dayleftinwarranty';
        $fieldInstance->column = 'dayleftinwarranty';
        $fieldInstance->uitype = 7;
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->label = 'Day Left In Warranty';
        $fieldInstance->readonly = 1;
        $fieldInstance->presence = 2;
        $fieldInstance->typeofdata = 'I~O';
        $fieldInstance->columntype = 'INT(5)';
        $fieldInstance->quickcreate = 3;
        $fieldInstance->displaytype = 1;
        $fieldInstance->masseditable = 1;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- dayleftinwarranty in Accounts Module --- <br>";
    }
} else {
    echo " block does not exits --- PRODUCT_DETAILS in Accounts -- <br>";
}

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('warrantystatus', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'warrantystatus';
        $fieldInstance->label = 'Warranty Status';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'warrantystatus';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('Inside Warranty', 'Outside Warranty'));
    } else {
        echo "field is already Present --- product_brand in Accounts Module --- <br>";
    }
} else {
    echo " block does not exits --- PRODUCT_DETAILS -- <br>";
}

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('zone', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'zone';
        $fieldInstance->label = 'Zone';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'zone';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('North 1', 'North 2', 'East', 'West','South', 'DR'));
    } else {
        echo "field is already Present --- product_brand in Accounts Module --- <br>";
    }
} else {
    echo " block does not exits --- PRODUCT_DETAILS -- <br>";
}


$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('Vendor_Warranty', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('eq_run_war_st', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'eq_run_war_st';
        $fieldInstance->label = 'Warranty Status';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'eq_run_war_st';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('Under Warranty', 'Aggregate Warranty', 'Contract', 'Outside Warranty'));
    } else {
        echo "field is already Present --- eq_run_war_st in Equipment Module --- <br>";
    }
} else {
    echo " block does not exits --- Customer_Warranty in Equipment -- <br>";
}

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('Contract Details', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('eq_contra_app', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'eq_contra_app';
        $field->column = 'eq_contra_app';
        $field->table = $invoiceModule->basetable;
        $field->label = 'Contract Applicabel';
        $field->uitype = '999';
        $field->columntype = 'VARCHAR(100)';
        $field->typeofdata = 'V~O';
        $field->displaytype = 1;
        $blockInstance->addField($field);
        $field->setPicklistValues(array('Yes', 'No'));
    } else {
        echo "field is present -- eq_contra_app In Equipment Module --- <br>";
    }
} else {
    echo "Block Does not exits -- Contract Details in Equipment -- <br>";
}

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('Equipment Availability', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('eq_available', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'eq_available';
        $field->column = 'eq_available';
        $field->table = $invoiceModule->basetable;
        $field->label = 'Availability';
        $field->uitype = '999';
        $field->columntype = 'VARCHAR(100)';
        $field->typeofdata = 'V~O';
        $field->displaytype = 1;
        $blockInstance->addField($field);
        $field->setPicklistValues(array('Applicable', 'Not Applicable'));
    } else {
        echo "field is present -- eq_available In Equipment Module --- <br>";
    }
} else {
    echo "Block Does not exits -- Equipment Availability in Equipment -- <br>";
}

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('SER_ENGG_DETAIL', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('badge_no', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'badge_no';
        $field->column = 'badge_no';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable . 'cf';
        $field->label = 'Badge No';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'I~O';
        $field->columntype = 'INT(10)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- badge_no Equipment --- <br>";
    }
} else {
    echo "Block Does not exits -- SER_ENGG_DETAIL in Equipment -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('SER_ENGG_DETAIL', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('sr_designaion', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'sr_designaion';
        $fieldInstance->label = 'Designation';
        $fieldInstance->table = $moduleInstance->basetable . 'cf';
        $fieldInstance->column = 'sr_designaion';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        // $fieldInstance->setPicklistValues(array('Chairman & Managing Director', 'Director(Mining & Construction Business)', 'Director(Defence Business)','Director','Executive Director','Executive Director','General Manager','Deputy General Manager','Assistant General Manager','Senior Manager','Manager','Assistant Manager','Engineer','Assistant Engineer','Senior Supervisor-S-6','Senior Supervisor-S-5','Senior Supervisor-S-4','Supervisor- S-3','Joint Supervisior-S-2','Deputy Supervisor-S-1','Master Skilled Technician-Gr.-E','High Skilled Technician-Gr.-D','Senior Technician-Gr.-C','Technician-Gr.-B','Helper- Gr-A'));
    } else {
        echo "field is already Present --- sr_designaion in Equipment Module --- <br>";
    }
} else {
    echo "Block does not exits --- SER_ENGG_DETAIL -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('SER_ENGG_DETAIL', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('dist_off_or_act_cen', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'dist_off_or_act_cen';
        $fieldInstance->label = 'District Office / Activity Centre';
        $fieldInstance->table = $moduleInstance->basetable . 'cf';
        $fieldInstance->column = 'dist_off_or_act_cen';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        // $fieldInstance->setPicklistValues(array('Neyveli', 'Sambalpur', 'Kolkata','Dhanbad','Bangalore','Hyderabad','New Delhi','Nagpur'));
    } else {
        echo "field is already Present --- dist_off_or_act_cen in Equipment Module --- <br>";
    }
} else {
    echo "Block does not exits --- SER_ENGG_DETAIL -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('SER_ENGG_DETAIL', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('sr_regional_office', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'sr_regional_office';
        $fieldInstance->label = 'Regional Office';
        $fieldInstance->table = $moduleInstance->basetable . 'cf';
        $fieldInstance->column = 'sr_regional_office';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        // $fieldInstance->setPicklistValues(array('Neyveli', 'Sambalpur', 'Kolkata','Dhanbad','Bangalore','Hyderabad','New Delhi','Nagpur','Bilaspur','Mumbai','Ranchi','Singrauli'));
    } else {
        echo "field is already Present --- sr_regional_office in Equipment Module --- <br>";
    }
} else {
    echo "Block does not exits --- SER_ENGG_DETAIL -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_SYSTEM_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('sold_to_party', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'sold_to_party';
        $field->column = 'sold_to_party';
        $field->uitype = 10;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Sold To Party';
        $field->summaryfield = 1;
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'I~O';
        $field->columntype = 'INT(10)';
        $field->displaytype = 3;
        $field->defaultvalue = NULL;
        $id = $blockInstance->addFieldWithReturn($field);
        echo "igggggggggggggggggggg mission created field --- $id ";
        // ------------------ invoga
        $invogamoduleInstance = Vtiger_Module::getInstance('Accounts');
        $relationLabel  = 'Equipments';
        $invogamoduleInstance->setRelatedList(
            $invoiceModule,
            $relationLabel,
            array('ADD'),
            'get_dependents_list' //you can do select also Array('ADD','SELECT')
        );
        // ------------------------invoga
        $tom = "INSERT INTO `vtiger_fieldmodulerel` (`fieldid`, `module`, `relmodule`, `status`, `sequence`) VALUES ('$id', 'Equipment', 'Accounts', NULL, NULL)";
        $adb->pquery($tom);
    } else {
        echo "field is present -- sold_to_party  in Equipment--- <br>";
    }
} else {
    echo "Block Does not exits -- LBL_BLOCK_SYSTEM_INFORMATION in Equipment -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_SYSTEM_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('ship_to_party', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'ship_to_party';
        $field->column = 'ship_to_party';
        $field->uitype = 10;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Ship To Party';
        $field->summaryfield = 1;
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'I~O';
        $field->columntype = 'INT(10)';
        $field->displaytype = 3;
        $field->defaultvalue = NULL;
        $id = $blockInstance->addFieldWithReturn($field);
        echo "igggggggggggggggggggg mission created field --- $id ";
        // ------------------ invoga
        $invogamoduleInstance = Vtiger_Module::getInstance('Accounts');
        $relationLabel  = 'Equipments';
        $invogamoduleInstance->setRelatedList(
            $invoiceModule,
            $relationLabel,
            array('ADD'),
            'get_dependents_list' //you can do select also Array('ADD','SELECT')
        );
        // ------------------------invoga
        $tom = "INSERT INTO `vtiger_fieldmodulerel` (`fieldid`, `module`, `relmodule`, `status`, `sequence`) VALUES ('$id', 'Equipment', 'Accounts', NULL, NULL)";
        $adb->pquery($tom);
    } else {
        echo "field is present -- ship_to_party  in Equipment--- <br>";
    }
} else {
    echo "Block Does not exits -- LBL_BLOCK_SYSTEM_INFORMATION in Equipment -- <br>";
}

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('servicemangedby', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'servicemangedby';
        $fieldInstance->label = 'servicemangedby';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'servicemangedby';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('Epsilon'));
    } else {
        echo "field is already Present --- product_brand in Accounts Module --- <br>";
    }
} else {
    echo " block does not exits --- PRODUCT_DETAILS -- <br>";
}

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('SER_ENGG_DETAIL', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('serviceengineername', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'serviceengineername';
        $field->column = 'serviceengineername';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Service Engineer Name';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- installedby in Accounts --- <br>";
    }
} else {
    echo "Block Does not exits -- Sale_Details in Accounts -- <br>";
}

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('ponumber', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'ponumber';
        $field->column = 'ponumber';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'PO Number';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- installedby in Accounts --- <br>";
    }
} else {
    echo "Block Does not exits -- Sale_Details in Accounts -- <br>";
}

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('Warranty Details', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('warrantystartdate', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'warrantystartdate';
        $fieldInstance->label = 'Warranty Start Date';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'warrantystartdate';
        $fieldInstance->uitype = 5;
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- warrantyenddate in Accounts Module --- <br>";
    }
} else {
    echo " block does not exits --- Sale_Details -- <br>";
}

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('Entitlement', $moduleInstance);
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
    echo " block does not exits --- PRODUCT_DETAILS -- <br>";
}

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('Entitlement', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('contact_period', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'contact_period';
        $fieldInstance->label = 'Contract Period in Month';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'contact_period';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('3','6','12','36'));
    } else {
        echo "field is already Present --- product_category in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- PRODUCT_DETAILS -- <br>";
}

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('Entitlement', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('e_status', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'e_status';
        $fieldInstance->label = 'Status';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'e_status';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('Active','InActive'));
    } else {
        echo "field is already Present --- product_category in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- PRODUCT_DETAILS -- <br>";
}

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('LBL_ACCOUNT_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('dealer_name', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'dealer_name';
        $field->column = 'dealer_name';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Dealer Name';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- customer_name in HelpDesk --- <br>";
    }
} else {
    echo "Block Does not exits -- CUSTOMER_DETAILS in HelpDesk -- <br>";
}

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('LBL_ACCOUNT_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('dealer_mobile', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'dealer_mobile';
        $field->column = 'dealer_mobile';
        $field->uitype = 11;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Dealer Mobile';
        $field->summaryfield = 1;
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(30)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- mobile HelpDesk --- <br>";
    }
} else {
    echo "Block Does not exits -- CUSTOMER_DETAILS in HelpDesk -- <br>";
}

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('country', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'country';
        $fieldInstance->label = 'Country';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'country';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('India'));
    } else {
        echo "field is already Present --- product_category in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- PRODUCT_DETAILS -- <br>";
}

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('product_name', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'product_name';
        $fieldInstance->label = 'Product Name';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'product_name';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('EP CORSA NANO',
        'EP CORSA 4SM',
        'EP CORSA 32 RF',
        'EP CORSA 6SM',
        'ASTRO 6M',
        'ASTRO 65 DR',
        'EP CORSA 6S',
        'ASTRO 65 DR',
        'ASTRO 40',
        'ASTRO 80 DR',
        'ASTRO 15',
        'ASTRO 50 DR',
        'EP CORSA 40 RF',
        'EP CORSA65 RF',
        'EP CORSA 15 RF',
        'EP CORSA 80 RF',
        'EP CORSA 50 RF',
        'EP-DENTO',
        'EP-CORSA 2.4 P',
        'EP CORSA 6 R',
        'EP CORSA 125 R',
        'EP-CORSA 6 M',
        'EP CORSA 2.5 M',
        'EP CORSA 3.5 M',
        'EP CORSA-5 M',
        'EP-100',
        'EP-300',
        'EP-500',
        'EP CORSA 15',
        'EP CORSA 32',
        'EP CORSA 40',
        'EP CORSA 50 DR',
        'EP CORSA ',
        'EP CORSA 30 ',
        'EP-VICTORY RA-6-HD',
        'EP-VICTORY RA-6-SMART',
        'EP-VICTORY RA-6-FPD HD',
        'EP-VICTORY RA-6-NUVO',
        'EP-VICTORY HF-3.5 ADVANCE HD',
        'EP-VICTORY HF-3.5 ADVANCE SMART',
        'EP-VICTORY HF-3.5 ADVANCE FPD HD',
        'EP-VICTORY HF-3.5 ADVANCE NUVO',));
    } else {
        echo "field is already Present --- product_category in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- PRODUCT_DETAILS -- <br>";
}

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('PRODUCT_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('productname', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'productname';
        $field->column = 'productname';
        $field->uitype = 10;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Product Name';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- productname in Equipment --- <br>";
    }
} else {
    echo "Block Does not exits -- LBL_BLOCK_GENERAL_INFORMATION in Equipment -- <br>";
}

$emm = null;
$emm = new VTEntityMethodManager($adb);
$result = $adb->pquery("SELECT function_name FROM com_vtiger_workflowtasks_entitymethod WHERE module_name=? AND method_name=?", array('Accounts', 'AccountsWarrantyStatusUpdate'));
if ($adb->num_rows($result) == 0) {
    $emm->addEntityMethod("Accounts", "AccountsWarrantyStatusUpdate", "modules/Accounts/AccountsWarrantyStatusUpdate.php", "AccountsWarrantyStatusUpdate");
} else {
    print_r("already exits --- workflow function -- AccountsWarrantyStatusUpdate in Accounts Module <br> ");
}

$emm = null;
$emm = new VTEntityMethodManager($adb);
$result = $adb->pquery("SELECT function_name FROM com_vtiger_workflowtasks_entitymethod WHERE module_name=? AND method_name=?", array('Accounts', 'AccountsWarrantyCountdownUpdate'));
if ($adb->num_rows($result) == 0) {
    $emm->addEntityMethod("Accounts", "AccountsWarrantyCountdownUpdate", "modules/Accounts/AccountsWarrantyCountdownUpdate.php", "AccountsWarrantyCountdownUpdate");
} else {
    print_r("already exits --- workflow function -- AccountsWarrantyCountdownUpdate in Accounts Module <br> ");
}

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Users');
$blockInstance = Vtiger_Block::getInstance('LBL_USERLOGIN_ROLE', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('user_zone', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'user_zone';
        $fieldInstance->label = 'Zone';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'user_zone';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('North 1', 'East', 'West','South', 'UP' , 'RAJASTHAN'));
    } else {
        echo "field is already Present --- product_brand in Accounts Module --- <br>";
    }
} else {
    echo " block does not exits --- PRODUCT_DETAILS -- <br>";
}

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('equipment_serialno', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'equipment_serialno';
        $field->column = 'equipment_serialno';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Equipment Sl. No.';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->displaytype = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- equipment_serialno in Equipment --- <br>";
    }
} else {
    echo "Block Does not exits -- LBL_BLOCK_GENERAL_INFORMATION in Equipment -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('account_id', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'account_id';
        $field->column = 'account_id';
        $field->uitype = 10;
        $field->table = $invoiceModule->basetable;
        $field->label = 'CUSTOMER NAME';
        $field->summaryfield = 1;
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'I~O';
        $field->columntype = 'INT(30)';
        $field->displaytype = 1;
        $id = $blockInstance->addFieldWithReturn($field);
        $invogamoduleInstance = Vtiger_Module::getInstance('Accounts');
        $relationLabel  = 'Equipments';
        $invogamoduleInstance->setRelatedList(
            $invoiceModule,
            $relationLabel,
            array('ADD'),
            'get_dependents_list'
        );
        $tom = "INSERT INTO `vtiger_fieldmodulerel` (`fieldid`, `module`, `relmodule`, `status`, `sequence`) VALUES ('$id', 'Equipment', 'Accounts', NULL, NULL)";
        $adb->pquery($tom);
    } else {
        echo "field is present -- account_id  in Equipment--- <br>";
    }
} else {
    echo "Block Does not exits -- LBL_BLOCK_GENERAL_INFORMATION in Equipment -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('date_of_dis', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'date_of_dis';
        $fieldInstance->label = 'DOD';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'date_of_dis';
        $fieldInstance->uitype = 5;
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- date_of_dis in Equipment Module --- <br>";
    }
} else {
    echo "block does not exits --- Customer_Warranty in Equipment-- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('po_no', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'po_no';
        $field->column = 'po_no';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'P.O. NO.';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->displaytype = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- po_no in Equipment --- <br>";
    }
} else {
    echo "Block Does not exits -- LBL_BLOCK_GENERAL_INFORMATION in Equipment -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('date_of_inst', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'date_of_inst';
        $fieldInstance->label = 'DOI';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'date_of_inst';
        $fieldInstance->uitype = 5;
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- date_of_inst in Equipment Module --- <br>";
    }
} else {
    echo "block does not exits --- LBL_BLOCK_GENERAL_INFORMATION in Equipment-- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('inst_by', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'inst_by';
        $field->column = 'inst_by';
        $field->uitype = 10;
        $field->table = $invoiceModule->basetable;
        $field->label = 'INSTALLED BY';
        $field->typeofdata = 'I~O';
        $field->columntype = 'INT(30)';
        $field->displaytype = 1;
        $id = $blockInstance->addFieldWithReturn($field);
        echo "created field --- $id ";
        $sqlOfThequery = "INSERT INTO `vtiger_fieldmodulerel`
        (`fieldid`, `module`, `relmodule`, `status`, `sequence`)
        VALUES ('$id', 'Equipment', 'ServiceEngineer', NULL, NULL)";
        $adb->pquery($sqlOfThequery);
    } else {
        echo "field is present -- inst_by  in Equipment--- <br>";
    }
} else {
    echo "Block Does not exits -- LBL_BLOCK_GENERAL_INFORMATION in Equipment -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('manager_name', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'manager_name';
        $field->column = 'manager_name';
        $field->uitype = 10;
        $field->table = $invoiceModule->basetable;
        $field->label = 'MANAGER NAME';
        $field->typeofdata = 'I~O';
        $field->columntype = 'INT(30)';
        $field->displaytype = 1;
        $id = $blockInstance->addFieldWithReturn($field);
        echo "created field --- $id ";
        $sqlOfThequery = "INSERT INTO `vtiger_fieldmodulerel`
        (`fieldid`, `module`, `relmodule`, `status`, `sequence`)
        VALUES ('$id', 'Equipment', 'ServiceEngineer', NULL, NULL)";
        $adb->pquery($sqlOfThequery);
    } else {
        echo "field is present -- manager_name  in Equipment--- <br>";
    }
} else {
    echo "Block Does not exits -- LBL_BLOCK_GENERAL_INFORMATION in Equipment -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('site_owner', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'site_owner';
        $field->column = 'site_owner';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'SITE OWNER';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->displaytype = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- site_owner in Equipment --- <br>";
    }
} else {
    echo "Block Does not exits -- LBL_BLOCK_GENERAL_INFORMATION in Equipment -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('war_start_date', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'war_start_date';
        $fieldInstance->label = 'WARRANTY START DATE';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'war_start_date';
        $fieldInstance->uitype = 5;
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- war_start_date in Equipment Module --- <br>";
    }
} else {
    echo "block does not exits --- LBL_BLOCK_GENERAL_INFORMATION in Equipment-- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('Customer_Warranty', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('war_in_months', $moduleInstance);
    if (!$fieldInstance) {
        // $fieldInstance = new Vtiger_Field();
        // $fieldInstance->name = 'war_in_months';
        // $fieldInstance->column = 'war_in_months';
        // $fieldInstance->uitype = 7;
        // $fieldInstance->table = $moduleInstance->basetable;
        // $fieldInstance->label = 'WARRANTY PERIODS IN MONTHS';
        // $fieldInstance->summaryfield = 1;
        // $fieldInstance->readonly = 1;
        // $fieldInstance->presence = 2;
        // $fieldInstance->typeofdata = 'I~O';
        // $fieldInstance->columntype = 'INT(10)';
        // $fieldInstance->displaytype = 1;
        // $fieldInstance->masseditable = 1;
        // $blockInstance->addField($fieldInstance);

        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'war_in_months';
        $fieldInstance->label = 'WARRANTY PERIODS IN MONTHS';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'war_in_months';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('3','6','12','36'));
    } else {
        echo "field is already Present --- war_in_months in Equipment Module --- <br>";
    }
} else {
    echo " block does not exits --- Customer_Warranty in Equipment -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('war_end_date', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'war_end_date';
        $fieldInstance->label = 'WARRANTY END DATE';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'war_end_date';
        $fieldInstance->uitype = 5;
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- war_end_date in Equipment Module --- <br>";
    }
} else {
    echo "block does not exits --- LBL_BLOCK_GENERAL_INFORMATION in Equipment-- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('eq_run_war_st', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'eq_run_war_st';
        $fieldInstance->label = 'Running Status';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'eq_run_war_st';
        $fieldInstance->uitype = '16';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('Under Warranty', 'In Active', 'Contract', 'Outside Warranty', 'Active'));
    } else {
        echo "field is already Present --- eq_run_war_st in Equipment Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_BLOCK_GENERAL_INFORMATION in Equipment -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('days_left_in_war', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'days_left_in_war';
        $fieldInstance->column = 'days_left_in_war';
        $fieldInstance->uitype = 7;
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->label = 'DAYS LEFT IN WARRANTY';
        $fieldInstance->readonly = 1;
        $fieldInstance->presence = 2;
        $fieldInstance->typeofdata = 'I~O';
        $fieldInstance->columntype = 'INT(10)';
        $fieldInstance->displaytype = 1;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- days_left_in_war in Equipment Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_BLOCK_GENERAL_INFORMATION in Equipment -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('service_offered', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'service_offered';
        $fieldInstance->label = 'SERVICE OFFERED';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'service_offered';
        $fieldInstance->uitype = '16';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('AMC',  'CMC'));
    } else {
        echo "field is already Present --- service_offered in Equipment Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_BLOCK_GENERAL_INFORMATION in Equipment -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('Contract Details', $moduleInstance);
if ($blockInstance) {
    echo " block does not exits --- Contract Details   -- <br>";
} else {
    $blockInstance = new Vtiger_Block();
    $blockInstance->label = 'Contract Details';
    $moduleInstance->addBlock($blockInstance);
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('Contract Details', $moduleInstance);
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
        echo "field is already Present --- amc_start_date in Equipment Module --- <br>";
    }
} else {
    echo "block does not exits --- in Equipment-- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('Contract Details', $moduleInstance);
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
        echo "field is already Present --- amc_end_date in Equipment Module --- <br>";
    }
} else {
    echo "block does not exits --- in Equipment-- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('Contract Details', $moduleInstance);
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
        echo "field is already Present --- amc_status in Equipment Module --- <br>";
    }
} else {
    echo " block does not exits --- Contract Details in Equipment -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('Customer_Warranty', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('warranty_status', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'warranty_status';
        $fieldInstance->label = 'WARRANTY STATUS';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'warranty_status';
        $fieldInstance->uitype = '16';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('In Active', 'Active'));
    } else {
        echo "field is already Present --- warranty_status in Equipment Module --- <br>";
    }
} else {
    echo " block does not exits --- Customer_Warranty in Equipment -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('CUSTOMER_DETAILS', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('equipment_id', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'equipment_id';
        $field->column = 'equipment_id';
        $field->uitype = 10;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Equipment Serial No.';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'I~O';
        $field->columntype = 'INT(10)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $id = $blockInstance->addFieldWithReturn($field);
        echo "created field --- $id ";
        $tom = "INSERT INTO `vtiger_fieldmodulerel` (`fieldid`, `module`, `relmodule`, `status`, `sequence`) VALUES ('$id', 'Accounts', 'Equipment', NULL, NULL)";
        $adb->pquery($tom);
    } else {
        echo "field is present -- equipment_id  in HelpDesk --- <br>";
    }
} else {
    echo "Block Does not exits -- CUSTOMER_DETAILS in HelpDesk -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

// model_number

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('CUSTOMER_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('model_number', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'model_number';
        $fieldInstance->label = 'EQUIPMENT MODEL NAME';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'model_number';
        $fieldInstance->uitype = '16';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- model_number in Equipment Module --- <br>";
    }
} else {
    echo " block does not exits --- CUSTOMER_DETAILS in Equipment -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Accounts');
$blockInstance = Vtiger_Block::getInstance('LBL_ADDRESS_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('account_district', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'account_district';
        $field->column = 'account_district';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'District';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->displaytype = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- District in Customers --- <br>";
    }
} else {
    echo "Block Does not exits -- Address Details in Customers -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('SCAgree');
$blockInstance = Vtiger_Block::getInstance('LBL_ITEM_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('date_of_expiray', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'date_of_expiray';
        $fieldInstance->label = 'Date Of Expirary Of Service';
        $fieldInstance->table = 'vtiger_inventoryproductrel';
        $fieldInstance->column = 'date_of_expiray';
        $fieldInstance->uitype = 5;
        $fieldInstance->presence = '0';
        $fieldInstance->helpinfo = 'li_lg';
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- date_of_expiray in SCAgree Module --- <br>";
    }
} else {
    echo "block does not exits --- LBL_ITEM_DETAILS -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;


$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('SCAgree');
$blockInstance = Vtiger_Block::getInstance('LBL_ITEM_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('period_of_contact_fr', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'period_of_contact_fr';
        $fieldInstance->label = 'Period Of Contract From';
        $fieldInstance->table = 'vtiger_inventoryproductrel';
        $fieldInstance->column = 'period_of_contact_fr';
        $fieldInstance->uitype = 5;
        $fieldInstance->presence = '0';
        $fieldInstance->helpinfo = 'li_lg';
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- period_of_contact_fr in SCAgree Module --- <br>";
    }
} else {
    echo "block does not exits --- LBL_ITEM_DETAILS -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('SCAgree');
$blockInstance = Vtiger_Block::getInstance('LBL_ITEM_DETAILS', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('period_of_contact_to', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'period_of_contact_to';
        $fieldInstance->label = 'Period Of Contract To';
        $fieldInstance->table = 'vtiger_inventoryproductrel';
        $fieldInstance->column = 'period_of_contact_to';
        $fieldInstance->uitype = 5;
        $fieldInstance->presence = '0';
        $fieldInstance->helpinfo = 'li_lg';
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- period_of_contact_to in SCAgree Module --- <br>";
    }
} else {
    echo "block does not exits --- LBL_ITEM_DETAILS -- <br>";
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
    $fieldInstance = Vtiger_Field::getInstance('eq_run_war_st', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'eq_run_war_st';
        $fieldInstance->label = 'Runing Status';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'eq_run_war_st';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('Under Warranty', 'Outside Contract', 'Contract', 'Outside Warranty'));
    } else {
        echo "field is already Present --- eq_run_war_st in Equipment Module --- <br>";
    }
} else {
    echo " block does not exits --- Customer_Warranty in Equipment -- <br>";
}

if (Vtiger_Utils::CheckTable('vtiger_pm_schedule')) {
    print_r("================Table Exits vtiger_pm_schedule ===============");
}  else {
    print_r("================Table Does Not Exits vtiger_pm_schedule ===============");
    Vtiger_Utils::CreateTable('vtiger_pm_schedule',
    '(
        `id` int(19) DEFAULT NULL,
        `lineitem_id` int(11) NOT NULL AUTO_INCREMENT,
        PRIMARY KEY (`lineitem_id`),
        KEY `vtiger_pm_schedule_id_idx` (`id`),
        CONSTRAINT `fk_crmid_vtiger_pm_schedule` FOREIGN KEY (`id`) REFERENCES `vtiger_crmentity` (`crmid`) ON DELETE CASCADE
      ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8',false);
}

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('PeriodicalMaintainence');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('no_of_installments', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'no_of_installments';
        $fieldInstance->column = 'no_of_installments';
        $fieldInstance->uitype = 7;
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->label = 'Number Of Times PM is Done';
        $fieldInstance->summaryfield = 1;
        $fieldInstance->readonly = 1;
        $fieldInstance->presence = 2;
        $fieldInstance->typeofdata = 'I~O';
        $fieldInstance->columntype = 'INT(10)';
        $fieldInstance->displaytype = 1;
        $fieldInstance->masseditable = 1;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- no_of_installments in PeriodicalMaintainence Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_BLOCK_GENERAL_INFORMATION in PeriodicalMaintainence -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('PeriodicalMaintainence');
$blockInstance = Vtiger_Block::getInstance('Periodic_Schedule', $moduleInstance);
if ($blockInstance) {
    echo " block does not exits --- Periodic_Schedule   -- <br>";
} else {
    $blockInstance = new Vtiger_Block();
    $blockInstance->label = 'Periodic_Schedule';
    $moduleInstance->addBlock($blockInstance);
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;


$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('PeriodicalMaintainence');
$blockInstance = Vtiger_Block::getInstance('Periodic_Schedule', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('pay_sch_sl_no', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'pay_sch_sl_no';
        $fieldInstance->column = 'pay_sch_sl_no';
        $fieldInstance->uitype = 7;
        $fieldInstance->table = 'vtiger_pm_schedule';
        $fieldInstance->label = 'Number';
        $fieldInstance->readonly = 1;
        $fieldInstance->presence = 2;
        $fieldInstance->helpinfo = 'li_lg_1';
        $fieldInstance->typeofdata = 'I~O';
        $fieldInstance->columntype = 'INT(10)';
        $fieldInstance->displaytype = 1;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- pay_sch_sl_no in PeriodicalMaintainence Module --- <br>";
    }
} else {
    echo " block does not exits --- Periodic_Schedule in PeriodicalMaintainence -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('PeriodicalMaintainence');
$blockInstance = Vtiger_Block::getInstance('Periodic_Schedule', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('payment_start_date', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'payment_start_date';
        $fieldInstance->label = 'Start Date';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'payment_start_date';
        $fieldInstance->uitype = 5;
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- payment_start_date in Accounts Module --- <br>";
    }
} else {
    echo " block does not exits --- Periodic_Schedule -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('PeriodicalMaintainence');
$blockInstance = Vtiger_Block::getInstance('Periodic_Schedule', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('payment_date', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'payment_date';
        $fieldInstance->column = 'payment_date';
        $fieldInstance->table = 'vtiger_pm_schedule';
        $fieldInstance->label = 'Date';
        $fieldInstance->helpinfo = 'li_lg_1';
        $fieldInstance->displaytype = 1;
        $fieldInstance->uitype = 5;
        $fieldInstance->typeofdata = 'D~O';
        $fieldInstance->columntype = 'DATE';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
    } else {
        echo "field is already Present --- payment_date in PeriodicalMaintainence Module --- <br>";
    }
} else {
    echo " block does not exits --- Periodic_Schedule in PeriodicalMaintainence -- <br>";
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
    $fieldInstance = Vtiger_Field::getInstance('payment_frequency', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'payment_frequency';
        $fieldInstance->label = 'Frequency';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'payment_frequency';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('Monthly', 'Trimester', 'Quarterly', 'Yearly'));
    } else {
        echo "field is already Present --- payment_frequency in PeriodicalMaintainence Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_BLOCK_GENERAL_INFORMATION in PeriodicalMaintainence -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('PeriodicalMaintainence');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('equipment_id', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'equipment_id';
        $field->column = 'equipment_id';
        $field->uitype = 10;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Equipment Serial No.';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'I~O';
        $field->columntype = 'INT(10)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $id = $blockInstance->addFieldWithReturn($field);
        echo "created field --- $id ";
        $tom = "INSERT INTO `vtiger_fieldmodulerel` (`fieldid`, `module`, `relmodule`, 
        `status`, `sequence`) VALUES ('$id', 'PeriodicalMaintainence', 'Equipment', NULL, NULL)";
        $adb->pquery($tom);
    } else {
        echo "field is present -- equipment_id  in PeriodicalMaintainence --- <br>";
    }
} else {
    echo "Block Does not exits -- LBL_BLOCK_GENERAL_INFORMATION in PeriodicalMaintainence -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('PeriodicalMaintainence');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('account_id', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'account_id';
        $field->column = 'account_id';
        $field->uitype = 10;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Customer Name';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'I~O';
        $field->columntype = 'INT(10)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $id = $blockInstance->addFieldWithReturn($field);
        echo "created field --- $id ";
        $tom = "INSERT INTO `vtiger_fieldmodulerel` (`fieldid`, `module`, `relmodule`, 
        `status`, `sequence`) VALUES ('$id', 'PeriodicalMaintainence', 'Accounts', NULL, NULL)";
        $adb->pquery($tom);

        $invogamoduleInstance = Vtiger_Module::getInstance('Accounts');
        $relationLabel  = 'PeriodicalMaintainence';
        $invogamoduleInstance->setRelatedList(
            $invoiceModule,
            $relationLabel,
            array('ADD'),
            'get_dependents_list'
        );
    } else {
        echo "field is present -- account_id in PeriodicalMaintainence --- <br>";
    }
} else {
    echo "Block Does not exits -- LBL_BLOCK_GENERAL_INFORMATION in PeriodicalMaintainence -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$emm = null;
$emm = new VTEntityMethodManager($adb);
$result = $adb->pquery("SELECT function_name FROM com_vtiger_workflowtasks_entitymethod
 WHERE module_name=? AND method_name=?", array('PeriodicalMaintainence', 'CreatePeriodicMaintainence'));
if ($adb->num_rows($result) == 0) {
    $emm->addEntityMethod("PeriodicalMaintainence", "CreatePeriodicMaintainence", 
    "modules/PeriodicalMaintainence/CreatePeriodicMaintainence.php", "CreatePeriodicMaintainence");
} else {
    print_r("already exits --- workflow function -- 
    CreatePeriodicMaintainence in PeriodicalMaintainence Module <br> ");
}

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('ServiceEngineer');
$blockInstance = Vtiger_Block::getInstance('LBL_USERLOGIN_ROLE', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('serv_zone', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'serv_zone';
        $fieldInstance->label = 'Zone';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'serv_zone';
        $fieldInstance->uitype = '16';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('EAST'));
    } else {
        echo "field is already Present --- serv_zone in ServiceEngineer Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_USERLOGIN_ROLE in ServiceEngineer -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('ServiceEngineer');
$blockInstance = Vtiger_Block::getInstance('LBL_USERLOGIN_ROLE', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('serv_role', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'serv_role';
        $fieldInstance->label = 'Role';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'serv_role';
        $fieldInstance->uitype = '16';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('Service Engineer', 'Service Manager'));
    } else {
        echo "field is already Present --- serv_role in ServiceEngineer Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_USERLOGIN_ROLE in ServiceEngineer -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('Contract Details', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('contact_period', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'contact_period';
        $fieldInstance->label = 'Contract Period in Month';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'contact_period';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('3','6','12','36'));
    } else {
        echo "field is already Present --- Contract Details in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- Contract Details -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('Contract Details', $moduleInstance);
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
        echo "field is already Present --- product_category in Equipment Module --- <br>";
    }
} else {
    echo " block does not exits --- Contract Details -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;

$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('servicemangedby', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'servicemangedby';
        $fieldInstance->label = 'Service Manged By';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'servicemangedby';
        $fieldInstance->uitype = '16';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('Epsilon','Dealer'));
    } else {
        echo "field is already Present --- product_brand in Equipment Module --- <br>";
    }
} else {
    echo " block does not exits --- LBL_BLOCK_GENERAL_INFORMATION -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;
$invoiceModule = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('dealer_name', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'dealer_name';
        $field->column = 'dealer_name';
        $field->uitype = 2;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Dealer Name';
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(250)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- customer_name in HelpDesk --- <br>";
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
$invoiceModule = Vtiger_Module::getInstance('Equipment');
$blockInstance = Vtiger_Block::getInstance('LBL_BLOCK_GENERAL_INFORMATION', $invoiceModule);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('dealer_mobile', $invoiceModule);
    if (!$fieldInstance) {
        $field = new Vtiger_Field();
        $field->name = 'dealer_mobile';
        $field->column = 'dealer_mobile';
        $field->uitype = 11;
        $field->table = $invoiceModule->basetable;
        $field->label = 'Dealer Mobile';
        $field->summaryfield = 1;
        $field->readonly = 1;
        $field->presence = 2;
        $field->typeofdata = 'V~O';
        $field->columntype = 'VARCHAR(30)';
        $field->quickcreate = 3;
        $field->displaytype = 1;
        $field->masseditable = 1;
        $blockInstance->addField($field);
    } else {
        echo "field is present -- mobile HelpDesk --- <br>";
    }
} else {
    echo "Block Does not exits -- CUSTOMER_DETAILS in HelpDesk -- <br>";
}
$invoiceModule = null;
$blockInstance = null;
$fieldInstance = null;

$emm = null;
$emm = new VTEntityMethodManager($adb);
$result = $adb->pquery("SELECT function_name FROM com_vtiger_workflowtasks_entitymethod
WHERE module_name=? AND method_name=?", array('HelpDesk', 'updateTicketClosedDate'));
if ($adb->num_rows($result) == 0) {
    $emm->addEntityMethod("HelpDesk", "updateTicketClosedDate",
    "modules/HelpDesk/updateTicketClosedDate.php", "updateTicketClosedDate");
} else {
    print_r("already exits --- workflow function --
    updateTicketClosedDate in Accounts Module <br> ");
}

global $adb;
$tabid = getTabId('Equipment');
$sql = "update vtiger_field set uitype = 7 where tabid = ? and fieldname = 'war_in_months'";
$adb->pquery($sql , array($tabid));

global $adb;
$tabid = getTabId('Equipment');
$sql = "update vtiger_field set uitype = 7 where tabid = ? and fieldname = 'contact_period'";
$adb->pquery($sql , array($tabid));


$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;
$moduleInstance = Vtiger_Module::getInstance('HelpDesk');
$blockInstance = Vtiger_Block::getInstance('Upload File Details', $moduleInstance);
if ($blockInstance) {
    $fieldInstance = Vtiger_Field::getInstance('uploadvideo', $moduleInstance);
    if (!$fieldInstance) {
        $fieldInstance = new Vtiger_Field();
        $fieldInstance->name = 'uploadvideo';
        $fieldInstance->label = 'Parts Video Or Service Report Document  ';
        $fieldInstance->table = $moduleInstance->basetable;
        $fieldInstance->column = 'uploadvideo';
        $fieldInstance->uitype = '69';
        $fieldInstance->presence = '0';
        $fieldInstance->typeofdata = 'V~O';
        $fieldInstance->columntype = 'VARCHAR(100)';
        $fieldInstance->defaultvalue = NULL;
        $blockInstance->addField($fieldInstance);
        $fieldInstance->setPicklistValues(array('test value'));
    } else {
        echo "field is already Present --- uploadvideo in HelpDesk Module --- <br>";
    }
} else {
    echo " block does not exits --- Upload File Details -- <br>";
}
$moduleInstance = null;
$blockInstance = null;
$fieldInstance = null;