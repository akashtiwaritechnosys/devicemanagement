{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{* modules/Settings/MenuEditor/views/Index.php *}

{* START YOUR IMPLEMENTATION FROM BELOW. Use {debug} for information *}
{assign var=APP_IMAGE_MAP value=Vtiger_MenuStructure_Model::getAppIcons()}
<div class="listViewPageDiv detailViewContainer col-sm-12" id="listViewContent">
	<div class="col-sm-12">
		<div class="row">
			<div class=" vt-default-callout vt-info-callout">
				<h4 class="vt-callout-header"><span class="fa fa-info-circle"></span>{vtranslate('LBL_INFO', $QUALIFIED_MODULE_NAME)}</h4>
				<p>{vtranslate('LBL_MENU_EDITOR_INFO', $QUALIFIED_MODULE_NAME)}</p>
			</div>
		</div>
	</div>
	<div class="col-lg-12" style="margin-top: 10px;">
		<div class="row main-menu-list" style="margin-left: -28px;">
			{assign var=APP_LIST value=Vtiger_MenuStructure_Model::getAppMenuList()}
			{foreach item=APP_IMAGE key=APP_NAME from=$APP_IMAGE_MAP name=APP_MAP}
				{if !in_array($APP_NAME, $APP_LIST)} {continue} {/if}
				<div class="menueditor col-sm-3 col-md-3 col-lg-2 {if $smarty.foreach.APP_MAP.index eq 0 or php7_count($APP_LIST) eq 1}{/if}">
					<div class="menuEditorItem app-{$APP_NAME}" data-app-name="{$APP_NAME}">
						<span class="fa {$APP_IMAGE} head-icon"></span>
						{assign var=TRANSLATED_APP_NAME value={vtranslate("LBL_$APP_NAME")}}
						<div class="textOverflowEllipsis" title="{$TRANSLATED_APP_NAME}">{$TRANSLATED_APP_NAME}</div>
					</div>
					<div class="sortable appContainer" data-appname="{$APP_NAME}">
						{foreach key=moduleName item=moduleModel from=$APP_MAPPED_MODULES[$APP_NAME]}
							<div class="modules noConnect" data-module="{$moduleName}">
								<div>
									<div class="marginRight10px marginLeft10px">
									<i data-appname="{$APP_NAME}" class="fa fa-times pull-right whiteIcon menuEditorRemoveItem marginTop10px"></i>
									</div>
									<div>
									<span class="pull-left marginRight10px marginLeft10px marginTop5px">
										<img class="alignMiddle cursorDrag" src="{vimage_path('drag.png')}"/>
									</span>
									</div>
								</div>
								
								<div class="menuEditorItem menuEditorModuleItem">
									
									{assign var='translatedModuleLabel' value=vtranslate($moduleModel->get('label'),$moduleName )}
									<span>
										<span class="marginRight10px marginTop5px">{$moduleModel->getModuleIcon()}</span>
									</span>
									<div class="textOverflowEllipsis marginTop5px" title="{$translatedModuleLabel}">{$translatedModuleLabel}</div>
								</div>
							</div>
						{/foreach}
						<div class="menuEditorItem menuEditorModuleItem menuEditorAddItem" data-appname="{$APP_NAME}">
							<i class="fa fa-plus pull-left marginTop5px"></i>
							<div class="marginTop10px">{vtranslate('LBL_SELECT_HIDDEN_MODULE', $QUALIFIED_MODULE_NAME)}</div>
						</div> 
					</div>
				</div>
			{/foreach}
		</div>
	</div>
</div>
