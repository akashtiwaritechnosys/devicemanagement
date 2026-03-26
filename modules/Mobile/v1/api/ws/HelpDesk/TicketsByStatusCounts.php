<?php
class Mobile_WS_TicketsByStatusCounts extends Mobile_WS_Controller {
    function process(Mobile_API_Request $request) {
        $response = new Mobile_API_Response();
        $moduleModel = Vtiger_Module_Model::getInstance('HelpDesk');
        global $current_user;
        require_once('include/utils/GeneralUtils.php');
        if(is_string($request->get('search_params'))){
            $searchParams = json_decode($request->get('search_params'));
        } else {
            $searchParams = $request->get('search_params');
        }
        $searchParams = $searchParams[0];
        $searchParams = explode(",", $searchParams[2]);
        $dateFilter = [];
        if (!empty($request->get('search_params'))) {
            $dateFilter['start'] = $searchParams[0];
            $dateFilter['end'] = $searchParams[1];
        } else {
            $dateFilter = NULL;
        }
        //$data = getUserDetailsBasedOnEmployeeModuleG($current_user->user_name);
       
        $counts['ticketStatusCounts'] = $moduleModel->getAllTicketsByStatusCountsForUser('', $dateFilter, '', '');
        
        $response->setApiSucessMessage('Successfully Fetched Data');
        $response->setResult($counts);
        return $response;
    }
}
