<?php
class Settings_PricingPlans_List_View extends Settings_Vtiger_Index_View
{

    public function process(Vtiger_Request $request)
    {
        $viewer = $this->getViewer($request);
        $viewer->assign("MODULE_NAME", "PricingPlans");
       
        $apiResponse = Vtiger_Module_Model::getsitedetails();
        $decoded = json_decode($apiResponse, true);
            if (isset($decoded['result'])) {
                $daysRemaining = null;
              
                if (!empty($decoded['result']['cf_879'])) {
                    $expiryDate = DateTime::createFromFormat('Y-m-d', $decoded['result']['cf_879']);
                    $startdate = DateTime::createFromFormat('Y-m-d', $decoded['result']['cf_877']);
                    $today = new DateTime();
                    if ($expiryDate) {
                        $interval = $today->diff($expiryDate);
                        $daysRemaining = (int)$interval->format('%r%a');
                    } else {
                        $daysRemaining = null;
                    }

                    if($startdate && $expiryDate){
						$interval2 = $startdate->diff($expiryDate);
						$daysDiff = (int)$interval2->format('%r%a');
					}else{
						$daysDiff = null;
					}
                }
                $viewer->assign("API_RECORD", $decoded['result']);
            }


        $plans = Vtiger_Module_Model::GetSitePricings();
              
        $plans = json_decode($plans, true);
        $viewer->assign("PLANS", $plans['result']['subscriptions']);
        
       
        
             
        // --- API CALL END ---

        $viewer->view("List.tpl", "Settings:PricingPlans");
    }
}
