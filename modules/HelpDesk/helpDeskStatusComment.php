<?php
function helpDeskStatusComment($entityData)
{
    global $ajaxEditingInSEmod, $current_user, $adb; 

    // Skip workflow logic if the flag is set
    if (!empty($ajaxEditingInSEmod) && $ajaxEditingInSEmod === true) {
        return;
    }

    $recordInfo = $entityData->{'data'};
    if($recordInfo['t_comment'] == 'null'){
       
    }else{
    $assignUserId = explode('x', $recordInfo['assigned_user_id'])[1];
    $id = explode('x', $recordInfo['id'])[1];
    $userId = $current_user->id;

    // Fetch assigned user's role
    $result = $adb->pquery("SELECT roleid FROM vtiger_user2role WHERE userid = ?", array($assignUserId));
    
    $roleName = null;
   
    if ($adb->num_rows($result) > 0) {
        $roleId = $adb->query_result($result, 0, 'roleid');
        
        // Fetch role name
        $roleResult = $adb->pquery("SELECT rolename FROM vtiger_role WHERE roleid = ?", array($roleId));
        $roleName = ($adb->num_rows($roleResult) > 0) ? $adb->query_result($roleResult, 0, 'rolename') : null;
    }
 
    $ticketStatus = $recordInfo['ticketstatus'] ?? null;
    
    // Determine comment column and value based on role
    if (stripos($roleName, 'manager') !== false || stripos($roleName, 'zonal') !== false) {
        $commentColumn = 'm_comment';
        $comment = $recordInfo['m_comment'] ?? null;
    } else if (stripos($roleName, 'engineer') !== false) {
        $commentColumn = 't_comment';
        $comment = $recordInfo['t_comment'] ?? null;
    } else {
        $comment = null;
    }

    $currentTime = date('Y-m-d H:i:s');

    // Dynamic query based on comment column
    $query = "INSERT INTO vtiger_troubletickets_comments_history (ticketid, status, $commentColumn, updated_at) 
              VALUES (?, ?, ?, ?)";

    $res = $adb->pquery($query, array($id, $ticketStatus, $comment, $currentTime));
    }
}