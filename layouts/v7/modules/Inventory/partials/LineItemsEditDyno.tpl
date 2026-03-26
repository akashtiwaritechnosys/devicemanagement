{strip}
	{assign var=LINEITEM_FIELDS value=$RECORD_STRUCTURE['LBL_ITEM_DETAILS']}
	{if $LINEITEM_FIELDS['image']}
		{assign var=IMAGE_EDITABLE value=$LINEITEM_FIELDS['image']->isEditable()}
		{if $IMAGE_EDITABLE}{assign var=COL_SPAN1 value=($COL_SPAN1)+1}{/if}
	{/if}
	{if $LINEITEM_FIELDS['productid']}
		{assign var=PRODUCT_EDITABLE value=$LINEITEM_FIELDS['productid']->isEditable()}
		{if $PRODUCT_EDITABLE}{assign var=COL_SPAN1 value=($COL_SPAN1)+1}{/if}
	{/if}
	{if $LINEITEM_FIELDS['quantity']}
		{assign var=QUANTITY_EDITABLE value=$LINEITEM_FIELDS['quantity']->isEditable()}
		{if $QUANTITY_EDITABLE}{assign var=COL_SPAN1 value=($COL_SPAN1)+1}{/if}
	{/if}
	{if $LINEITEM_FIELDS['quantity']}
		{assign var=QUANTITY_EDITABLE value=$LINEITEM_FIELDS['quantity']->isEditable()}
		{if $QUANTITY_EDITABLE}{assign var=COL_SPAN1 value=($COL_SPAN1)+1}{/if}
	{/if}
	{if $LINEITEM_FIELDS['quantity']}
		{assign var=QUANTITY_EDITABLE value=$LINEITEM_FIELDS['quantity']->isEditable()}
		{if $QUANTITY_EDITABLE}{assign var=COL_SPAN1 value=($COL_SPAN1)+1}{/if}
	{/if}
	{if $LINEITEM_FIELDS['purchase_cost']}
		{assign var=PURCHASE_COST_EDITABLE value=$LINEITEM_FIELDS['purchase_cost']->isEditable()}
		{if $PURCHASE_COST_EDITABLE}{assign var=COL_SPAN2 value=($COL_SPAN2)+1}{/if}
	{/if}
	{if $LINEITEM_FIELDS['listprice']}
		{assign var=LIST_PRICE_EDITABLE value=$LINEITEM_FIELDS['listprice']->isEditable()}
		{if $LIST_PRICE_EDITABLE}{assign var=COL_SPAN2 value=($COL_SPAN2)+1}{/if}
	{/if}
	{if $LINEITEM_FIELDS['margin']}
		{assign var=MARGIN_EDITABLE value=$LINEITEM_FIELDS['margin']->isEditable()}
		{if $MARGIN_EDITABLE}{assign var=COL_SPAN3 value=($COL_SPAN3)+1}{/if}
	{/if}
	{if $LINEITEM_FIELDS['comment']}
		{assign var=COMMENT_EDITABLE value=$LINEITEM_FIELDS['comment']->isEditable()}
	{/if}
	{if $LINEITEM_FIELDS['discount_amount']}
		{assign var=ITEM_DISCOUNT_AMOUNT_EDITABLE value=$LINEITEM_FIELDS['discount_amount']->isEditable()}
	{/if}
	{if $LINEITEM_FIELDS['discount_percent']}
		{assign var=ITEM_DISCOUNT_PERCENT_EDITABLE value=$LINEITEM_FIELDS['discount_percent']->isEditable()}
	{/if}
	{if $LINEITEM_FIELDS['hdnS_H_Percent']}
		{assign var=SH_PERCENT_EDITABLE value=$LINEITEM_FIELDS['hdnS_H_Percent']->isEditable()}
	{/if}
	{if $LINEITEM_FIELDS['hdnDiscountAmount']}
		{assign var=DISCOUNT_AMOUNT_EDITABLE value=$LINEITEM_FIELDS['hdnDiscountAmount']->isEditable()}
	{/if}
	{if $LINEITEM_FIELDS['hdnDiscountPercent']}
		{assign var=DISCOUNT_PERCENT_EDITABLE value=$LINEITEM_FIELDS['hdnDiscountPercent']->isEditable()}
	{/if}

	{assign var="FINAL" value=$RELATED_PRODUCTS.1.final_details}
	{assign var="IS_INDIVIDUAL_TAX_TYPE" value=true}
	{assign var="IS_GROUP_TAX_TYPE" value=false}

	{if $TAX_TYPE eq 'individual'}
		{assign var="IS_GROUP_TAX_TYPE" value=false}
		{assign var="IS_INDIVIDUAL_TAX_TYPE" value=true}
	{/if}

	<input type="hidden" class="numberOfCurrencyDecimal" value="{$USER_MODEL->get('no_of_currency_decimals')}" />
	<input type="hidden" name="subtotal" id="subtotal" value="" />
	<input type="hidden" name="total" id="total" value="" />
	<input type="hidden" disabled="disabled" id="fildNamesOfCustPickFieldsInfo"
		value={ZEND_JSON::encode($LINEITEM_CUSTOM_PICK_FIELDS)}>
	<input type="hidden" id="fildNamesOfCustFieldsDyno" value={ZEND_JSON::encode($katera)}>
	<div name='editContent' class="igLineItemBlock">
		{assign var=LINE_ITEM_BLOCK_LABEL value=$blLabe}
		{assign var=BLOCK_FIELDS value=$RECORD_STRUCTURE.$LINE_ITEM_BLOCK_LABEL}
		{assign var=BLOCK_LABEL value=$LINE_ITEM_BLOCK_LABEL}
		{if $BLOCK_FIELDS|@count gt 0}
			<div class='fieldBlockContainer'>
				<div class="row">
					<div class="col-sm-3">
						<h4 class='fieldBlockHeader' style="margin-top:5px;">{vtranslate($BLOCK_LABEL, $MODULE)}</h4>
					</div>
				</div>
				<div class="lineitemTableContainer">
					<table class="table table-bordered" id="{'lineItemTab'|cat:$dady}">
						<tr>
							<td><strong>{vtranslate('LBL_TOOLS',$MODULE)}</strong></td>
							{assign var="dingachNa" value='LINEITEM_CUSTOM_FIELDS'|cat:'_'|cat:$dady}
							{foreach key=LINEITEM_CUSTOM_FIELDKEY item=LINEITEM_CUSTOM_FIELD from=${$dingachNa}}
								<td>
									<strong>{vtranslate($LINEITEM_CUSTOM_FIELD['fieldlabel'],$MODULE)}</strong>
								</td>
							{/foreach}
						</tr>
						<tr id="{'row'|cat:$dady|cat:0}" class="hide lineItemCloneCopy" data-row-num="0">
							{include file="partials/LineItemsContentDyno.tpl"|@vtemplate_path:'Inventory' row_no=0 data=[] IGNORE_UI_REGISTRATION=true}
						</tr>
						{foreach key=row_no item=data from=${$kurkure}}
							<tr id="row{$row_no}" data-row-num="{$row_no}" class="lineItemRow"
								{if $data["entityType$row_no"] eq 'Products'}data-quantity-in-stock={$data["qtyInStock$row_no"]}{/if}>
								{include file="partials/LineItemsContentDyno.tpl"|@vtemplate_path:'Inventory' row_no=$row_no data=$data}
							</tr>
						{/foreach}
						{* {if count($RELATED_PRODUCTS) eq 0 and ($PRODUCT_ACTIVE eq 'true' || $SERVICE_ACTIVE eq 'true')}
						<tr id="row1" class="lineItemRow" data-row-num="1">
							{include file="partials/LineItemsContentDyno.tpl"|@vtemplate_path:'Inventory' row_no=1 data=[] IGNORE_UI_REGISTRATION=false}
						</tr>
					{/if} *}
					</table>
				</div>
			</div>
			<div>
				<div>
					{* {if $PRODUCT_ACTIVE eq 'true' && $SERVICE_ACTIVE eq 'true'} *}
						<div class="btn-toolbar">
							<span class="btn-group">
								<button type="button" class="btn btn-default" id="{'addProduct'|cat:$dady}" data-module-name="Products">
								<i class="fa fa-plus"></i>&nbsp;&nbsp;
									<strong>
										{vtranslate({${'dnynBName_'|cat:$dady}},$MODULE)}
									</strong>
								</button>
							</span>
							{* <span class="btn-group">
								<button type="button" class="btn btn-default" id="addService" data-module-name="Services">
									<i class="fa fa-plus"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_SERVICE',$MODULE)}</strong>
								</button>
							</span> *}
						</div>
					{* {elseif $PRODUCT_ACTIVE eq 'true'}
						<div class="btn-group">
							<button type="button" class="btn btn-default" id="{'addProduct'|cat:$dady}" data-module-name="Products">
								<i class="fa fa-plus"></i><strong>&nbsp;&nbsp;{vtranslate('LBL_ADD_PRODUCT',$MODULE)}</strong>
							</button>
						</div>
					{elseif $SERVICE_ACTIVE eq 'true'}
						<div class="btn-group">
							<button type="button" class="btn btn-default" id="addService" data-module-name="Services">
								<i class="fa fa-plus"></i><strong>&nbsp;&nbsp;{vtranslate('LBL_ADD_SERVICE',$MODULE)}</strong>
							</button>
						</div>
					{/if} *}
				</div>
			</div>
			</br>
		{/if}
	</div>