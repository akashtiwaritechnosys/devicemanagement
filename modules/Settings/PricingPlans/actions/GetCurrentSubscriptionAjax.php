<?php

class Settings_PricingPlans_GetCurrentSubscriptionAjax_Action extends Settings_Vtiger_Basic_Action
{
    public function process(Vtiger_Request $request)
    {
        GLOBAL $siteID;

        try {
            $payload = [
                '_operation' => 'GetCurrentSubscription',
                'site_id' => $siteID
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

            $response = curl_exec($curl);
            $error = curl_error($curl);
            curl_close($curl);

            if ($error) {
                throw new Exception($error);
            }

            $res = json_decode($response, true);
            echo json_encode([
                'success' => $res['success'] ?? false,
                'subscription' => $res['subscription'] ?? null,
                'available_plans' => $res['available_plans'] ?? []
            ]);

        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function requiresPermission(Vtiger_Request $request) { return []; }
}