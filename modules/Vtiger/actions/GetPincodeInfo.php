<?php

class Vtiger_GetPincodeInfo_Action extends Vtiger_IndexAjax_View {
    public function requiresPermission(\Vtiger_Request $request) {
        return [];
    }
    public function process(Vtiger_Request $request) {
        // test
        $pincode = $request->get('pincode');
        $url = 'https://api.postalpincode.in/pincode/' . $pincode;
        $res = file_get_contents($url);
        $res = json_decode($res, true);
        $address = $res[0]['PostOffice'][0];
        $response = new Vtiger_Response();
        $response->setResult(array('success' => true, 'data' => $address ));
        $response->emit();
        // global $log, $pincodeDatabaseName, $pincodeDatabaseUser, $pincodeDatabaseNamePassword;
        // $connection = mysqli_connect("localhost", $pincodeDatabaseUser, $pincodeDatabaseNamePassword , $pincodeDatabaseName);
        // if (mysqli_connect_errno()) {
        //     echo "Database connection failed.";
        //     $log->debug("Database connection failed.");
        // }
        // $sql = "SELECT * FROM $pincodeDatabaseName.vtiger_pincodes" .
        //     " WHERE pincode = ?";
        //     $log->debug("Database connection failed.".$sql);
        // $stmt = $connection->prepare($sql);
        // $stmt->bind_param("s", $pincode);
        // $stmt->execute();
        // $result = $stmt->get_result();
        // $pincodes = [];
        // while ($pincode = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        //     array_push($pincodes, $pincode);
        // }
        // $response = new Vtiger_Response();
        // $response->setResult(array('success' => true, 'data' => $pincodes));
        // $response->emit();
    }
}
