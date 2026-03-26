<?php
class HelpDesk_StatusUpdate_Action extends Vtiger_IndexAjax_View {

    public function process(Vtiger_Request $request) {
        $record = $request->get('record');
        $status = $request->get('status');
        $module = $request->get('module');

        date_default_timezone_set("Asia/Kolkata");
        $currentDate = date("Y-m-d");
        $currentTime = date("H:i:s");

        global $adb;
        $sql = "update `vtiger_troubletickets` set `status` = ? where ticketid = ?";
        $result = $adb->pquery($sql, array($status, $record));
        if($status == 'Closed'){
            $sql = "update `vtiger_ticketcf` set `cf_2796` = ?, `cf_2798` = ?  where ticketid = ?";
            $result += $adb->pquery($sql, array($currentDate, $currentTime, $record));
        }
        $num_rows = $adb->getAffectedRowCount($result);
        $response = new Vtiger_Response();
        if ($num_rows > 0) {
            $success = true;
            $message = "Status updated successfully";
            $response->setResult(array(
                'success' => $success,
                'data' => $record,
                'message' => $message
            ));
        } else {
            $success = false;
            $message = "Not able to update status, Try again later!";
            $response->setResult(array(
                'error' => $success,
                'data' => $record,
                'message' => $message
            ));
        }
        $response->emit();
    }
}
