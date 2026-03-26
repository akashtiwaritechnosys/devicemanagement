<?php

include_once 'modules/Vtiger/CRMEntity.php';
//require_once('modules/Logging/LoggerManager.php');
//require_once('include/logging.php');

class PeriodicalMaintainence extends Vtiger_CRMEntity {
	var $table_name = 'vtiger_periodicalmaintainence';
	var $table_index = 'periodicalmaintainenceid';

	var $customFieldTable = array('vtiger_periodicalmaintainencecf', 'periodicalmaintainenceid');

	var $tab_name = array(
		'vtiger_crmentity', 'vtiger_periodicalmaintainence',
		'vtiger_periodicalmaintainencecf', 'vtiger_pm_schedule'
	);

	var $tab_name_index = array(
		'vtiger_crmentity' => 'crmid',
		'vtiger_periodicalmaintainence' => 'periodicalmaintainenceid',
		'vtiger_periodicalmaintainencecf' => 'periodicalmaintainenceid',
		'vtiger_pm_schedule' => 'id'
	);

	var $list_fields = array();
	var $list_fields_name = array();

	// Make the field link to detail view
	var $list_link_field = 'equipment_id';

	// For Popup listview and UI type support
	var $search_fields = array();
	var $search_fields_name = array();

	// For Popup window record selection
	var $popup_fields = array('equipment_id');

	// For Alphabetical search
	var $def_basicsearch_col = 'equipment_id';

	// Column value to use on detail view record text display
	var $def_detailview_recname = 'equipment_id';

	// Used when enabling/disabling the mandatory fields for the module.
	// Refers to vtiger_field.fieldname values.
	var $mandatory_fields = array('equipment_id', 'assigned_user_id');

	var $default_order_by = 'equipment_id';
	var $default_sort_order = 'ASC';

	function PeriodicalMaintainence() {
		$this->log = Logger::getLogger('PeriodicalMaintainence');
		$this->db = PearDatabase::getInstance();
		$this->column_fields = getColumnFields('PeriodicalMaintainence');
	}

	/**
	 * Invoked when special actions are performed on the module.
	 * @param String Module name
	 * @param String Event Type
	 */
	function vtlib_handler($moduleName, $eventType) {
		if ($eventType == 'module.postinstall') {
			//Enable ModTracker for the module
			static::enableModTracker($moduleName);
			//Create Related Lists
			static::createRelatedLists();
		} else if ($eventType == 'module.disabled') {
			// Handle actions before this module is being uninstalled.
		} else if ($eventType == 'module.preuninstall') {
			// Handle actions when this module is about to be deleted.
		} else if ($eventType == 'module.preupdate') {
			// Handle actions before this module is updated.
		} else if ($eventType == 'module.postupdate') {
			//Create Related Lists
			static::createRelatedLists();
		}
	}

	function save_module($module) {
		global $onlyFromWeb;
		$onlyFromWeb = true;
		$total_year_cont = $this->column_fields['no_of_installments'];
		include_once('include/utils/IgClassUtils.php');
		IgClassUtils::saveLineDetailsEquipment1(
			$total_year_cont,
			$this->id,
			'PeriodicalMaintainence'
		);
	}

	/**
	 * Enable ModTracker for the module
	 */
	public static function enableModTracker($moduleName) {
		include_once 'vtlib/Vtiger/Module.php';
		include_once 'modules/ModTracker/ModTracker.php';

		//Enable ModTracker for the module
		$moduleInstance = Vtiger_Module::getInstance($moduleName);
		ModTracker::enableTrackingForModule($moduleInstance->getId());
	}

	protected static function createRelatedLists() {
		include_once('vtlib/Vtiger/Module.php');
	}

	function insertIntoEntityTable($table_name, $module, $fileid = '') {
		//Ignore relation table insertions while saving of the record
		if ($table_name == 'vtiger_pm_schedule') {
			return;
		}
		parent::insertIntoEntityTable($table_name, $module, $fileid);
	}
}
