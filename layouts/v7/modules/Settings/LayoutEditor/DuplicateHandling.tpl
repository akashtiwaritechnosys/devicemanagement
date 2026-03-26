{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*************************************************************************************}

{strip}
	<div class="duplicateHandlingDiv padding20">
		<form class="duplicateHandlingForm">
			<input type="hidden" name="_source" value="{(isset($SOURCE)) ? $SOURCE : ''}" />
			<input type="hidden" name="sourceModule" value="{$SOURCE_MODULE}" id="sourceModule" />
			<input type="hidden" name="parent" value="Settings" />
			<input type="hidden" name="module" value="LayoutEditor" />
			<input type="hidden" name="action" value="Field" />
			<input type="hidden" name="mode" value="updateDuplicateHandling" />

			<div>
				<div class="vt-default-callout vt-info-callout"> 
					<h4 class="vt-callout-header"><span class="fa fa-info-circle"></span>&nbsp; Info </h4>
					<p class="duplicationInfoMessage">{vtranslate('LBL_DUPLICATION_INFO_MESSAGE', $QUALIFIED_MODULE)}</p>
				</div>
			</div><br>
			<div class="row">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-3">
							<p class="marginTop5px text-dark-color">{vtranslate('LBL_DUPLICATE_CHECK', $QUALIFIED_MODULE)}</p>
						</div>
						<div class="col-lg-4">
							<input type="hidden" class="rule" name="rule" value="">
							<input type="checkbox" class="duplicateCheck" data-on-color="success" data-off-color="danger" data-current-rule="{$SOURCE_MODULE_MODEL->allowDuplicates}" {if !$SOURCE_MODULE_MODEL->isFieldsDuplicateCheckAllowed()}readonly="readonly"{/if}
									data-on-text="{vtranslate('LBL_YES', $QUALIFIED_MODULE)}" data-off-text="{vtranslate('LBL_NO', $QUALIFIED_MODULE)}" />
						</div>
					</div>
				</div>
			</div>
			
			<div class="duplicateHandlingContainer show col-lg-12">
				<div class="fieldsBlock">
					<div>
						<p>{vtranslate('LBL_SELECT_FIELDS_FOR_DUPLICATION', $QUALIFIED_MODULE)}</p>
					</div>
					<select class="col-lg-7 col-md-9 col-sm-9 select" id="fieldsList" multiple name="fieldIdsList[]" data-placeholder="{vtranslate('LBL_SELECT_FIELDS', $QUALIFIED_MODULE)}" data-rule-required="true" >
						{foreach key=BLOCK_LABEL item=FIELD_MODELS from=$FIELDS}
							<optgroup label='{vtranslate($BLOCK_LABEL, $SOURCE_MODULE)}'>
								{foreach key=KEY item=FIELD_MODEL from=$FIELD_MODELS}
									<option {if $FIELD_MODEL->isUniqueField()}selected=""{/if} value={$FIELD_MODEL->getId()}>
										{vtranslate($FIELD_MODEL->get('label'), $SOURCE_MODULE)}
									</option>
								{/foreach}
							</optgroup>
						{/foreach}
					</select>
					<div class="col-lg-5 marginTop5px marginLeftZero">
						<span>&nbsp;&nbsp;{vtranslate('LBL_MAX_3_FIELDS', $QUALIFIED_MODULE)}</span>
					</div>
				</div>
				<br><br><br>
				{if $SOURCE_MODULE_MODEL->isSyncable}
					<div class="ruleBlock rule-block">
						<div>
							<p>{vtranslate('LBL_DUPLICATES_IN_SYNC_MESSAGE', $QUALIFIED_MODULE)}</p>
						</div>
						<div class="">
							<select class="select actionsList col-lg-7 col-md-9 col-sm-11" name="syncActionId">
								{foreach key=ACTION_ID item=ACTION_NAME from=$ACTIONS}
									<option {if $SOURCE_MODULE_MODEL->syncActionForDuplicate eq $ACTION_ID}selected=""{/if} value="{$ACTION_ID}">{vtranslate($ACTION_NAME, $QUALIFIED_MODULE)}</option>
								{/foreach}
							</select>
							<span class="input-info-addon syncMessage">
								<a class="fa fa-info-circle" data-toggle="tooltip" data-html="true" data-placement="right" title="{vtranslate('LBL_SYNC_TOOLTIP_MESSAGE', $QUALIFIED_MODULE)}"></a>
							</span>
						</div>
					</div>
					<br><br>
				{/if}
				<div class="formFooter hide">
					<div class="footer-btns">
						<button class="btn btn-submit" type="submit" name="saveButton">{vtranslate('LBL_SAVE', $MODULE)}</button>
						<a class="cancelLink" type="reset" data-dismiss="modal">{vtranslate('LBL_CANCEL', $MODULE)}</a>
					</div>
				</div>
			</div>
		</form>
	</div>
{/strip}