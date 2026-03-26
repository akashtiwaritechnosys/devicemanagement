{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{strip}
    <div class="modal-dialog modelContainer">
        {include file="ModalHeader.tpl"|vtemplate_path:$MODULE TITLE="{vtranslate('Enter Reason')}"}
        <div class="modal-content">
            <form id="AddComment" name="AddComment">
                <input type="hidden" name="module" value="{$MODULE}"/>
                <input type="hidden" name="source_module" value="{$MODULE}"/>
                <input type="hidden" name="action" value="ApproveOrReject"/>
                <input type="hidden" name="apStatus" value="Reopen"/> 
                <input type="hidden" name="record" value="{$RECORD_ID}"/>
                <div class="modal-body clearfix">
                    <div class="col-lg-5">
                        <label class="control-label pull-right marginTop5px">
                            {vtranslate('Rejection Reason',$MODULE)}&nbsp;<span class="redColor">*</span>
                        </label>
                    </div>
                    <div class="col-lg-6">
                        <textarea type="text" id="m_comment" name="m_comment" data-rule-required="true" class="inputElement"></textarea>
                    </div>
                </div>
                {include file="ModalFooter.tpl"|vtemplate_path:$MODULE}
            </form>
        </div>
    </div>
{/strip}

