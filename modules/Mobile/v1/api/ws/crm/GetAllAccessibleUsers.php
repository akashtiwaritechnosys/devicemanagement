<?php
class Mobile_WS_GetAllAccessibleUsers extends Mobile_WS_Controller {

    function process(Mobile_API_Request $request) {
        $response = new Mobile_API_Response();
        $currentUserModel = Users_Record_Model::getCurrentUserModel();
        $allUsers = $currentUserModel->getAccessibleUsers();
        $picklistValues = [];

        // Get search key from request
        $searchKey = $request->get('searchKey');

        foreach ($allUsers as $userId => $userName) {
            // Apply search filter (case-insensitive)
            if (empty($searchKey) || stripos($userName, $searchKey) !== false) {
                $val = [];
                $val['id'] = $userId;
                $val['label'] = $userName;
                array_push($picklistValues, $val);
            }
        }

        $ResponseObject['AllAccessibleUsers'] = $picklistValues;
        $response->setResult($ResponseObject);
        $response->setApiSucessMessage('Successfully Fetched Data');
        return $response;
    }
}
