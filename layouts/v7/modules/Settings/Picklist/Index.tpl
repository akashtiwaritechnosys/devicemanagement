{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{* modules/Settings/Picklist/views/Index.php *}

{* START YOUR IMPLEMENTATION FROM BELOW. Use {debug} for information *}
<div class="listViewPageDiv detailViewContainer" id="listViewContent">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-horizontal">
        <div class="ViewInfo-picklist">
            <div class="row">
                <div class="col-sm-6 paddingLeft5px">
                    <div class="detailViewInfo">
                        <div class="form-group">
                            <div class="col-lg-12 col-md-12 col-sm-12 control-label fieldLabel padding0px">
                                <label class="fieldLabel ">{vtranslate('LBL_SELECT_MODULE',$QUALIFIED_MODULE)} </label>
                            </div>
                            <div class="fieldValue col-sm-12 col-xs-12 padding0px">
                                <select class="select2 inputElement" id="pickListModules" name="pickListModules">
                                    <option value="">{vtranslate('LBL_SELECT_OPTION',$QUALIFIED_MODULE)}</option>
                                    {foreach item=PICKLIST_MODULE from=$PICKLIST_MODULES}
                                        <option {if $SELECTED_MODULE_NAME eq $PICKLIST_MODULE->get('name')} selected="" {/if} value="{$PICKLIST_MODULE->get('name')}">{vtranslate($PICKLIST_MODULE->get('name'),$PICKLIST_MODULE->get('name'))}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6" style="text-align: center;">
                    <div id="modulePickListContainer">
                        {include file="ModulePickListDetail.tpl"|@vtemplate_path:$QUALIFIED_MODULE}
                    </div>
                </div>
            </div>
        </div>
     
        <div id="modulePickListValuesContainer">
            {if empty($NO_PICKLIST_FIELDS)}
                {include file="PickListValueDetail.tpl"|@vtemplate_path:$QUALIFIED_MODULE}
            {/if}
        </div>

    </div>
</div>