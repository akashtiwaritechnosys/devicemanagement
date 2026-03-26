{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*
********************************************************************************/
-->*}

<div class='dashboardHeading'>
	<div class="buttonGroups pull-right dashboard-addWidget-tabs">
		<div class="btn-group">
			{if $SELECTABLE_WIDGETS|count gt 0}
				<button class='btnn btn-defaultt bg-blue-btn addButton dropdown-toggle' data-toggle='dropdown'>
					{vtranslate('LBL_ADD_WIDGET')}&nbsp;&nbsp;<i class="caret"></i>
				</button>

				<ul class="dropdown-menu dropdown-menu-right widgetsList pull-right" style="width:100%;text-align:left;">
					{assign var="MINILISTWIDGET" value=""}
					{foreach from=$SELECTABLE_WIDGETS item=WIDGET}
						{if $WIDGET->getName() eq 'MiniList'}
							{assign var="MINILISTWIDGET" value=$WIDGET} {* Defer to display as a separate group *}
						{elseif $WIDGET->getName() eq 'Notebook'}
							{assign var="NOTEBOOKWIDGET" value=$WIDGET}
						{* {elseif $WIDGET->getName() eq 'AddCard'}
							{assign var="ADDCARDWIDGET" value=$WIDGET} *}
						{else}
							<li>
								<a style="white-space: normal;" onclick="Vtiger_DashBoard_Js.addWidget(this, '{$WIDGET->getUrl()}')" href="javascript:void(0);"
									data-linkid="{$WIDGET->get('linkid')}" data-name="{$WIDGET->getName()}" data-width="{$WIDGET->getWidth()}" data-height="{$WIDGET->getHeight()}">
									{vtranslate($WIDGET->getTitle(), $MODULE_NAME)}</a>
							</li>
						{/if}
					{/foreach}

					{if $MINILISTWIDGET && $MODULE_NAME == 'Home'}
						<li class="divider"></li>
						<li>
							<a onclick="Vtiger_DashBoard_Js.addMiniListWidget(this, '{$MINILISTWIDGET->getUrl()}')" href="javascript:void(0);"
								data-linkid="{$MINILISTWIDGET->get('linkid')}" data-name="{$MINILISTWIDGET->getName()}" data-width="{$MINILISTWIDGET->getWidth()}" data-height="{$MINILISTWIDGET->getHeight()}">
								{vtranslate($MINILISTWIDGET->getTitle(), $MODULE_NAME)}</a>
						</li>
						<li>
							<a onclick="Vtiger_DashBoard_Js.addNoteBookWidget(this, '{$NOTEBOOKWIDGET->getUrl()}')" href="javascript:void(0);"
								data-linkid="{$NOTEBOOKWIDGET->get('linkid')}" data-name="{$NOTEBOOKWIDGET->getName()}" data-width="{$NOTEBOOKWIDGET->getWidth()}" data-height="{$NOTEBOOKWIDGET->getHeight()}">
								{vtranslate($NOTEBOOKWIDGET->getTitle(), $MODULE_NAME)}</a>
						</li>
						{* <li>
							<a onclick="Vtiger_DashBoard_Js.addCardWidget(this, '{$ADDCARDWIDGET->getUrl()}')" href="javascript:void(0);"
								data-linkid="{$ADDCARDWIDGET->get('linkid')}" data-name="{$ADDCARDWIDGET->getName()}" data-width="{$ADDCARDWIDGET->getWidth()}" data-height="{$ADDCARDWIDGET->getHeight()}">
								{vtranslate($ADDCARDWIDGET->getTitle(), $MODULE_NAME)}</a>
						</li> *}
					{/if}

				</ul>
			{else if $MODULE_PERMISSION}
				<button class='btnn btn-defaultt bg-blue-btn addButton dropdown-toggle' disabled="disabled" data-toggle='dropdown'>
					<strong>{vtranslate('LBL_ADD_WIDGET')}</strong> &nbsp;&nbsp;
					<i class="caret"></i>
				</button>
			{/if}
		</div>
	</div>
</div>
