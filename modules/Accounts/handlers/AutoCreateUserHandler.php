<?php

class Accounts_AutoCreateUserHandler
{
    public function handleEvent($eventName, $entityData)
    {
        if ($eventName == 'vtiger.entity.aftersave.final') {
            $moduleName = $entityData->getModuleName();

            if ($moduleName == 'Accounts' && $entityData->isNew()) { // ← Only on create
                global $adb;

                $accountId = $entityData->getId();
                $accountName = $entityData->get('accountname');
                $email = $entityData->get('email1');
                $phone = $entityData->get('phone');
                $assignedUser = $entityData->get('assigned_user_id');
                $bill_street = $entityData->get('bill_street');
                $bill_city = $entityData->get('bill_city');
                $bill_state = $entityData->get('bill_state');
                $bill_code = $entityData->get('bill_code');
                $bill_country = $entityData->get('bill_country');

                if (!empty($email)) {
                    $checkEmail = $adb->pquery(
                        "SELECT id FROM vtiger_users WHERE email1 = ?",
                        [$email]
                    );

                    if ($adb->num_rows($checkEmail) > 0) {
                        // Delete the newly created account since email already exists
                        $adb->pquery("UPDATE vtiger_crmentity SET deleted = 1 WHERE crmid = ?", [$accountId]);
                        throw new Exception("Email ID '$email' is already registered as a User. Account creation has been rolled back.");
                    }

                    require_once('modules/Users/Users.php');
                    $focus = new Users();
                    $focus->column_fields['user_name'] = $email;
                    $focus->column_fields['last_name'] = $accountName;
                    $focus->column_fields['email1'] = $email;
                    $focus->column_fields['phone_mobile'] = $phone;
                    $focus->column_fields['status'] = 'Active';
                    $focus->column_fields['is_admin'] = 'off';
                    $focus->column_fields['user_password'] = 'Test@123';
                    $focus->column_fields['confirm_password'] = 'Test@123';
                    $focus->column_fields['roleid'] = 'H378'; // Assign your role ID
                    $focus->column_fields['address_street'] = $bill_street;
                    $focus->column_fields['address_country'] = $bill_country;
                    $focus->column_fields['address_city'] = $bill_city;
                    $focus->column_fields['address_postalcode'] = $bill_code;
                    $focus->column_fields['address_state'] = $bill_state;
                    $focus->save('Users');
                }
            }
        }
    }
}
