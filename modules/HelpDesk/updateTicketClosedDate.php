<?php
function updateTicketClosedDate($entityData) {
    global $adb;
    $recordInfo = $entityData->{'data'};

    $id = $recordInfo['id'];
    $id = explode('x', $id);
    $id = $id[1];

    global $default_timezone;
    $admin = Users::getActiveAdminUser();
    $adminTimeZone = $admin->time_zone;
    @date_default_timezone_set($adminTimeZone);
    $query = 'UPDATE vtiger_ticketcf SET cf_2796=?,cf_2798=? WHERE ticketid=?';
    $adb->pquery($query, array(date('Y-m-d'), date('h:i:s'), $id));
    @date_default_timezone_set($default_timezone);
}
