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
        {assign var=TITLE value="{vtranslate('Received Messages', $MODULE)}"}
        {include file="ModalHeader.tpl"|vtemplate_path:$MODULE TITLE=$TITLE}

        <table class="table  listview-table ">
            <thead>
                <tr>
                    <th>Module Record No</th>
                    <th>Customer Name</th>
                    <th>Mobil No</th>
                    <th>Message</th>
                    <th>Date Time</th>
                </tr>
            </thead>
            
            <tbody>
                {foreach item=unreadMessages_value key=unreadMessages_key from=$unreadMessages}
                    <tr>
                        <td>{$unreadMessages_value['lead_no']}</td>
                        <td>{$unreadMessages_value['customername']}</td>
                        <td>{$unreadMessages_value['fromNumber']}</td>
                        <td>{$unreadMessages_value['messages']}</td>
                        <td>{$unreadMessages_value['createdAt']}</td>
                    </tr>
                {/foreach}
            </tbody>
            
        </table>    
     
    </div>
</div>
