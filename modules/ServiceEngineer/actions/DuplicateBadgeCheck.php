<?php
class ServiceEngineer_DuplicateBadgeCheck_Action extends Vtiger_Action_Controller {
    
    // Set CSRF requirement to false since this is likely an AJAX call
    public function checkPermission(Vtiger_Request $request) {
        return true;
    }
    
    public function process(Vtiger_Request $request) {
        global $adb;
        $response = new Vtiger_Response();
        
        // Get the badge number and sanitize it
        $badgeNo = trim($request->get('badge_no'));
        $recordId = $request->get('record'); // Will be empty during creation
        
        // Validate badge number
        if (empty($badgeNo)) {
            $response->setError('Badge number is required.');
            $response->emit();
            return;
        }
        
        // Check for duplicate badge numbers
        $params = array($badgeNo);
        $query = "SELECT serviceengineerid FROM vtiger_serviceengineer 
                  INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_serviceengineer.serviceengineerid 
                  WHERE vtiger_crmentity.deleted = 0 AND badge_no = ?";
        
        // If updating an existing record, exclude the current record from the check
        if (!empty($recordId)) {
            $query .= " AND serviceengineerid != ?";
            $params[] = $recordId;
        }
        
        $result = $adb->pquery($query, $params);
        
        if ($adb->num_rows($result) > 0) {
            $response->setError("Cannot create ticket. A record with this badge number already exists.");
            $response->emit();
            return;
        }
        
        // If no duplicate found, return success
        $response->setResult(array('success' => true));
        $response->emit();
    }
}