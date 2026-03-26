<?php
chdir(dirname(_FILE_) . '/../');
include_once 'config.php';
include_once 'include/Webservices/Relation.php';
include_once 'vtlib/Vtiger/Module.php';
include_once 'includes/main/WebUI.php';

global $current_user;
$current_user = Users::getActiveAdminUser();
$webUI = new Vtiger_WebUI();
global $adb;
$msql = "SELECT * FROM vtiger_crmentity 
INNER JOIN vtiger_equipment on vtiger_equipment.equipmentid = vtiger_crmentity.crmid
where setype ='Equipment' and deleted = 0;";
$res = $adb->pquery($msql, array());
$_REQUEST['action'] = 'SaveAjax';
global $doingMig;
$doingMig = true;
while ($row = $adb->fetchByAssoc($res)) {
        $recordModel = Vtiger_Record_Model::getInstanceById($row['crmid']);
        $installedBy = $row['inst_by'];
        if (!empty($installedBy && isRecordExists($installedBy))) {
                $recordModelSer = Vtiger_Record_Model::getInstanceById($installedBy);
                $name = $recordModelSer->get('service_engineer_name');
                $userId = getUserIdBasedOnLabel($name);
                $recordModel->set('mode', 'edit');
                $recordModel->set('assigned_user_id', $userId);
                $recordModel->save();
        }
}

function getUserIdBasedOnLabel($name) {
        global $adb;
        $sql = 'SELECT * FROM `vtiger_users` where last_name = ?';
        $res = $adb->pquery($sql, array($name));
        $recordIds = 1;
	while ($row = $adb->fetch_array($res)) {
		$recordIds =  $row['id'];
	}
	return $recordIds;
}