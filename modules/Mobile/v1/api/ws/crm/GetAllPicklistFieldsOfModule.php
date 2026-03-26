<?php
include_once 'include/Webservices/DescribeObject.php';
class Mobile_WS_GetAllPicklistFieldsOfModule extends Mobile_WS_Controller {

    function process(Mobile_API_Request $request) {
        $current_user = CRMEntity::getInstance('Users');
        $current_user->id = $current_user->getActiveAdminId();
        $current_user->retrieve_entity_info($current_user->id, 'Users');
        $response = new Mobile_API_Response();

        if ($current_user) {
            $module = $request->get('module');
            if (empty($module)) {
                $response->setError(1501, "Module Is Not Specified.");
                return $response;
            }
            $describeInfo = vtws_describe($module, $current_user);
            $fieldListOnlyPicklist = [];
            global $current_user;
		    $currentUserRole = $current_user->roleid;
           foreach ($describeInfo['fields'] as $key => $value) {
                if (($value['name'] != 'assigned_user_id')) {
                    $value['default'] = decode_html($value['default']);

                    $fieldAlias = $value['name'];
                    if ($module == 'HelpDesk' && $value['name'] == 'cf_3038') {
                        $fieldAlias = 'ticket_type';
                    }

                    if ($value['type']['name'] === 'picklist') {
                        $pickList = $value['type']['picklistValues'];
                        $newValueHolder = [];
                        foreach ($pickList as $pickListKey => $pickListValue) {
                            if ($value['name'] == 'ticketstatus') {
                                $accesible = $this->isPicklistAccessible($currentUserRole, $pickListValue['value'], $value['name']);
                                if ($accesible == true) {
                                    $newValueHolder[] = array($fieldAlias => decode_html($pickListValue['value']));
                                }
                            } else {
                                $pickList[$pickListKey] = array($fieldAlias => decode_html($pickListValue['value']));
                            }
                        }
                        $fieldListOnlyPicklist[$fieldAlias] = $pickList;
                        if ($value['name'] == 'ticketstatus') {
                            $fieldListOnlyPicklist[$fieldAlias] = $newValueHolder;
                        }
                    } else if ($value['type']['name'] === 'multipicklist' || $value['type']['name'] === 'radio') {
                        $picklistvaluesmap = getAllPickListValues($value['name']);
                        $pickList = [];
                        foreach ($picklistvaluesmap as $targetValue) {
                            array_push($pickList, array($fieldAlias => decode_html($targetValue)));
                        }
                        $fieldListOnlyPicklist[$fieldAlias] = $pickList;
                    }
                }
            }
            $response->setApiSucessMessage('Successfully Fetched Data');
            $response->setResult($fieldListOnlyPicklist);
            return $response;
        }
    }

    function isPicklistAccessible($roleid, $ticketstatus, $fieldName) {
        global $adb;
        $sql = "SELECT picklistvalueid FROM `vtiger_role2picklist` 
            INNER JOIN vtiger_$fieldName
            ON vtiger_role2picklist.picklistvalueid = vtiger_$fieldName.picklist_valueid 
            where roleid=? and vtiger_$fieldName.$fieldName=?";
        $result = $adb->pquery($sql, array($roleid, $ticketstatus));
        $num_rows = $adb->num_rows($result);
        if ($num_rows == 0) {
            return false;
        } else {
            return true;
        }
    }
}
