<?php
include_once 'include/Webservices/DescribeObject.php';
 
class Mobile_WS_getRoleBaseAssignedPicklist extends Mobile_WS_Controller {
 
    function process(Mobile_API_Request $request) {
        global $current_user, $adb;
 
        $roleId = $current_user->roleid;
 
        $roleQuery = "SELECT rolename FROM vtiger_role WHERE roleid = ?";
        $roleResult = $adb->pquery($roleQuery, array($roleId));
 
        if ($adb->num_rows($roleResult) > 0) {
            $roleName = $adb->query_result($roleResult, 0, 'rolename');
        } else {
            $response = new Mobile_API_Response();
            $response->setError(100, "Role not found for Role ID: $roleId");
            return $response;
        }
 
        $response = new Mobile_API_Response();
        $field = $request->get('field');
 
        if (empty($field)) {
            $response->setError(100, 'Field Name Is Missing');
            return $response;
        }
 
        $pickList = [];
        $responseFieldName = $field;
 
        $picklistId = $this->getPicklistIdByFieldName($field);
 
        if ($picklistId !== null) {
            $pickList = $this->getRoleBasedPicklistValues($roleId, $picklistId, $field);
        } else {
            $response->setError(100, "Picklist ID not found for field: $field");
            return $response;
        }
 
        $fieldListPicklist[$responseFieldName] = $pickList;
        $response->setApiSucessMessage('Successfully Fetched Data');
        $response->setResult($fieldListPicklist);
        return $response;
    }
 
    function getPicklistIdByFieldName($fieldName) {
        global $adb;
        $sql = "SELECT picklistid FROM vtiger_picklist WHERE name = ?";
        $result = $adb->pquery($sql, array($fieldName));
 
        if ($adb->num_rows($result) > 0) {
            return $adb->query_result($result, 0, 'picklistid');
        }
        return null;
    }
 
    function getRoleBasedPicklistValues($roleId, $picklistId, $field) {
        global $adb;
        $pickList = [];
 
        $sql = "SELECT
                    r2p.roleid,
                    r2p.picklistvalueid,
                    r2p.picklistid,
                    r2p.sortid
                FROM
                    vtiger_role2picklist r2p
                WHERE
                    r2p.roleid = ?
                AND
                    r2p.picklistid = ?";
        $result = $adb->pquery($sql, array($roleId, $picklistId));
 
        if ($adb->num_rows($result) > 0) {
            while ($row = $adb->fetch_array($result)) {
                $picklistValueSql = "SELECT $field FROM vtiger_$field WHERE picklist_valueid = ?";
                $picklistValueResult = $adb->pquery($picklistValueSql, array($row['picklistvalueid']));
 
                if ($adb->num_rows($picklistValueResult) > 0) {
                    $picklistValueName = $adb->query_result($picklistValueResult, 0, $field);
                } else {
                    $picklistValueName = null;
                }
 
                array_push($pickList, array(
                    $field => decode_html($picklistValueName),
                ));
            }
        }
 
        return $pickList;
    }
}
?>