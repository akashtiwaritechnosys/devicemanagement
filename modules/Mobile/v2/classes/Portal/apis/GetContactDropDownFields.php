<?php

class Portal_GetContactDropDownFields_API extends Portal_Default_API {

	public function requireLogin() {
		return false;
	}

	public function preProcess(Portal_Request $request) {
	}

	public function postProcess(Portal_Request $request) {
	}

	public function process(Portal_Request $request) {
		$params = array(
			'_operation' => 'GetContactDropDownFields'
		);
		$wholeRequest = array_merge($request->getAll(), $_REQUEST);
		$wholeRequest['_operation'] = $wholeRequest['api'];
		$result = Vtiger_Connector::getInstance()->fireRequest($wholeRequest);
		$response = new Portal_Response();
		if (isset($result['code'])) {
			$response->setError($result['code'], $result['message']);
		} else {
			$response->setApiSucessMessage('Successfully Fetched Data');
			$response->setResult($result);
		}
		return $response;
	}
}
