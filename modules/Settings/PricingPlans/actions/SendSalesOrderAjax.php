<?php
class Settings_PricingPlans_SendSalesOrderAjax_Action extends Settings_Vtiger_Basic_Action
{
    public function process(Vtiger_Request $request)
    {
        GLOBAL $siteID;
        session_start();
        $input = json_decode(file_get_contents("php://input"), true);
        $planIdRaw = $_SESSION['selected_plan_id'] ?? null;
        $userCount = $_SESSION['selected_user_count'] ?? null;
        $productid = $_SESSION['selected_product_id'] ?? null;
        
        $planId = null;
        if ($planIdRaw && strpos($planIdRaw, 'x') !== false) {
            $parts = explode('x', $planIdRaw);
            $planId = $parts[1] ?? null;
        }
        

        $payload = [
            '_operation'    => 'CreateSalesOrder',
            'record'        => $siteID, // Replace with dynamic record if needed
            'pricebook_id'  => $planId,   // Replace with dynamic pricebook ID
            'productid'     => $productid,
            'street'        => $input['street'],
            'postal_code'   => $input['postal_code'],
            'country'       => $input['country'],
            'bill_phone'    => $input['phone'],
            'bill_state'    => $input['state'],
            'bill_city'     => $input['city'],
            'no_of_users'   => $userCount
        ];

    //    print_r($payload);

        $recordModel = new Vtiger_Record_Model();
		$headersSet = $recordModel->getCurlHeaders();
		$timestamp = $headersSet['timestamp'];
		$signature = $headersSet['signature'];

        $curl = curl_init('https://central.crm-doctor.com/staging/modules/Mobile/api.php');
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'X-Timestamp: ' . $timestamp,
                'X-Signature: ' . $signature,
                'Cookie: PHPSESSID=7bb8f0b681dca40aff1b' // Optional, only if needed
            ],
            CURLOPT_POSTFIELDS     => json_encode($payload),
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if ($error) {
            
            echo json_encode(['success' => false, 'message' => $error]);
        } else {
            $res = json_decode($response, true);
           
            echo json_encode([
                'success' => $res['success'] ?? false,
                'message' => $res
            ]);
        }
    }

    public function requiresPermission(Vtiger_Request $request)
    {
        return [];
    }
}
