<?php
/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Settings_PricingPlans_ProcessUpgradeAjax_Action extends Settings_Vtiger_Basic_Action {

    public function __construct() {
        parent::__construct();
        $this->exposeMethod('process');
    }

    public function process(Vtiger_Request $request) {
        global $site_URL, $siteID, $api_key,$log;

        try {
            $currentUser = Users_Record_Model::getCurrentUserModel();
            $billingDetails = $request->get('billingDetails');
            $upgradeCalculation = $request->get('upgradeCalculation');

            // 🔹 Allow new_pricebook_id either from request or from session
            $PricebookId = $request->get('new_pricebook_id') ?? ($_SESSION['upgrade_pricebook_id'] ?? null);
            if (!$PricebookId) {
                throw new Exception('Upgrade session expired or missing. Please start again.');
            }
            $newPricebookId = null;
            if ($PricebookId && strpos($PricebookId, 'x') !== false) {
                $parts = explode('x', $PricebookId);
                $newPricebookId = $parts[1] ?? null;
            }

            if (!$siteID) {
                throw new Exception('Site ID not found in session.');
            }

            // 🔹 Log incoming request for debugging
            $log->debug("DEBUG ProcessUpgradeAjax - SiteID: $siteID");
            $log->debug("DEBUG Billing Details: " . print_r($billingDetails, true));
            $log->debug("DEBUG Upgrade Calculation: " . print_r($upgradeCalculation, true));

            // Prepare payload
            $payload = [
                '_operation' => 'ProcessSubscriptionUpgrade',
                'site_id'            => $siteID,
                'upgrade_calculation' => $upgradeCalculation,
                'billing_details'    => $billingDetails,
                'new_pricebook_id'   => $newPricebookId,
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
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $error = curl_error($curl);
            curl_close($curl);

            // Debug log
            $log->debug("HTTP Code: " . $httpCode);
            $log->debug("API Response: " . $response);

            if ($error) {
                throw new Exception("CURL Error: " . $error);
            }

            if ($httpCode !== 200) {
                throw new Exception("HTTP Error: " . $httpCode);
            }

            $res = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("JSON Decode Error: " . json_last_error_msg());
            }

            if (!$res || (isset($res['success']) && !$res['success'])) {
                throw new Exception($res['message'] ?? ($res['error']['message'] ?? 'Unknown error occurred'));
            }

            echo json_encode([
                'success' => $res['success'] ?? false,
                'message' => $res['message'] ?? 'Subscription upgraded successfully',
                'subscription_id' => $res['subscription_id'] ?? null,
                'data' => $res
            ]);

        } catch (Exception $e) {
            $log->debug("Upgrade processing error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage(),
                'subscription_id' => null
            ]);
        }
    }
}
