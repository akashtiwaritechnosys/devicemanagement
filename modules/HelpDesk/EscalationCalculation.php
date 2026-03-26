<?php
function EscalationCalculation($entityData) {
    global $default_timezone;
    $admin = Users::getActiveAdminUser();
    $adminTimeZone = $admin->time_zone;
    @date_default_timezone_set($adminTimeZone);

    global $adb;
    $query = "SELECT
                tt.ticketid,
                tt.status,
                tt.ticket_type,
                ce.createdtime,
                sla_in_hours
            FROM
                vtiger_troubletickets AS tt
            INNER JOIN
                vtiger_crmentity AS ce ON tt.ticketid = ce.crmid
            LEFT JOIN
                vtiger_servicelevelagreement AS se ON tt.ticket_type = se.ticket_type
            WHERE
                tt.status NOT IN ('Closed') and ce.deleted = 0";
    $result = $adb->pquery($query, array());

    if ($adb->num_rows($result) > 0) {
        while ($row = $adb->fetch_array($result)) {
            $ticketID = $row['ticketid'];
            $createdTime = $row['createdtime'];
            $escalationHours = $row['sla_in_hours'];

            $createdTime = date('Y-m-d H:i:s', strtotime($createdTime . ' +5 hours +30 minutes'));

            if (empty($escalationHours)) {
                $escalationHours = 8;
            }

            $expectedCloseWithin = new DateTime("$createdTime +$escalationHours hours");
            $currentTime = new DateTime();
            $timeDifference = $currentTime->diff($expectedCloseWithin);

            if ($expectedCloseWithin > $currentTime) {
                $isWithinEscalation = "No";
            } else {
                $isWithinEscalation = "Yes";
            }

            $updateQuery = "UPDATE vtiger_troubletickets
            SET is_escalated = '$isWithinEscalation'
            WHERE ticketid = '$ticketID'";
            $adb->pquery($updateQuery, array());
        }
    }

    @date_default_timezone_set($default_timezone);
}
