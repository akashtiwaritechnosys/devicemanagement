<?php
class Users_AcceptPolicy_Action extends Vtiger_Action_Controller {
	function checkPermission(Vtiger_Request $request) {
		return true;
	}

	function process(Vtiger_Request $request) {
		global $current_user;
		$db = PearDatabase::getInstance();

		$db->pquery(
			"UPDATE vtiger_users SET privacy_policy_accepted = 1 WHERE id = ?",
			[$current_user->id]
		);

		echo json_encode(['status' => 'success']);
	}
}
