<?php
class Settings_PricingPlans_CalculateUpgradeAjax_Action extends Settings_Vtiger_Basic_Action
{
    public function process(Vtiger_Request $request)
    {
        GLOBAL $siteID;
        session_start();

        $input = json_decode(file_get_contents("php://input"), true);
        // FIXED: Get from request instead of JSON input
        $newPricebookId = $request->get('new_pricebook_id');
        $newUserCount = $request->get('new_user_count');

        // Store in session for later use
        $_SESSION['upgrade_pricebook_id'] = $newPricebookId;
        $_SESSION['upgrade_user_count'] = $newUserCount;

        $priceBookId = null;
        if ($newPricebookId && strpos($newPricebookId, 'x') !== false) {
            $parts = explode('x', $newPricebookId);
            $priceBookId = $parts[1] ?? null;
        }
        // echo json_encode([
        //     'success' => true,
        //     'site_id' => $siteID,
        //     'pricebookid' => $newPricebookId,
        //     'usercount' => $newUserCount
        // ]);

        try {
            $payload = [
                '_operation' => 'CalculateUpgrade', // FIXED: Match your API class name
                'site_id' => $siteID,
                'new_pricebook_id' => $priceBookId ,
                'new_user_count' => $newUserCount
            ];

            $recordModel = new Vtiger_Record_Model();
            $headersSet = $recordModel->getCurlHeaders();
            $timestamp = $headersSet['timestamp'];
            $signature = $headersSet['signature'];

            $curl = curl_init('https://central.crm-doctor.com/staging/modules/Mobile/api.php');
            curl_setopt_array($curl, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'X-Timestamp: ' . $timestamp,
                    'X-Signature: ' . $signature
                ],
                CURLOPT_POSTFIELDS => json_encode($payload),
            ]);
            echo json_encode([$payload]);

            $response = curl_exec($curl);
            $error = curl_error($curl);
            curl_close($curl);

            if ($error) {
                throw new Exception($error);
            }

            $res = json_decode($response, true);
            echo json_encode([
                'success' => $res['result']['success'] ?? false,
                'calculation' => $res['result']['calculation'] ?? null,
                'debug' => $res // optional, for frontend inspection
            ]);

        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

}