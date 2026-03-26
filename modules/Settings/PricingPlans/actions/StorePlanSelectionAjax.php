<?php

class Settings_PricingPlans_StorePlanSelectionAjax_Action extends Settings_Vtiger_Basic_Action {
    public function process(Vtiger_Request $request) {
        session_start();

        $planId   = $request->get('plan_id');
        $product  = $request->get('product');
        $userCount = (int) $request->get('user_count');

        $_SESSION['selected_plan_id'] = $planId;
        $_SESSION['selected_product_id'] = $product;
        $_SESSION['selected_user_count'] = $userCount;

        echo json_encode([
            'success' => true,
            'plan' => $planId,
            'product' => $product
        ]);
    }

    public function requiresPermission(Vtiger_Request $request) {
        return [];
    }
}
