{strip}
    {assign var="deleted" value="deleted"|cat:$row_no}
    {assign var="image" value="productImage"|cat:$row_no}
    {assign var="purchaseCost" value="purchaseCost"|cat:$row_no}
    {assign var="margin" value="margin"|cat:$row_no}
    {assign var="product_warehouse" value="product_warehouse"|cat:$row_no}
    {assign var="hdnProductId" value="hdnProductId"|cat:$row_no}
    {assign var="productName" value="productName"|cat:$row_no}
    {assign var="sectionName" value="sectionName"|cat:$row_no}
    {assign var="comment" value="comment"|cat:$row_no}
    {assign var="productDescription" value="productDescription"|cat:$row_no}
    {assign var="qtyInStock" value="qtyInStock"|cat:$row_no}
    {assign var="serialNumber" value="serialNumber"|cat:$row_no}
    {assign var="length" value="length"|cat:$row_no}
    {assign var="height" value="height"|cat:$row_no}
    {assign var="qty" value="qty"|cat:$row_no}
    {assign var="listPrice" value="listPrice"|cat:$row_no}
    {assign var="productTotal" value="productTotal"|cat:$row_no}
    {assign var="subproduct_ids" value="subproduct_ids"|cat:$row_no}
    {assign var="subprod_names" value="subprod_names"|cat:$row_no}
    {assign var="subprod_qty_list" value="subprod_qty_list"|cat:$row_no}
    {assign var="entityIdentifier" value="entityType"|cat:$row_no}
    {assign var="entityType" value=$data.$entityIdentifier}
    {assign var="discount_type" value="discount_type"|cat:$row_no}
    {assign var="discount_percent" value="discount_percent"|cat:$row_no}
    {assign var="checked_discount_percent" value="checked_discount_percent"|cat:$row_no}
    {assign var="style_discount_percent" value="style_discount_percent"|cat:$row_no}
    {assign var="discount_amount" value="discount_amount"|cat:$row_no}
    {assign var="checked_discount_amount" value="checked_discount_amount"|cat:$row_no}
    {assign var="style_discount_amount" value="style_discount_amount"|cat:$row_no}
    {assign var="checked_discount_zero" value="checked_discount_zero"|cat:$row_no}
    {assign var="discountTotal" value="discountTotal"|cat:$row_no}
    {assign var="totalAfterDiscount" value="totalAfterDiscount"|cat:$row_no}
    {assign var="taxTotal" value="taxTotal"|cat:$row_no}
    {assign var="netPrice" value="netPrice"|cat:$row_no}
    {assign var="FINAL" value=$RELATED_PRODUCTS.1.final_details}
    {assign var="productDeleted" value="productDeleted"|cat:$row_no}
    {assign var="productId" value=$data[$hdnProductId]}
    {assign var="listPriceValues" value=Products_Record_Model::getListPriceValues($productId)}
    {if $MODULE eq 'PurchaseOrder'}
        {assign var="listPriceValues" value=array()}
        {assign var="purchaseCost" value="{if $data.$purchaseCost}{((float)$data.$purchaseCost) / ((float)$data.$qty * {$RECORD_CURRENCY_RATE})}{else}0{/if}"}
        {foreach item=currency_details from=$CURRENCIES}
            {append var='listPriceValues' value=$currency_details.conversionrate * $purchaseCost index=$currency_details.currency_id}
        {/foreach}
    {/if}
    {foreach item=carid from=$carMeta}
        {assign var="dabbas" value='LINEITEM_CUSTOM_FIELDNAMES'|cat:'_'|cat:$carid}
        {foreach item=LINEITEM_CUSTOM_FIELDNAME from=${$dabbas}}
            {assign var={$LINEITEM_CUSTOM_FIELDNAME} value=$LINEITEM_CUSTOM_FIELDNAME|cat:$row_no}
        {/foreach}
    {/foreach}
    <td style="text-align:center;width:10px">
        <i class="fa fa-trash deleteRow cursorPointer" title="{vtranslate('LBL_DELETE',$MODULE)}"></i>
        &nbsp;<a><img src="{vimage_path('drag.png')}" border="0" title="{vtranslate('LBL_DRAG',$MODULE)}"/></a>
        <input type="hidden" class="rowNumber" value="{$row_no}" />
    </td>
   
    {assign var="dateFormat" value=$USER_MODEL->get('date_format')}
    {assign var="dingach" value='LINEITEM_CUSTOM_FIELDS'|cat:'_'|cat:$dady}
	{foreach key=LINEITEM_CUSTOM_FIELDKEY item=LINEITEM_CUSTOM_FIELD from=${$dingach}}
        {assign var="fieldwidth" value=$LINEITEM_CUSTOM_FIELD['fieldwidth']}
        {if $LINEITEM_CUSTOM_FIELD['fieldwidth']}
            <td style="width:{$fieldwidth}%">
        {else}
            <td>
        {/if}
			{assign var="fieldName" value=$LINEITEM_CUSTOM_FIELD['fieldname']}
			{if  $LINEITEM_CUSTOM_FIELD['uitype'] eq '5'}
				<div class="input-group inputElement" style="margin-bottom: 3px">
                <input  id="{${$fieldName}}" name="{${$fieldName}}" type="text" class="{if $row_no neq 0}dateField{/if} form-control" data-fieldname="{${$fieldName}}" data-fieldtype="date" data-date-format="{$dateFormat}"
						value="{Vtiger_Functions::currentUserDisplayDate($data.${$fieldName})}"
						{if !empty($SPECIAL_VALIDATOR)}data-validator='{Zend_Json::encode($SPECIAL_VALIDATOR)}'{/if}
						{if $LINEITEM_CUSTOM_FIELD["mandatory"] eq true} data-rule-required="true" {/if}
						{if count($LINEITEM_CUSTOM_FIELD['validator'])}
							data-specific-rules='{ZEND_JSON::encode($LINEITEM_CUSTOM_FIELD["validator"])}'
						{/if}  data-rule-date="true" />
					<span class="input-group-addon"><i data-fieldname="{${$fieldName}}" class="fa fa-calendar"></i></span>
				</div>
			{elseif $LINEITEM_CUSTOM_FIELD['uitype'] eq '21' or $LINEITEM_CUSTOM_FIELD['uitype'] eq '1000' or $LINEITEM_CUSTOM_FIELD['uitype'] eq '1' or $LINEITEM_CUSTOM_FIELD['uitype'] eq '2'}
				<div>
            <textarea {if $LINEITEM_CUSTOM_FIELD['islinereadonly'] eq '1'} readonly style="pointer-events: none;background-color:#eeeeee;width: 100%;"{/if}
                    {if $LINEITEM_CUSTOM_FIELD["mandatory"] eq true} data-rule-required = "true" {/if}
                     id="{${$fieldName}}" name="{${$fieldName}}" style="width: 100%;"
                     class="{$fieldName}">{decode_html($data.${$fieldName})}
                    </textarea>
                </div>
			{elseif $LINEITEM_CUSTOM_FIELD['uitype'] eq '7' }
				<div>
				    <input id="{${$fieldName}}" name="{${$fieldName}}" value="{decode_html($data.${$fieldName})}" class="qty inputElement {$fieldName}" style="min-width: 100px;" type="number" {if $LINEITEM_CUSTOM_FIELD["mandatory"] eq true} data-rule-required = "true" {/if}/>
				</div>
			{elseif $LINEITEM_CUSTOM_FIELD['uitype'] eq '16'}
				<div id="{$fieldName}DivCla" {if $LINEITEM_CUSTOM_FIELD['hideInitialDisplay'] eq 'true'} class="hide" {/if}>
					<select {if $LINEITEM_CUSTOM_FIELD["mandatory"] eq true} data-rule-required = "true" {/if} style="min-width: 150px;" id="{${$fieldName}}" class="select2-container {if $row_no neq 0}select2{/if} inputElement picklistfield" name="{${$fieldName}}" data-extraname="{$fieldName}" data-fieldtype="picklist">
						<option value="">{vtranslate('LBL_SELECT_OPTION','Vtiger')}</option>
						{foreach  key=PICKLIST_FIELDKEY item=PICKLIST_FIELD_ITEM from=$LINEITEM_CUSTOM_FIELD['picklistValues']}
							<option {if trim(decode_html($data.${$fieldName})) eq $PICKLIST_FIELDKEY} selected {/if} value="{$PICKLIST_FIELDKEY}">{$PICKLIST_FIELDKEY}</option>
						{/foreach}
					</select>
				</div>
			{elseif $LINEITEM_CUSTOM_FIELD['uitype'] eq '56'}
				<input class="inputElement" id="{${$fieldName}}" name="{${$fieldName}}" style="width:15px;height:15px;" data-fieldname="{${$fieldName}}" data-fieldtype="checkbox" type="checkbox"
				{if $data.${$fieldName} eq true} checked {/if}
				{if !empty($SPECIAL_VALIDATOR)}data-validator="{Zend_Json::encode($SPECIAL_VALIDATOR)}"{/if}
				{if $LINEITEM_CUSTOM_FIELD["mandatory"] eq true} data-rule-required = "true" {/if}
				{if count($LINEITEM_CUSTOM_FIELD['validator'])}
					data-specific-rules='{ZEND_JSON::encode($LINEITEM_CUSTOM_FIELD["validator"])}'
				{/if}/>
            {elseif $LINEITEM_CUSTOM_FIELD['uitype'] eq '999'}
                <div id="paymentContainer" style="margin : 0px;min-width: 100px" name="paymentContainer" class="paymentOptions">
                    {foreach item=PICKLIST_VALUE key=PICKLIST_NAME from=$LINEITEM_CUSTOM_FIELD['picklistValues']}
                        <div id="payCC" class="floatBlock">
                        <label> <input data-extraname="{$fieldName}" id="{${$fieldName}}"
                            data-rule-required="true" data-fieldname="{$fieldName}"
                            name="{${$fieldName}}"  type="radio"
                            value="{Vtiger_Util_Helper::toSafeHTML($PICKLIST_NAME)}"
                            {if trim(decode_html($data.${$fieldName})) eq $PICKLIST_NAME} checked="checked" {/if}>
                            &nbsp {$PICKLIST_VALUE}
                        </label>
                        </div>
                    {/foreach}
                </div>
			{elseif $LINEITEM_CUSTOM_FIELD['uitype'] eq '10'}
				<div id="{$fieldName}DivCla" {if $LINEITEM_CUSTOM_FIELD['hideInitialDisplay'] eq 'true'} class="hide" {/if}>	
					<div class="referencefield-wrapper">
						<input name="popupReferenceModule" type="hidden" value="Vendors"/>
						<div class="input-group">
							<input name="{${$fieldName}}" type="hidden" value="{if !empty($data.$line_vendor_id)}{$data.$line_vendor_id}{/if}" class="sourceField" data-displayvalue='' />
							<input id="{${$fieldName}}_display" name="{${$fieldName}}_display" data-fieldname="{${$fieldName}}" data-fieldtype="reference" type="text" 
								class="marginLeftZero autoComplete2 inputElement" 
								value="" 
								placeholder="Type to Search..."/>
							<a href="#" class="clearReferenceSelection {if $FIELD_VALUE eq 0}hide{/if}"> x </a>
								<span class="input-group-addon relatedPopup cursorPointer" title="{vtranslate('LBL_SELECT', $MODULE)}">
									<i id="{$MODULE}_editView_fieldName_{$FIELD_NAME}_select" class="fa fa-search"></i>
								</span>
							{if (($smarty.request.view eq 'Edit') or ($MODULE_NAME eq 'Webforms')) && !in_array($REFERENCE_LIST[0],$QUICKCREATE_RESTRICTED_MODULES)}
								<span class="input-group-addon createReferenceRecord cursorPointer clearfix" title="{vtranslate('LBL_CREATE', $MODULE)}">
								<i id="{$MODULE}_editView_fieldName_{$FIELD_NAME}_create" class="fa fa-plus"></i>
							</span>
							{/if}
						</div>
					</div>
				</div>
			{/if}
		</td>
	{/foreach}
{/strip}