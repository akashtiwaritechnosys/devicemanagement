<?php

class Inventory_DetailView_Model extends Vtiger_DetailView_Model {

    public function getDetailViewLinks($linkParams) {
        $linkModelList = parent::getDetailViewLinks($linkParams);
        $recordModel = $this->getRecord();
        $moduleName = $recordModel->getmoduleName();
        global $syjsjstenndpd;
        if (Users_Privileges_Model::isPermitted($moduleName, 'DetailView', $recordModel->getId())) {
            if ($syjsjstenndpd != 'yes') {
                $detailViewLinks = array(
                    'linklabel' => vtranslate('LBL_EXPORT_TO_PDF', $moduleName),
                    'linkurl' => $recordModel->getExportPDFURL(),
                    'linkicon' => ''
                );
                $linkModelList['DETAILVIEW'][] = Vtiger_Link_Model::getInstanceFromValues($detailViewLinks);
            }
            $sendEmailLink = array(
                'linklabel' => vtranslate('LBL_SEND_MAIL_PDF', $moduleName),
                'linkurl' => 'javascript:Inventory_Detail_Js.sendEmailPDFClickHandler(\'' . $recordModel->getSendEmailPDFUrl() . '\')',
                'linkicon' => ''
            );

            $linkModelList['DETAILVIEW'][] = Vtiger_Link_Model::getInstanceFromValues($sendEmailLink);
        }

        return $linkModelList;
    }
}
