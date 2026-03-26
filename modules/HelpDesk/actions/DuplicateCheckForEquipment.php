<?php

class HelpDesk_DuplicateCheckForEquipment_Action extends Vtiger_IndexAjax_View {
    public function process(Vtiger_Request $request) {
        $response = new Vtiger_Response();
        global $adb;

        $equipmentId = trim($request->get('equipment_id'));
        $modelNumber = trim($request->get('model_number'));
        $ticketStatus = trim($request->get('ticket_status'));
        $recordid = trim($request->get('recordid')); 
        $ticketId = trim($request->get('ticket_id'));
        $ticketType = trim($request->get('ticket_type'));

        if (empty($equipmentId) || empty($modelNumber) || empty($ticketType)) {
            $response->setError('Equipment ID, Model Number, and Cause of Type are required.');
            $response->emit();
            return;
        }

        // Always allow Preventive Maintenance Service tickets
        if ($ticketType === "PREVENTIVE MAINTENANCE SERVICE") {
            $response->setResult(['success' => true]);
            $response->emit();
            return;
        }

        // Skip validation for certain ticket statuses
        if (in_array($ticketStatus, ['Closed', 'In Progress', 'On Hold', 'Resolved', 'Spare Part By Head', 'Spare Part'])) {
            $response->setResult(['success' => true]);
            $response->emit();
            return;
        }

        // Skip validation when updating an existing ticket
        if (!empty($recordid)) {
            $response->setResult(['success' => true]);
            $response->emit();
            return;
        }

        // Check if an open ticket exists for the same Equipment ID and Model Number
        $query = "SELECT ticketid, ticket_type FROM vtiger_troubletickets 
                  INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_troubletickets.ticketid 
                  WHERE vtiger_crmentity.deleted = 0 
                  AND ticket_type != 'PREVENTIVE MAINTENANCE SERVICE'
                  AND vtiger_troubletickets.equipment_id = ? 
                  AND vtiger_troubletickets.model_number = ? 
                  AND vtiger_troubletickets.status != 'Closed'";

        $result = $adb->pquery($query, [$equipmentId, $modelNumber]);
        $existingTickets = [];

        while ($row = $adb->fetch_array($result)) {
            $existingTickets[] = [
                'ticketid' => $row['ticketid'],
                'ticket_type' => $row['ticket_type']
            ];
        }

        if (!empty($existingTickets)) {
            $response->setError('A ticket for this equipment is already open. Please close the existing ticket before creating a new one. Only Preventive Maintenance tickets are allowed to be created.');
            $response->emit();
            return;
        }

        // If no open tickets exist, allow ticket creation
        $response->setResult(['success' => true]);
        $response->emit();
    }
}