<?php
class Portal_ContactUserSignUp_API extends Portal_Default_API {

	public function requireLogin() {
		return false;
	}

	public function preProcess(Portal_Request $request) {
	}

	public function postProcess(Portal_Request $request) {
	}

	public function process(Portal_Request $request) {
		$wholeRequest = array_merge($request->getAll(),$_REQUEST);
		$responseObject = Vtiger_Connector::getInstance()->ContactUserSignUp($wholeRequest);
		$response = new Portal_Response();
		if(isset($responseObject['code'])){
			$response->setError($responseObject['code'] , $responseObject['message']);
		} else {
			$response->setApiSucessMessage("Successfully User Is Created");
			$response->setResult($responseObject);
		}
		return $response;
	}
}
