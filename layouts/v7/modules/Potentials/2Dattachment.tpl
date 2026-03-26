{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{* modules/Vtiger/views/MassActionAjax.php *}

<div id="2Dattachment" class='modal-xs modal-dialog'>
    <div class = "modal-content">
        {assign var=TITLE value="{vtranslate('2D Design Attachment', $MODULE)}"}
        {include file="ModalHeader.tpl"|vtemplate_path:$MODULE TITLE=$TITLE}

        <form class="form-horizontal" id="massSave" method="post" action="index.php" enctype="multipart/form-data">
            <input type="hidden" name="module" value="Potentials" />
            <input type="hidden" name="view" value="DesignAttachment" />
            <input type="hidden" name="mode" value="save2DDesignAttachment" />
            <input type="hidden" name="recordId" value="{$recordId}" />
            
            <div class="modal-body">
                <div>
                    <span><strong>{vtranslate('Select 2D Design Attachment',$MODULE)}</strong></span>
                    &nbsp;:&nbsp;<br><br>
                    <div>
                        <input type="file" name="2DDesign" id="2DDesign">
                    </div>
                </div>
            </div>
            <div>
                <div class="modal-footer">
                    <center>
                        <button class="btn btn-success" type="save2DDesign"><strong>{vtranslate('LBL_SAVE', $MODULE)}</strong></button>
                        <a class="cancelLink" type="reset" data-dismiss="modal">{vtranslate('LBL_CANCEL', $MODULE)}</a>
                    </center>
                </div>
            </div>
        </form>
    </div>
</div>
