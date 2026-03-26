{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is:  vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{strip}
    <div id="templateContainer" class="fc-overlay-modal modal-content" style="max-height: 550px;">
        <div class="overlayHeader">
            <div class="modal-header">

                <div class="row">
                 {assign var="TEMPLATE_NAME" value="{$RECORD_MODEL->get('templatename')}"}
                    {assign var="TEMPLATE_ID" value="{$RECORD_MODEL->get('templateid')}"}
                    <div class="clearfix col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="">
                            <h4>{$TEMPLATE_NAME}</h4>
                        </div>
                    </div>
                    <div class="clearfix col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="pull-right " >
                            <button type="button" class="close" aria-label="Close" data-dismiss="modal">
                                <span aria-hidden="true" class='fa fa-close'></span>
                            </button>
                        </div>
                    </div>
                   
                </div>
                
            </div>
        </div>
        <div class='modal-body'>
            <div class='datacontent container-fluid ' id='previewTemplateContainer'>
                <iframe id="TemplateIFrame" class='overflowScrollBlock' style="height:330px;width: 100%;overflow-y: auto">         
                </iframe>
            </div>
        </div> 
    </div>
{/strip}
