{assign var=COL_SPAN1 value=0}
{assign var=COL_SPAN2 value=0}
{assign var=COL_SPAN3 value=2}
{assign var=IMAGE_VIEWABLE value=false}
{assign var=PRODUCT_VIEWABLE value=false}
{assign var=QUANTITY_VIEWABLE value=false}
{assign var=PURCHASE_COST_VIEWABLE value=false}
{assign var=LIST_PRICE_VIEWABLE value=false}
{assign var=MARGIN_VIEWABLE value=false}
{assign var=COMMENT_VIEWABLE value=false}
{assign var=ITEM_DISCOUNT_AMOUNT_VIEWABLE value=false}
{assign var=ITEM_DISCOUNT_PERCENT_VIEWABLE value=false}
{assign var=SH_PERCENT_VIEWABLE value=false}
{assign var=DISCOUNT_AMOUNT_VIEWABLE value=false}
{assign var=DISCOUNT_PERCENT_VIEWABLE value=false}
<input type="hidden" class="isCustomFieldExists" value="false">
<div class="details block">
    {assign var=IS_HIDDEN value=$BLOCK->isHidden()}
    <h4 class="textOverflowEllipsis maxWidth50">
    <img class="cursorPointer alignMiddle blockToggle {if !($IS_HIDDEN)} hide {/if}"
        src="{vimage_path('arrowRight.png')}" data-mode="hide"
        data-id={$BLOCK_LIST[$BLOCK_LABEL_KEY]->get('id')}>
    <img class="cursorPointer alignMiddle blockToggle {if ($IS_HIDDEN)} hide {/if}"
        src="{vimage_path('arrowdown.png')}" data-mode="show"
        data-id={$BLOCK_LIST[$BLOCK_LABEL_KEY]->get('id')}>&nbsp;
    {vtranslate({$BLOCK_LABEL_KEY},{$MODULE_NAME})}
    </h4>
    <div class="blockData">
        <div class="lineItemTableDiv">
            <table class="table table-bordered lineItemsTable" style = "margin-top:15px">
                <tbody {if $IS_HIDDEN} class="hide" {/if}>
                    <tr>
                        {assign var="dingachNa" value='LINEITEM_CUSTOM_FIELDS'|cat:'_'|cat:$dady}
                        {foreach key=LINEITEM_CUSTOM_FIELDKEY item=LINEITEM_CUSTOM_FIELD from=${$dingachNa}}
                            <td>
                                <strong>{vtranslate($LINEITEM_CUSTOM_FIELD['fieldlabel'],$MODULE)}</strong>
                            </td>
                        {/foreach}
                    </tr>
                    {foreach key=INDEX item=LINE_ITEM_DETAIL from=${$kurkure}}
                        <tr>
                            {foreach key=LINEITEM_CUSTOM_FIELDKEY item=LINEITEM_CUSTOM_FIELD from=${$dingachNa}}
                                {assign var="fieldName" value=$LINEITEM_CUSTOM_FIELD['fieldname']}
                                <td>
                                    {if  $LINEITEM_CUSTOM_FIELD['uitype'] eq '5'}
                                        {Vtiger_Functions::currentUserDisplayDate($LINE_ITEM_DETAIL["$fieldName$INDEX"])}
                                    {elseif $LINEITEM_CUSTOM_FIELD['uitype'] eq '56'}
                                        {if $LINE_ITEM_DETAIL["$fieldName$INDEX"] eq 1} Yes {else} No {/if}
                                    {else}
                                        {$LINE_ITEM_DETAIL["$fieldName$INDEX"]}
                                    {/if}
                                </td>
                            {/foreach}
                        </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>