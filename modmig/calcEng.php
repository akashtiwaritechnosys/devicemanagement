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
$msql = "SELECT * FROM vtiger_crmentity where setype ='Equipment' and deleted = 0";
$res = $adb->pquery($msql, array());
$_REQUEST['action'] = 'SaveAjax';
global $doingMig;
$doingMig = true;
while ($row = $adb->fetchByAssoc($res)) {
        $recordModel = Vtiger_Record_Model::getInstanceById($row['crmid']);
        $recordModel->set('mode', 'edit');
        $recordModel->save();
}