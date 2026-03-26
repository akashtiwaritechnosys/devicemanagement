<?php
include_once 'include/Webservices/Delete.php';

class Mobile_WS_DeleteAccount extends Mobile_WS_Controller {

    function process(Mobile_API_Request $request) {
        $response = new Mobile_API_Response();
        global $adb;

        $userName = $request->get('user_name');

        if (empty($userName)) {
            $response->setError(100, "Invalid request. Username is required.");
            return $response;
        }

        $adb->startTransaction();

        try {
            // Get user ID
            $sqlUser = 'SELECT id FROM vtiger_users WHERE user_name = ?';
            $resultUser = $adb->pquery($sqlUser, array($userName));

            if ($adb->num_rows($resultUser) == 0) {
                $response->setError(404, "User not found.");
                return $response;
            }

            $userId = $adb->query_result($resultUser, 0, 'id');
            error_log("Deleting user ID: " . $userId); // Debugging

            // Check and delete service engineer
            $sqlServiceEngineer = 'SELECT serviceengineerid FROM vtiger_serviceengineer WHERE badge_no = ?';
            $resultServiceEngineer = $adb->pquery($sqlServiceEngineer, array($userName));

            if ($adb->num_rows($resultServiceEngineer) > 0) {
                $serviceEngineerId = $adb->query_result($resultServiceEngineer, 0, 'serviceengineerid');
                $sqlDeleteServiceEngineer = 'DELETE FROM vtiger_serviceengineer WHERE serviceengineerid = ?';
                $adb->pquery($sqlDeleteServiceEngineer, array($serviceEngineerId));
                error_log("Deleted service engineer ID: " . $serviceEngineerId);
            }

            // Delete user
            $sqlDeleteUser = 'DELETE FROM vtiger_users WHERE id = ?';
            $resultDeleteUser = $adb->pquery($sqlDeleteUser, array($userId));

            if (!$resultDeleteUser) {
                throw new Exception("Failed to delete user from vtiger_users.");
            }
            error_log("User deleted successfully.");

            // Commit transaction
            $adb->completeTransaction();

            // Destroy session
            session_destroy();  

            $response->setApiSucessMessage('Your account has been deleted successfully.');
            $response->setResult([
                "user_name" => $userName,
                "user_id" => $userId,
                "message" => "Your account has been deleted successfully."
            ]);
        } catch (Exception $e) {
            $adb->rollbackTransaction();
            error_log("Error deleting account: " . $e->getMessage());
            $response->setError(1501, 'Error deleting account: ' . $e->getMessage());
        }

        return $response;
    }
}
