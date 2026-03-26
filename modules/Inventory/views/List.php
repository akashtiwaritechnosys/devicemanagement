<?php

class Inventory_List_View extends Vtiger_List_View {
	/**
	 * Function to get the list of Script models to be included
	 * @param Vtiger_Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	function getHeaderScripts(Vtiger_Request $request) {
            	$headerScriptInstances = parent::getHeaderScripts($request);

		$moduleName = $request->getModule();
		$modulePopUpFile = 'modules.'.$moduleName.'.resources.Popup';
		$moduleEditFile = 'modules.'.$moduleName.'.resources.Edit';
		$moduleListFile = 'modules.'.$moduleName.'.resources.List';
		unset($headerScriptInstances[$modulePopUpFile]);
		unset($headerScriptInstances[$moduleEditFile]);
		unset($headerScriptInstances[$moduleListFile]);

		$jsFileNames = array(
			'modules.Inventory.resources.Edit',
			'modules.Inventory.resources.Popup',
			'modules.Inventory.resources.List',
			'modules.PDFMaker.resources.PDFMakerActions',
		);
		$jsFileNames[] = $modulePopUpFile;
		$jsFileNames[] = $moduleEditFile;
		$jsFileNames[] = $moduleListFile;

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}
?>
