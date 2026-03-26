<?php
/***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

include_once 'modules/Vtiger/CRMEntity.php';

class ServiceEngineer extends Vtiger_CRMEntity {
	var $table_name = 'vtiger_serviceengineer';
	var $table_index= 'serviceengineerid';

	/**
	 * Mandatory table for supporting custom fields.
	 */
	var $customFieldTable = Array('vtiger_serviceengineercf', 'serviceengineerid');

	/**
	 * Mandatory for Saving, Include tables related to this module.
	 */
	var $tab_name = Array('vtiger_crmentity', 'vtiger_serviceengineer', 'vtiger_serviceengineercf');

	/**
	 * Mandatory for Saving, Include tablename and tablekey columnname here.
	 */
	var $tab_name_index = Array(
		'vtiger_crmentity' => 'crmid',
		'vtiger_serviceengineer' => 'serviceengineerid',
		'vtiger_serviceengineercf'=>'serviceengineerid');

	/**
	 * Mandatory for Listing (Related listview)
	 */
	var $list_fields = Array (

	);
	var $list_fields_name = Array (

	);

	// Make the field link to detail view
	var $list_link_field = 'service_engineer_name';

	// For Popup listview and UI type support
	var $search_fields = Array(

	);
	var $search_fields_name = Array (

	);

	// For Popup window record selection
	var $popup_fields = Array ('service_engineer_name');

	// For Alphabetical search
	var $def_basicsearch_col = 'service_engineer_name';

	// Column value to use on detail view record text display
	var $def_detailview_recname = 'service_engineer_name';

	// Used when enabling/disabling the mandatory fields for the module.
	// Refers to vtiger_field.fieldname values.
	var $mandatory_fields = Array('service_engineer_name','assigned_user_id');

	var $default_order_by = 'service_engineer_name';
	var $default_sort_order='ASC';

	function ServiceEngineer() {
		$this->log =Logger::getLogger('ServiceEngineer');
		$this->db = PearDatabase::getInstance();
		$this->column_fields = getColumnFields('ServiceEngineer');
	}

	/**
	* Invoked when special actions are performed on the module.
	* @param String Module name
	* @param String Event Type
	*/
	function vtlib_handler($moduleName, $eventType) {
 		if($eventType == 'module.postinstall') {
 			//Enable ModTracker for the module
 			static::enableModTracker($moduleName);
			//Create Related Lists
			static::createRelatedLists();
			// Update serv_eng_pre_status picklist if needed
			static::updateStatusPicklist();
		} else if($eventType == 'module.disabled') {
			// Handle actions before this module is being uninstalled.
		} else if($eventType == 'module.preuninstall') {
			// Handle actions when this module is about to be deleted.
		} else if($eventType == 'module.preupdate') {
			// Handle actions before this module is updated.
		} else if($eventType == 'module.postupdate') {
			//Create Related Lists
			static::createRelatedLists();
			// Update serv_eng_pre_status picklist if needed
			static::updateStatusPicklist();
		}
 	}
	
	/**
	 * Enable ModTracker for the module
	 */
	public static function enableModTracker($moduleName)
	{
		include_once 'vtlib/Vtiger/Module.php';
		include_once 'modules/ModTracker/ModTracker.php';
			
		//Enable ModTracker for the module
		$moduleInstance = Vtiger_Module::getInstance($moduleName);
		ModTracker::enableTrackingForModule($moduleInstance->getId());
	}
	
	protected static function createRelatedLists()
	{
		include_once('vtlib/Vtiger/Module.php');	
		// No need to add relations as they already exist
	}
	
	/**
	 * Override the save method to check for duplicate badge number
	 * and sync user status based on serv_eng_pre_status
	 */
	function save_module($module) {
		global $adb;
		
		// Check for duplicate badge number
		$badgeNo = $this->column_fields['badge_no'];
		$recordId = $this->id;
		
		// Sync with user status if this record has a status value
		$this->syncUserStatus();
		
		parent::save_module($module);
	}
	
	/**
	 * Sync the status of the service engineer with their user account
	 */
	protected function syncUserStatus() {
		global $adb;
		
		$serviceEngineerStatus = $this->column_fields['serv_eng_pre_status'];
		$badgeNo = $this->column_fields['badge_no'];
		
		// Only proceed if status is set to Active or Inactive
		if ($serviceEngineerStatus == 'Active' || $serviceEngineerStatus == 'Inactive') {
			// Find user with this badge number
			$userQuery = "SELECT id FROM vtiger_users WHERE user_name = ?";
			$userResult = $adb->pquery($userQuery, array($badgeNo));
			
			if ($adb->num_rows($userResult) > 0) {
				$userId = $adb->query_result($userResult, 0, 'id');
				
				// Update user status based on service engineer status
				$userStatus = ($serviceEngineerStatus == 'Active') ? 'Active' : 'Inactive';
				
				$updateQuery = "UPDATE vtiger_users SET status = ? WHERE id = ?";
				$adb->pquery($updateQuery, array($userStatus, $userId));
			}
		}
	}
}