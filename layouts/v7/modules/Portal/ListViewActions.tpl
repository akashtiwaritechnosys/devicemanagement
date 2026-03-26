{*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************}
{* modules/Portal/views/List.php *}

{* START YOUR IMPLEMENTATION FROM BELOW. Use {debug} for information *}



{strip}
    <div class="listview-actions-container" id="listview-actions">
        <div class="row">
                <div class="btn-group col-md-4 listViewActionsContainer" role="group" araia-label="Portal actions">
                    <button type="button" class="btn btn-default" id="{$MODULE}_listview_massAction" onclick="Portal_List_Js.massDeleteRecords()" disabled="disabled">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
                <div class="col-md-4">
                    <div class="hide messageContainer">
                        <center><a href="#" id="selectAllMsgDiv">{vtranslate('LBL_SELECT_ALL',$MODULE)}&nbsp;{vtranslate($MODULE ,$MODULE)}&nbsp;(<span id="totalRecordsCount" value=""></span>)</a></center>
                    </div>
                    <div class="hide messageContainer">
                        <center><a href="#" id="deSelectAllMsgDiv">{vtranslate('LBL_DESELECT_ALL_RECORDS',$MODULE)}</a></center>
                    </div>            
                </div>
                <div class="col-md-4 padding-right-zero">
                    {* {assign var=RECORD_COUNT value=$LISTVIEW_ENTRIES_COUNT}*}
                    {include file="Pagination.tpl"|vtemplate_path:$MODULE SHOWPAGEJUMP=true}
                </div>
        </div>
    </div>            
{/strip}            