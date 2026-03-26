<?php
class HelpDesk_rejectPartByManager_View extends Vtiger_Index_View {

    function __construct() {
        parent::__construct();
        $this->exposeMethod('rejectPartByManager');
    }

    public function requiresPermission(Vtiger_Request $request) {
        $permissions = parent::requiresPermission($request);
        $permissions[] = array('module_parameter' => 'module', 'action' => 'DetailView');
        return $permissions;
    }

    function process(Vtiger_Request $request) {
        $moduleName = $request->getModule();
        $recordId = $request->get('record');
        $viewer = $this->getViewer($request);
        $viewer->assign("MODULE", $moduleName);
        $viewer->assign("RECORD_ID", $recordId);
        echo $viewer->view('rejectPartByManager.tpl', $moduleName, true);
    }

    function rejectPartByManager($request) {
        $moduleName = $request->getModule();
        $recordId = $request->get('record');
        $viewer = $this->getViewer($request);
        $viewer->assign("MODULE", $moduleName);
        $viewer->assign("RECORD_ID", $recordId);
        echo $viewer->view('rejectPartByManager.tpl', $moduleName, true);
    }
}
