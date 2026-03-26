{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
********************************************************************************/
-->*}
{strip}
    <div class="editViewContainer" id="TermsAndConditionsContainer">
        <div class="col-sm-12 col-lg-12 col-md-12 form-horizontal">
            <div class="block">
                <div class="term-conditions">
                    <h4>{vtranslate('LBL_TERMS_AND_CONDITIONS', $QUALIFIED_MODULE)}</h4>
                </div>
                <hr>
                <div class="contents row form-group">
                    <div class="col-lg-2 col-md-3 col-sm-3 control-label fieldLabel"><label>{vtranslate('LBL_SELECT_MODULE', 'Vtiger')}</label></div>
                    <div class="fieldValue col-lg-6 col-md-7 col-sm-7">
                        <select class="select2-container select2 inputElement col-sm-6 selectModule">
                            {foreach item=MODULE_NAME from=$INVENTORY_MODULES}
                                <option value={$MODULE_NAME}>{vtranslate({$MODULE_NAME}, {$MODULE_NAME})}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <br> 
                <div class="col-lg-11 col-md-11 col-sm-11">
                    <textarea class=" TCContent form-control termcondition-textarea" rows="10" placeholder="{vtranslate('LBL_SPECIFY_TERMS_AND_CONDITIONS', $QUALIFIED_MODULE)}" style="width:100%;" >{$CONDITION_TEXT}</textarea>
                </div>
                <div class='clearfix'></div>
                <br>
            </div>
        </div><br>
        <div class='modal-overlay-footer clearfix '>
            <div class="row clearfix">
                <div class='textAlignCenter col-lg-12 col-md-12 col-sm-12 '>
                    <button type='submit' class='btn btn-submit saveButton saveTC hide' type="submit" >{vtranslate('LBL_SAVE', $MODULE)}</button>&nbsp;&nbsp;
                </div>
            </div>
        </div>

    </div>
{/strip}

