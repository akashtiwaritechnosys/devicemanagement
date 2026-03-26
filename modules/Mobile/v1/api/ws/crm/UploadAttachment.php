<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

class Mobile_WS_UploadAttachment extends Mobile_WS_Controller {

    function process(Mobile_API_Request $request) {
        global $site_URL;
        $response = new Mobile_API_Response();
        $module = $request->get('module');

        if (empty($module)) {
            $response->setError(100, "Module Is Missing");
            return $response;
        }
        $recordId = $request->get('recordId');
        if ($module == "Users") {
            global $uploadingUserImageFormTheApi;
            $uploadingUserImageFormTheApi = true;
            $recordId = '19x' . $request->get('useruniqueid');
        }
        if (empty($recordId)) {
            $response->setError(100, "recordId Is Missing");
            return $response;
        }
        if (strpos($recordId, 'x') == false) {
            $response->setError(100, 'RecordId Is Not Webservice Format');
            return $response;
        }
        $recordId = explode('x', $recordId)[1];

        $fieldName = $request->get('fieldName');
        if (empty($fieldName)) {
            $response->setError(100, "fieldName Is Missing");
            return $response;
        }
        $file = $_FILES[$fieldName];
        if (empty($file)) {
            $response->setError(100, "Uploaded File Is Missing");
            return $response;
        }
        global $upload_maxsize;
        if ($file['size'] < $upload_maxsize) {
            $sourceFocus = CRMEntity::getInstance($module);
            $recordIdOfUploaded = $sourceFocus->uploadAndSaveFile($recordId, $module, $file, 'Attachment', $fieldName);

            if ($recordIdOfUploaded) {
                global $adb;
                $attachmentIdResult = $adb->pquery("SELECT crmid FROM vtiger_crmentity WHERE setype = 'Users Image' ORDER BY crmid DESC LIMIT 1");
                $attachmentId = $adb->query_result($attachmentIdResult, 0, 'crmid');
                $attachmentDetails = $adb->pquery("SELECT storedname, path FROM vtiger_attachments WHERE attachmentsid = ?", array($attachmentId));

                if ($adb->num_rows($attachmentDetails) > 0) {
                    $storedFileName = $adb->query_result($attachmentDetails, 0, 'storedname');
                    $attachmentPath = $adb->query_result($attachmentDetails, 0, 'path');
                } else {
                    $response->setError(100, "Attachment Not Found");
                    return $response;
                }
                $baseURL = $site_URL;
                $uploadedFileUrl = $baseURL . $attachmentPath . $attachmentId .'_'. $storedFileName;

                $ResponseObject = [
                    'uploadedAttachmentId' => $recordIdOfUploaded,
                    'fileUrl' => $uploadedFileUrl
                ];

                $response->setResult($ResponseObject);
                $response->setApiSucessMessage('Successfully Uploaded Attachment');
                return $response;
            }
        } else {
            $response->setError(100, "Filesize larger than $upload_maxsize bytes");
            return $response;
        }
    }
}
