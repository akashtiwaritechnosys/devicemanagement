<?php
include_once 'include/Webservices/DescribeObject.php';
include_once 'include/Webservices/Query.php';

class Mobile_WS_FetchReferenceRecords extends Mobile_WS_Controller {
    
    function process(Mobile_API_Request $request) {
        
        $response = new Mobile_API_Response();
        $current_user = $this->getActiveUser();
        
        // Fetch reference records request parameters
        $referenceModule = $request->get('module');
        $searchKey = $request->get('searchValue');
        
        if ($referenceModule == 'Documents') {
            $labelFields = 'notes_title';
        } else if ($referenceModule == 'HelpDesk') {
            $labelFields = 'ticket_title';
            // Handle Equipment module separately to avoid potential issue
        } else if ($referenceModule === 'Equipment') {
                // Use a hardcoded approach for Equipment
                $labelFields = 'equipment_serialno'; // Adjust this to match your actual label field
        } else {
            $describe = vtws_describe($referenceModule, $current_user);
            $labelFields = $describe['labelFields'];
        }
        
        $labelFieldsArray = explode(',', $labelFields);
        $sql = "";
        
        if ($referenceModule == 'Products') {
            // Include unit_price and serial_no in the SELECT query for Products
            $sql = sprintf(
                "SELECT %s FROM %s WHERE ",
                $labelFields . ',unit_price,serial_no',
                $referenceModule
            );

            // Ensure the search key applies to serial_no specifically
            if (!empty($searchKey)) {
                $sql .= "serial_no LIKE '%" . $searchKey . "%' OR ";
            }

            foreach ($labelFieldsArray as $labelField) {
                $sql .= $labelField . " LIKE '%" . $searchKey . "%' OR ";
            }

            // Ensure no trailing OR and the query is valid
            $sql = rtrim($sql, ' OR ') . ';';
        } else {
            // Handle other modules
            $sql = sprintf("SELECT %s FROM %s WHERE ", $labelFields, $referenceModule);
            
            foreach ($labelFieldsArray as $labelField) {
                $sql .= $labelField . " LIKE '%" . $searchKey . "%' OR ";
            }
            $sql = rtrim($sql, ' OR ') . ';';
        }

        // Log the SQL query for debugging
        error_log("Generated SQL: " . $sql);

        // Execute the query
        $wsresult = vtws_query($sql, $current_user);
        $referenceRecords = array();
        
        if ($referenceModule == 'Products') {
            foreach ($wsresult as $result) {
                $record = array();
                
                // Concatenate label fields to form the label
                foreach ($labelFieldsArray as $labelField) {
                    $record['label'] .= $result[$labelField] . ' ';
                }
                $record['label'] = trim($record['label']);
                $record['value'] = decode_html($result['id']);
                
                // Include unit_price and serial_no in the response
                $record['unit_price'] = (float) number_format((float)$result['unit_price'], 2, '.', '');
                $record['item_code'] = $result['serial_no'];
                
                $referenceRecords[] = $record;
            }
        } else {
            foreach ($wsresult as $result) {
                $record = array();
                foreach ($labelFieldsArray as $labelField) {
                    $record['label'] .= $result[$labelField] . ' ';
                }
                $record['label'] = trim($record['label']);
                $record['value'] = decode_html($result['id']);
                $referenceRecords[] = $record;
            }
        }

        // Prepare the response
        $res['referenceRecords'] = $referenceRecords;
        $response->setResult($res);
        $response->setApiSucessMessage('Successfully Fetched Data');
        return $response;
    }
}
