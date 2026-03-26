<?php

class Inventory_ServicesPopup_View extends Inventory_ProductsPopup_View {

	/**
	 * Function returns module name for which Popup will be initialized
	 * @param type $request
	 */
	function getModule($request) {
		return 'Services';
	}

	/*
	 * Function to initialize the required data in smarty to display the List View Contents
	 */
	public function initializeListViewContents(Vtiger_Request $request, Vtiger_Viewer $viewer) {
		//src_module value is added just to stop showing inactive services
		$request->set('src_module', $request->getModule());

		parent::initializeListViewContents($request, $viewer);
        $moduleModel = Vtiger_Module_Model::getInstance('Services');
        
        if (!$moduleModel->isActive()) {
			$viewer->assign('LISTVIEW_ENTRIES_COUNT', 0);
            $viewer->assign('LISTVIEW_ENTRIES', array());
            $viewer->assign('IS_MODULE_DISABLED', true);
        }

		$viewer->assign('GETURL', 'getTaxesURL');
		$viewer->assign('VIEW', 'ServicesPopup');
	}

}