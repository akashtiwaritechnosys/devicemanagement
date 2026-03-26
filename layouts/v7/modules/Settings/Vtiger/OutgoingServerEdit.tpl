{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{* modules/Settings/Vtiger/views/OutgoingServerEdit.php *}

{strip}
	<div class="editViewPageDiv editViewContainer" id="EditViewOutgoing" style="padding-top:0px;">
		<div class="col-lg-12 col-md-12 col-sm-12">
			<div>
		
				{*<h4 style="margin-top: 0px;" class='outgoing-server'>{vtranslate('LBL_OUTGOING_SERVER', $QUALIFIED_MODULE)}</h4> *}
				<p class="text-light-color" style="margin-bottom: 10px;">{vtranslate('LBL_OUTGOING_SERVER_DESC', $QUALIFIED_MODULE)}</p>
			</div>
			{assign var=WIDTHTYPE value=$CURRENT_USER_MODEL->get('rowheight')}
			<form id="OutgoingServerForm" data-detail-url="{$MODEL->getDetailViewUrl()}" method="POST">
				<input type="hidden" name="default" value="false" />
				<input type="hidden" name="server_port" value="0" />
				<input type="hidden" name="server_type" value="email"/>
				<input type="hidden" name="id" value="{$MODEL->get('id')}"/>
				<div class="blockData">
					
					<div class="hide errorMessage">
						<div class="alert alert-danger">
							{vtranslate('LBL_TESTMAILSTATUS', $QUALIFIED_MODULE)}<strong>{vtranslate('LBL_MAILSENDERROR', $QUALIFIED_MODULE)}</strong>
						</div>
					</div>
					<div class="block">
						<div>
							<div class="btn-group pull-right mb-4">
								<button class="btn t-btn resetButton" type="button" title="{vtranslate('LBL_RESET_TO_DEFAULT', $QUALIFIED_MODULE)}">{vtranslate('LBL_RESET_TO_DEFAULT', $QUALIFIED_MODULE)}</button>
							</div>
							<h5>{vtranslate('LBL_MAIL_SERVER_SMTP', $QUALIFIED_MODULE)}</h5>
						</div>
						<hr>
						<table class="table editview-table no-border">
							<tbody>
								<tr>
									<td class="{$WIDTHTYPE} fieldLabel outgoing-field-label"><label class="">{vtranslate('LBL_SERVER_TYPE', $QUALIFIED_MODULE)}</label></td>
									<td class="{$WIDTHTYPE} fieldValue">
										<div class=" col-lg-9 col-md-6 col-sm-12">
											<select class="select2 inputElement col-lg-12 col-md-12 col-lg-12" name="serverType">
												<option value="">{vtranslate('LBL_SELECT_OPTION','Vtiger')}</option>
												<option value="google-oauth2" {if {$MODEL->get('server')} eq "ssl://smtp.gmail.com:465" and {$MODEL->get('smtp_auth_type')} eq "XOAUTH2"} selected {/if}>{vtranslate('LBL_GMAIL', $QUALIFIED_MODULE)} OAuth2</option>
												{* Google disabled Password based from Sep 30, 2024 *}
												{* <option value="{"ssl://smtp.gmail.com:465"}" {if {$MODEL->get('server')} eq "ssl://smtp.gmail.com:465" and {$MODEL->get('smtp_auth_type')} neq "XOAUTH2"} selected {/if}>{vtranslate('LBL_GMAIL', $QUALIFIED_MODULE)}</option> *}
												<option value="{"smtp.live.com"}" {if {$MODEL->get('server')} eq "smtp.live.com"} selected {/if}>{vtranslate('LBL_HOTMAIL', $QUALIFIED_MODULE)}</option>
												<option value="{"smtp-mail.outlook.com"}" {if {$MODEL->get('server')} eq "smtp.live.com"} selected {/if}>{vtranslate('LBL_OFFICE365', $QUALIFIED_MODULE)}</option>
												<option value="{"smtp.mail.yahoo.com"}" {if {$MODEL->get('server')} eq "smtp.mail.yahoo.com"} selected {/if}>{vtranslate('LBL_YAHOO', $QUALIFIED_MODULE)}</option>
												<option value="">{vtranslate('LBL_OTHERS', $QUALIFIED_MODULE)}</option>
											</select>
										</div>
									</td>
								</tr>
								<tr>
									<td class="{$WIDTHTYPE} fieldLabel outgoing-field-label"><label class="">{vtranslate('LBL_SERVER_NAME', $QUALIFIED_MODULE)} &nbsp;<span class="redColor">*</span></label></td>
									<td class="{$WIDTHTYPE} fieldValue"><div class=" col-lg-9 col-md-12 col-sm-12"><input type="text" class="inputElement" name="server" data-rule-required="true" value="{$MODEL->get('server')}" ></div></td></tr>
								<tr>
									<td class="{$WIDTHTYPE} fieldLabel outgoing-field-label"><label class="">{vtranslate('LBL_USER_NAME', $QUALIFIED_MODULE)}</label></td>
									<td class="{$WIDTHTYPE} fieldValue" ><div class=" col-lg-9 col-md-12 col-sm-12"><input type="text" class="inputElement" name="server_username" value="{$MODEL->get('server_username')}" ></div></td></tr>
								<tr>
									<td class="{$WIDTHTYPE} fieldLabel outgoing-field-label"><label class="">{vtranslate('LBL_PASSWORD', $QUALIFIED_MODULE)}</label></td>
									<td class="{$WIDTHTYPE} fieldValue" ><div class=" col-lg-9 col-md-12 col-sm-12"><input type="password" class="inputElement" name="server_password" value="{$MODEL->get('server_password')}" ></div></td></tr>
								<tr>
									<td class="{$WIDTHTYPE} fieldLabel outgoing-field-label"><label class="">{vtranslate('LBL_FROM_EMAIL', $QUALIFIED_MODULE)}</label></td>
									<td class="{$WIDTHTYPE} fieldValue" ><div class=" col-lg-9 col-md-12 col-sm-12"><input type="text" class="inputElement" name="from_email_field" data-rule-email="true" data-rule-illegal="true" value="{$MODEL->get('from_email_field')}" ></div> </td>
								</tr>
								<tr>
									<td class="{$WIDTHTYPE} fieldLabel outgoing-field-label">&nbsp;</td>
									<td class="{$WIDTHTYPE} fieldValue" ><div class=" col-lg-12 col-md-12 col-sm-12"><div class="alert alert-info alert-mini">{vtranslate('LBL_OUTGOING_SERVER_FROM_FIELD', $QUALIFIED_MODULE)}</div></div></td>
								</tr>
								<tr>
									<td class="{$WIDTHTYPE} fieldLabel outgoing-field-label"><label class="">{vtranslate('LBL_REQUIRES_AUTHENTICATION', $QUALIFIED_MODULE)}</label></td>
									<td class="{$WIDTHTYPE}" style="border-left: none;"><div class=" col-lg-9 col-md-12 col-sm-12"><input type="checkbox" name="smtp_auth" {if $MODEL->isSmtpAuthEnabled()}checked{/if} ></div></td>
								</tr>
							</tbody>
						</table>
					</div>
					<br>	
					<div class='modal-overlay-footer clearfix'>
						<div class="row clearfix">
							<div class='textAlignCenter col-lg-12 col-md-12 col-sm-12 '>
								<div class='footer-btns'>
									<button type='submit' class='btn btn-submit saveButton' >{vtranslate('LBL_SAVE', $MODULE)}</button>
									<a class='cancelLink' data-dismiss="modal" href="#">{vtranslate('LBL_CANCEL', $MODULE)}</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
{/strip}
