{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{* modules/Settings/Vtiger/views/CompanyDetails.php *}

{* START YOUR IMPLEMENTATION FROM BELOW. Use {debug} for information *}

{strip}

	<div class=" col-lg-12 col-md-12 col-sm-12">
		<input type="hidden" id="supportedImageFormats" value='{ZEND_JSON::encode(Settings_Vtiger_CompanyDetails_Model::$logoSupportedFormats)}' />
		{*<div class="blockData" >
		<h3>{vtranslate('LBL_COMPANY_DETAILS', $QUALIFIED_MODULE)}</h3>
		{if $DESCRIPTION}<span style="font-size:12px;color: black;"> - &nbsp;{vtranslate({$DESCRIPTION}, $QUALIFIED_MODULE)}</span>{/if}
		</div>
		<hr>*}
		<style>
			.color-picker {
      display: flex;
      gap: 20px; /* space between options */
      align-items: center;
      flex-wrap: wrap; /* wrap on small screens */
    }
    .color-option {
      display: flex;
      align-items: center;
    }
    .color-swatch {
      width: 20px;
      height: 20px;
      margin-left: 5px;
      border: 1px solid #ccc;
      border-radius: 50%;
    }
	label {
            display: block;
            color: #7d7d7d;
        }
        .floatBlock {
            margin: 0 1.81em 0 0;
        }
        .labelish {
            color:#7d7d7d;
            margin: 0;
        }
        .paymentOptions {
            border: none;
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            break-before: always;
            margin: 0 0 3em 0;
        }
        #purchaseOrder {
            margin: 0 0 2em 0;
        }

		 .color-label {
			display: inline-flex;
			align-items: center;
			cursor: pointer;
			padding: 8px 12px;
			border: 2px solid #ccc;
			border-radius: 8px;
			background: #fff;
			font-family: sans-serif;
			font-size: 14px;
			}

			.color-preview {
			width: 20px;
			height: 20px;
			border-radius: 50%;
			margin-right: 10px;
			border: 1px solid #999;
			}

			.color-input {
			opacity: 0;
			position: absolute;
			pointer-events: none;
			}
			input[type="radio"]:checked {
				background: black;
			}
		</style>
		<div class="clearfix">
			<div class="btn-group pull-right editbutton-container">
				<button id="updateCompanyDetails" class="btn btn-default ">{vtranslate('LBL_EDIT',$QUALIFIED_MODULE)}</button>
			</div>
		</div>
		{assign var=WIDTHTYPE value=$CURRENT_USER_MODEL->get('rowheight')}
		<div id="CompanyDetailsContainer" class=" detailViewContainer {if !empty($ERROR_MESSAGE)}hide{/if}" >
			<div class="block">
				<div>
					<h4>{vtranslate('LBL_COMPANY_LOGO',$QUALIFIED_MODULE)}</h4>
				</div>
				
				<div class="blockData">
					<table class="table detailview-table no-border">
						<tbody>
							<tr>
								<td class="fieldLabel">
									<div class="companyLogo">
										{if $MODULE_MODEL->getLogoPath()}
											<img src="{$MODULE_MODEL->getLogoPath()}" class="alignMiddle" style="max-width:700px;"/>
										{else}
											{vtranslate('LBL_NO_LOGO_EDIT_AND_UPLOAD', $QUALIFIED_MODULE)}
										{/if}
									</div>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<br>
			<div class="block">
				<div>
					<h4>{vtranslate('LBL_COMPANY_INFORMATION',$QUALIFIED_MODULE)}</h4>
				</div>
				
				<div class="blockData">
					<table class="table detailview-table no-border">
						<tbody>
							{foreach from=$MODULE_MODEL->getFields() item=FIELD_TYPE key=FIELD}
								{if $FIELD neq 'logoname' && $FIELD neq 'logo' }
									<tr>
										<td class="{$WIDTHTYPE} fieldLabel" style="width:25%"><label >{vtranslate($FIELD,$QUALIFIED_MODULE)}</label></td>
										<td class="{$WIDTHTYPE}" style="word-wrap:break-word;">
											{if $FIELD eq 'address'} {decode_html($MODULE_MODEL->get($FIELD))|nl2br} {else} {decode_html($MODULE_MODEL->get($FIELD))} {/if}
										</td>
									</tr>
								{/if}
							{/foreach}
						</tbody>
					</table>
				</div>
			</div>
		</div>


		<div class="editViewContainer">
			<form class="form-horizontal {if empty($ERROR_MESSAGE)}hide{/if}" id="updateCompanyDetailsForm" method="post" action="index.php" enctype="multipart/form-data">
				<input type="hidden" name="module" value="Vtiger" />
				<input type="hidden" name="parent" value="Settings" />
				<input type="hidden" name="action" value="CompanyDetailsSave" />
				<div class="form-group companydetailsedit">
					<label class="col-lg-3 col-md-4 col-sm-4 fieldLabel control-label"> {vtranslate('LBL_COMPANY_LOGO',$QUALIFIED_MODULE)}</label>
					<div class="fieldValue col-lg-6 col-md-7 col-sm-7" >
						<div class="company-logo-content">
							<img src="{$MODULE_MODEL->getLogoPath()}" class="alignMiddle" style="max-width:700px;"/>
							<br><hr>
							<input type="file" name="logo" id="logoFile" />
						</div>
						<div class="alert alert-info" >
							{vtranslate('LBL_LOGO_RECOMMENDED_MESSAGE',$QUALIFIED_MODULE)}
						</div>
						<br>
						<p> Primary Color </p>
						<div id="paymentContainer" style="margin : 0px" name="paymentContainer" class="paymentOptions">
							{foreach item=PICKLIST_VALUE key=PICKLIST_NAME from=$LOGO_BASE_COLORS}
								<div id="payCC" class="floatBlock">
									<label class="color-option">
										<input type="radio" name="primary_color" value="{$PICKLIST_VALUE}">
										<span class="color-swatch" style="background-color: {$PICKLIST_VALUE}"></span>{$PICKLIST_VALUE}
									</label>
								</div>
							{/foreach}
							<div id="payCC" class="floatBlock">
								<label class="color-option">
									<span class="color-swatch" id="preview" style="background-color: #f69432;"></span>
									Pick Color
									<input type="color" name="primary_color" id="primary_color" value="#f69432">
								</label>
							</div>
						</div>
						<br>
						<p> Secondary Color </p>
						<div id="paymentContainer" style="margin : 0px" name="paymentContainer" class="paymentOptions">
							{foreach item=PICKLIST_VALUE key=PICKLIST_NAME from=$LOGO_BASE_COLORS}	
								<div id="payCC" class="floatBlock">
									<label class="color-option">
										<input type="radio" name="secondary_color" value="{$PICKLIST_VALUE}">
										<span class="color-swatch" style="background-color: {$PICKLIST_VALUE}"></span>{$PICKLIST_VALUE}
									</label>
								</div>
							{/foreach}
							<div id="payCC" class="floatBlock">
								<label class="color-option">
									<span class="color-swatch" id="preview" style="background-color: #f69432;"></span>
									Pick Color
									<input type="color" name="secondary_color" id="secondary_color" value="#f69432">
								</label>
							</div>
						</div>
						<br>
					</div>
				</div>

				{foreach from=$MODULE_MODEL->getFields() item=FIELD_TYPE key=FIELD}
					{if $FIELD neq 'logoname' && $FIELD neq 'logo' }
						<div class="form-group companydetailsedit">
							<label class="col-lg-3 col-md-4 col-sm-4 fieldLabel control-label ">
								{vtranslate($FIELD,$QUALIFIED_MODULE)}{if $FIELD eq 'organizationname'}&nbsp;<span class="redColor">*</span>{/if}
							</label>
							<div class="fieldValue col-lg-6 col-md-7 col-sm-7">
								{if $FIELD eq 'address'}
									<textarea class="form-control col-lg-6 col-md-7 col-sm-7 resize-vertical" rows="2" name="{$FIELD}">{$MODULE_MODEL->get($FIELD)}</textarea>
								{else if $FIELD eq 'website'}
									<input type="text" class="inputElement" data-rule-url="true" name="{$FIELD}" value="{$MODULE_MODEL->get($FIELD)}"/>
								{else}
									<input type="text" {if $FIELD eq 'organizationname'} data-rule-required="true" {/if} class="inputElement" name="{$FIELD}" value="{$MODULE_MODEL->get($FIELD)}"/>
								{/if}
							</div>
						</div>
					{/if}
				{/foreach}

				<div class="modal-overlay-footer clearfix">
					<div class="row clearfix">
						<div class="textAlignCenter col-lg-12 col-md-12 col-sm-12">
							<div class='footer-btns'>
								<button type="submit" class="btn btn-submit saveButton">{vtranslate('LBL_SAVE', $MODULE)}</button>
								<a class="cancelLink" data-dismiss="modal" href="#">{vtranslate('LBL_CANCEL', $MODULE)}</a>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
</div>
</div>
{/strip}
