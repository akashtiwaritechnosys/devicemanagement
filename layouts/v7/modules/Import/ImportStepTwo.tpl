{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is:  vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*
********************************************************************************/
-->*}

<div class = "importBlockContainer hide" id="importStep2Conatiner">
    <div>
        <h5>{'LBL_DUPLICATE_RECORD_HANDLING'|@vtranslate:$MODULE}</h5>
    </div>
    <table class = "table table-borderless bg-light-color-2" id="duplicates_merge_configuration">
        <tr>
            <td>
                <p>{'LBL_SPECIFY_MERGE_TYPE'|@vtranslate:$MODULE}</p>
                <select name="merge_type" id="merge_type" class ="select select2 form-control" style="width:40%">
                    {foreach key=_MERGE_TYPE item=_MERGE_TYPE_LABEL from=$AUTO_MERGE_TYPES}
                        <option value="{$_MERGE_TYPE}">{$_MERGE_TYPE_LABEL|@vtranslate:$MODULE}</option>
                    {/foreach}
                </select>
            </td>
        </tr>
        <tr>
            <td><p>{'LBL_SELECT_MERGE_FIELDS'|@vtranslate:$MODULE}</p></td>
        </tr>
        <tr>
            <td>
                <table class="bg-light-color-2 table-borderless">
                    <tr>
                        <td><p>{'LBL_AVAILABLE_FIELDS'|@vtranslate:$MODULE}</p></td>
                        <td></td>
                        <td><p>{'LBL_SELECTED_FIELDS'|@vtranslate:$MODULE}</p></td>
                    </tr>
                    <tr>
                        <td>
                            <select class="available-fields" id="available_fields" multiple size="10" name="available_fields" class="txtBox" style="width: 100%; display:none;">
                                {foreach key=_FIELD_NAME item=_FIELD_INFO from=$AVAILABLE_FIELDS}
                                    {if $_FIELD_NAME eq 'tags'} {continue} {/if}
                                    <option value="{$_FIELD_NAME}">{$_FIELD_INFO->getFieldLabelKey()|@vtranslate:$FOR_MODULE}</option>
                                {/foreach}
                            </select>
                          <ul id="available_fields_list" class="custom-select-list"></ul>
                        </td>
                        <td width="8%">
                            <div align="center" class="selected-merge-btn">
                              

                                 <button id="move-right" class="btn btn-default btn-lg" onClick ="return Vtiger_Import_Js.copySelectedOptions('#available_fields', '#selected_merge_fields')"><span class="glyphicon glyphicon-arrow-right"></span></button>
                                <button id="move-left" class="btn btn-default btn-lg" onClick ="return Vtiger_Import_Js.removeSelectedOptions('#selected_merge_fields')"><span class="glyphicon glyphicon-arrow-left"></span></button>
                            </div>
                        </td>
                        <td>
                            <input type="hidden" id="merge_fields" size="10" name="merge_fields" value="" />
                            <select class="selected-merge-fields" id="selected_merge_fields" size="10" name="selected_merge_fields" multiple class="txtBox" style="width: 100%; display:none;">
                                {foreach key=_FIELD_NAME item=_FIELD_INFO from=$ENTITY_FIELDS}
                                    <option value="{$_FIELD_NAME}">{$_FIELD_INFO->getFieldLabelKey()|@vtranslate:$FOR_MODULE}</option>
                                {/foreach}
                            </select>
                          <ul id="selected_merge_fields_list" class="custom-select-list"></ul>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</div>




<script>
    $(document).ready(function () {
   // Build UL list from select
        function buildCustomList(selectId) {
            const $select = $('#' + selectId);
            const $ul = $('#' + selectId + '_list');
            $ul.empty();
            $select.find('option').each(function () {
                const $option = $(this);
                const $li = $('<li>')
                    .text($option.text())
                    .attr('data-value', $option.val());
                if ($option.prop('selected')) {
                    $li.addClass('selected');
                }

                $li.on('click', function () {
                    // Only allow single selection
                    $ul.find('li').removeClass('selected');
                    $(this).addClass('selected');
                    // Set only this option as selected in hidden select
                    $select.find('option').prop('selected', false);
                    $option.prop('selected', true);
                });
                $ul.append($li);
            });
        }

        // Build lists initially
        buildCustomList('available_fields');
        buildCustomList('selected_merge_fields');
        // Copy selected item from left to right (keep on left)
        $('#move-right').on('click', function (e) {
            e.preventDefault();
            const $fromSelect = $('#available_fields');
            const $toSelect = $('#selected_merge_fields');

            // Find selected option in left select
            const $selectedOption = $fromSelect.find('option:selected');
            if ($selectedOption.length) {
                // Check if item already exists in right select
                if ($toSelect.find('option[value="' + $selectedOption.val() + '"]').length === 0) {
                    // Clone and append to right select
                    const $newOption = $selectedOption.clone().prop('selected', false);
                    $toSelect.append($newOption);
                }
            }

            // Rebuild right list only
            buildCustomList('selected_merge_fields');
            // Also clear selection in left list
            $fromSelect.find('option').prop('selected', false);
            buildCustomList('available_fields');
        });
        // Move selected item from right to left (and remove from right)
        $('#move-left').on('click', function (e) {
            e.preventDefault();
            const $fromSelect = $('#selected_merge_fields');
            const $toSelect = $('#available_fields');
            // Find selected option in right select
            const $selectedOption = $fromSelect.find('option:selected');
            if ($selectedOption.length) {
                // Remove from right select
                $selectedOption.remove();
                // Ensure option exists in left select (but keep only one)
                if ($toSelect.find('option[value="' + $selectedOption.val() + '"]').length === 0) {
                    const $newOption = $selectedOption.clone().prop('selected', false);
                    $toSelect.append($newOption);
                }
            }
            // Rebuild both lists
            buildCustomList('selected_merge_fields');
            buildCustomList('available_fields');
        });

    });
</script>