{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*************************************************************************************}

{strip}
        <style>
        .related-tabs.row .nav > li{
                width: initial;
                padding: 0px;
        }
        .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus, .nav-tabs > li > a{
                color: #2c2463;
        }
        .row .nav > li > a:hover{
                color: #2c2463;
        }
        .nav-tabs .textOverflowEllipsis{
                font-weight: bold;
                padding-top: 13px;
                text-align: center;
                background: #2c2463;
                color: #fff;
                border-radius: 5px;
        }
         @import url('https://fonts.googleapis.com/css?family=Quicksand&display=swap');
              
               
                .alert{
                width:50%;
                margin:10px auto;
                margin-bottom: 20px;
                position:relative;
                border-radius:5px;
                box-shadow:0 0 15px 5px #ccc;
                }
               .success-alert{
                background-color:#a8f0c6;
                border-left:5px solid #178344;
               }
               .danger-alert{
                background-color:#f7a7a3;
                border-left:5px solid #8f130c;
                color: #8f130c;
               }
        </style>
	<div class='related-tabs row'>
		<nav class="navbar margin0" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle btn-group-justified collapsed border0" data-toggle="collapse" data-target="#nav-tabs" aria-expanded="false">
					<i class="fa fa-ellipsis-h"></i>
				</button>
			</div>

                        {if !empty($DETAILVIEW_LINKS['DETAILVIEWTABSTATUS_ALERT'])}
                                {* {if ($DETAILVIEW_LINKS['DETAILVIEWTABSTATUS_ALERT'][0]->status eq 'success')}
                                        <div class="alert success-alert text-center">
                                                <h3>This Project completed</h3> .
                                        </div>
                                {/if} *}
                                {if ($DETAILVIEW_LINKS['DETAILVIEWTABSTATUS_ALERT'][0]->status  eq 'failure')}
                                        <div class="alert danger-alert text-center">
                                                <h3><strong>Danger!</strong>  This Project could not be move Not beacause <strong>Discussion was Failure</strong> This now <strong>Archived</strong></h3>.
                                        </div>
                                {/if}
                        {/if}

                        <div class="progress ">               
                                <div class="circle active ">
                                    <span class="label">✓</span>
                                    <span class="title">Discussion</span>
                                </div>
                                <span class="bar done"></span>
                                <div class="circle   ">
                                    <span class="label">✓</span>
                                    <span class="title">
                                        <a href="index.php?module=Agreement&amp;view=Edit&amp;sourceModule=Leads&amp;sourceRecord=403&amp;relationOperation=true&amp;returnmode=showRelatedList&amp;returntab_label=Agreement&amp;returnrecord=403&amp;returnmodule=Leads&amp;returnview=Detail&amp;returnrelatedModuleName=Agreement&amp;returnrelationId=173&amp;app=MARKETING'">1</a>
                                    </span>
                                </div>

                                <span class="bar done"></span>
                                <div class="circle   ">
                                    <span class="label">✓</span>
                                    <span class="title">
                                        <a href="index.php?module=Permission&amp;view=Edit&amp;sourceModule=Leads&amp;sourceRecord=403&amp;relationOperation=true&amp;returnmode=showRelatedList&amp;returntab_label=Permission&amp;returnrecord=403&amp;returnmodule=Leads&amp;returnview=Detail&amp;returnrelatedModuleName=Permission&amp;returnrelationId=174&amp;app=MARKETING'">2</a>
                                    </span>
                                </div>
                                <span class="bar done"></span>
                                <div class="circle   ">
                                    <span class="label">✓</span>
                                    <span class="title">
                                        <a href="index.php?module=Registry&amp;view=Edit&amp;sourceModule=Leads&amp;sourceRecord=403&amp;relationOperation=true&amp;returnmode=showRelatedList&amp;returntab_label=Registry&amp;returnrecord=403&amp;returnmodule=Leads&amp;returnview=Detail&amp;returnrelatedModuleName=Registry&amp;returnrelationId=175&amp;app=MARKETING'">3</a>
                                    </span>
                                </div>
                            </div>

                        </div>

			<div class="collapse  navbar-collapse " id="nav-tabs">
				<ul class="nav nav-tabs ">
					{foreach item=RELATED_LINK from=$DETAILVIEW_LINKS['DETAILVIEWTAB']}
						{assign var=RELATEDLINK_URL value=$RELATED_LINK->getUrl()}
						{assign var=RELATEDLINK_LABEL value=$RELATED_LINK->getLabel()}
						{assign var=RELATED_TAB_LABEL value={vtranslate('SINGLE_'|cat:$MODULE_NAME, $MODULE_NAME)}|cat:" "|cat:$RELATEDLINK_LABEL}
                                                {if ($RELATEDLINK_LABEL eq 'Details')}
						<li class="tab-item {if $RELATED_TAB_LABEL==$SELECTED_TAB_LABEL}active{/if}" data-url="{$RELATEDLINK_URL}&tab_label={$RELATED_TAB_LABEL}&app={$SELECTED_MENU_CATEGORY}" data-label-key="{$RELATEDLINK_LABEL}" data-link-key="{$RELATED_LINK->get('linkKey')}" >
							<a href="{$RELATEDLINK_URL}&tab_label={$RELATEDLINK_LABEL}&app={$SELECTED_MENU_CATEGORY}" class="textOverflowEllipsis">
								<span class="tab-label"><strong>{$RELATEDLINK_LABEL}</strong></span>
							</a>
						</li>
                                                {/if}
					{/foreach}
                                        {if ($DETAILVIEW_LINKS['DETAILVIEWTABSTATUS_ALERT'][0]->status  neq 'failure')}
					        {assign var=RELATEDTABS value=$DETAILVIEW_LINKS['DETAILVIEWRELATED']}
                                                {if !empty($RELATEDTABS)}
                                                {assign var=COUNT value=$RELATEDTABS|@count}

                                                {assign var=LIMIT value = 11}
                                                {if $COUNT gt 10}
                                                        {assign var=COUNT1 value = $LIMIT}
                                                {else}
                                                        {assign var=COUNT1 value=$COUNT}
                                                {/if}

                                                {for $i = 0 to $COUNT1-1}
                                                        {assign var=RELATED_LINK value=$RELATEDTABS[$i]}
                                                        {assign var=RELATEDMODULENAME value=$RELATED_LINK->getRelatedModuleName()}
                                                        {assign var=RELATEDFIELDNAME value=$RELATED_LINK->get('linkFieldName')}
                                                        {assign var="DETAILVIEWRELATEDLINKLBL" value= vtranslate($RELATED_LINK->getLabel(),$RELATEDMODULENAME)}  
                                                        {if $RELATEDMODULENAME eq "ModComments"}
                                                                {if (!empty($DETAILVIEW_LINKS['DETAILVIEWTAB_PAYMENTSUMMARY']))}
                                                                        <li class="tab-item" data-url="{$DETAILVIEW_LINKS['DETAILVIEWTAB_PAYMENTSUMMARY'][0]->linkurl}" data-label-key=""data-module="paymentsummary" data-relation-id="0" >
                                                                                <a  class="textOverflowEllipsis" displaylabel="Payments Summary" recordsCount="" >
                                                                                        <span class="tab-icon"></span>
                                                                                        <span class="tab-label" >
                                                                                            <strong>Payment Summary </strong>
                                                                                        </span>
                                                                                </a>
                                                                        </li>
                                                                {/if}

                                                                {if (!empty($DETAILVIEW_LINKS['DETAILVIEWTAB_DOCGEN']))}
                                                                        <li class="tab-item" data-url="{$DETAILVIEW_LINKS['DETAILVIEWTAB_DOCGEN'][0]->linkurl}" data-label-key=""data-module="GenerateDocuments" data-relation-id="0" >
                                                                                <a  class="textOverflowEllipsis" displaylabel="Generate Documents" recordsCount="" >
                                                                                        <span class="tab-icon"></span>
                                                                                        <span class="tab-label" >
                                                                                            <strong>Generate Documents</strong>
                                                                                        </span>
                                                                                </a>
                                                                        </li>
                                                                {/if}
                                                        {/if}
                                                        {if ( $DETAILVIEWRELATEDLINKLBL eq 'Possession' || $DETAILVIEWRELATEDLINKLBL eq 'Reclassification' || $DETAILVIEWRELATEDLINKLBL eq 'Mutation'  || $DETAILVIEWRELATEDLINKLBL eq 'Registry' || $DETAILVIEWRELATEDLINKLBL eq  'Permission'  || $DETAILVIEWRELATEDLINKLBL eq 'Discussion' ||  $DETAILVIEWRELATEDLINKLBL eq 'Agreement') }
                                                                <li class="tab-item {if (trim($RELATED_LINK->getLabel())== trim($SELECTED_TAB_LABEL)) && ($RELATED_LINK->getId() == $SELECTED_RELATION_ID)}active{/if}  {if ($RELATED_LINK->count lt '1')} hide{/if} *}" data-url="{$RELATED_LINK->getUrl()}&tab_label={$RELATED_LINK->getLabel()}&app={$SELECTED_MENU_CATEGORY}" data-label-key="{$RELATED_LINK->getLabel()}"
                                                                        data-module="{$RELATEDMODULENAME}" data-relation-id="{$RELATED_LINK->getId()}" {if $RELATEDMODULENAME eq "ModComments"} title {else} title="{$DETAILVIEWRELATEDLINKLBL}"{/if} {if $RELATEDFIELDNAME}data-relatedfield ="{$RELATEDFIELDNAME}"{/if}>
                                                                        <a href="index.php?{$RELATED_LINK->getUrl()}&tab_label={$RELATED_LINK->getLabel()}&app={$SELECTED_MENU_CATEGORY}" class="textOverflowEllipsis" displaylabel="{$DETAILVIEWRELATEDLINKLBL}" recordsCount="" >
                                                                                {if $RELATEDMODULENAME eq "ModComments"}
                                                                                        <span class="tab-icon"><i class="fa fa-comment"></i></span>
                                                                                {else}
                                                                                        <span class="tab-label">
                                                                                        <strong>{$RELATEDMODULENAME}</strong>
                                                                                        </span>
                                                                                {/if}
                                                                        
                                                                        </a>
                                                                </li>
                                                        {else if ( $DETAILVIEWRELATEDLINKLBL eq 'Activities' || $DETAILVIEWRELATEDLINKLBL eq 'Documents' || $DETAILVIEWRELATEDLINKLBL eq 'Payment')}
                                                                {continue}
                                                                   
                                                        {else}
                                                                <li class="tab-item {if (trim($RELATED_LINK->getLabel())== trim($SELECTED_TAB_LABEL)) && ($RELATED_LINK->getId() == $SELECTED_RELATION_ID)}active{/if}" data-url="{$RELATED_LINK->getUrl()}&tab_label={$RELATED_LINK->getLabel()}&app={$SELECTED_MENU_CATEGORY}" data-label-key="{$RELATED_LINK->getLabel()}"
                                                                        data-module="{$RELATEDMODULENAME}" data-relation-id="{$RELATED_LINK->getId()}" {if $RELATEDMODULENAME eq "ModComments"} title {else} title="{$DETAILVIEWRELATEDLINKLBL}"{/if} {if $RELATEDFIELDNAME}data-relatedfield ="{$RELATEDFIELDNAME}"{/if}>
                                                                        <a href="index.php?{$RELATED_LINK->getUrl()}&tab_label={$RELATED_LINK->getLabel()}&app={$SELECTED_MENU_CATEGORY}" class="textOverflowEllipsis" displaylabel="{$DETAILVIEWRELATEDLINKLBL}" recordsCount="" >
                                                                                {if $RELATEDMODULENAME eq "ModComments"}
                                                                                        <span class="tab-label"><strong>Comments </strong></span>
                                                                                {else}
                                                                                        <span class="tab-label">
                                                                                        {* {assign var=RELATED_MODULE_MODEL value=Vtiger_Module_Model::getInstance($RELATEDMODULENAME)}
                                                                                                {$RELATED_MODULE_MODEL->getModuleIcon()}
                                                                                                *}
                                                                                        <strong>{$RELATEDMODULENAME} </strong>
                                                                                        </span>
                                                                                        
                                                                                {/if}
                                                                                {if $RELATEDMODULENAME eq 'Calendar'}
                                                                                            &nbsp;<span class="numberCircle hide">0</span>
                                                                                {/if}
                                                                                
                                                                        </a>
                                                                </li>
                                                        {/if}
                                                        {if ($RELATED_LINK->getId() == {$smarty.request.relationId})}
                                                                {assign var=MORE_TAB_ACTIVE value='true'}
                                                        {/if}
                                                {/for}
                                                
                                               
                                                {if (count($DETAILVIEW_LINKS['DETAILVIEWTAB_TASK']) neq '0')}
                                                        <li>
                                                                <a  href="{$DETAILVIEW_LINKS['DETAILVIEWTAB_TASK'][0]->linkurl}" class="textOverflowEllipsis" displaylabel="task" recordsCount="" >
                                                                        <span class="tab-icon"></span>
                                                                        <span class="tab-label" >
                                                                        <strong>Task</strong>
                                                                        </span>
                                                                </a>
                                                        </li>
                                                {/if}
                                                {if $MORE_TAB_ACTIVE neq 'true'}
                                                        {for $i = 0 to $COUNT-1}
                                                                {assign var=RELATED_LINK value=$RELATEDTABS[$i]}
                                                                {if ($RELATED_LINK->getId() == {$smarty.request.relationId})}
                                                                        {assign var=RELATEDMODULENAME value=$RELATED_LINK->getRelatedModuleName()}
                                                                        {assign var=RELATEDFIELDNAME value=$RELATED_LINK->get('linkFieldName')}
                                                                        {assign var="DETAILVIEWRELATEDLINKLBL" value= vtranslate($RELATED_LINK->getLabel(),$RELATEDMODULENAME)}
                                                                        <li class="more-tab moreTabElement active"  data-url="{$RELATED_LINK->getUrl()}&tab_label={$RELATED_LINK->getLabel()}&app={$SELECTED_MENU_CATEGORY}" data-label-key="{$RELATED_LINK->getLabel()}"
                                                                                data-module="{$RELATEDMODULENAME}" data-relation-id="{$RELATED_LINK->getId()}" {if $RELATEDMODULENAME eq "ModComments"} title {else} title="{$DETAILVIEWRELATEDLINKLBL}"{/if} {if $RELATEDFIELDNAME}data-relatedfield ="{$RELATEDFIELDNAME}"{/if}>
                                                                                <a href="index.php?{$RELATED_LINK->getUrl()}&tab_label={$RELATED_LINK->getLabel()}&app={$SELECTED_MENU_CATEGORY}" class="textOverflowEllipsis" displaylabel="{$DETAILVIEWRELATEDLINKLBL}" recordsCount="" >
                                                                                        {if $RELATEDMODULENAME eq "ModComments"}
                                                                                                <span class="tab-icon"><i class="fa fa-comment"></i></span>
                                                                                        {else}
                                                                                                <span class="tab-icon">
                                                                                                {*     {assign var=RELATED_MODULE_MODEL value=Vtiger_Module_Model::getInstance($RELATEDMODULENAME)}
                                                                                                        {$RELATED_MODULE_MODEL->getModuleIcon()}
                                                                                                        *}
                                                                                                        <strong>{$RELATEDMODULENAME}</strong>
                                                                                                </span>
                                                                                        {/if}
                                                                                        {* &nbsp;<span class="numberCircle hide">0</span>*}
                                                                                </a>
                                                                        </li>
                                                                        {break}
                                                                {/if}
                                                        {/for}
                                                {/if}
                                                {if $COUNT gt $LIMIT}
                                                        <li class="dropdown related-tab-more-element">
                                                                <a href="javascript:void(0)" data-toggle="dropdown" class="dropdown-toggle">
                                                                        <span class="tab-label">
                                                                                <strong>{vtranslate("LBL_MORE",$MODULE_NAME)}</strong> &nbsp; <b class="fa fa-caret-down"></b>
                                                                        </span>
                                                                </a>
                                                                <ul class="dropdown-menu pull-right" id="relatedmenuList">
                                                                        {for $j = $COUNT1 to $COUNT-1}
                                                                                {assign var=RELATED_LINK value=$RELATEDTABS[$j]}
                                                                                {assign var=RELATEDMODULENAME value=$RELATED_LINK->getRelatedModuleName()}
                                                                                {assign var=RELATEDFIELDNAME value=$RELATED_LINK->get('linkFieldName')}
                                                                                {assign var="DETAILVIEWRELATEDLINKLBL" value= vtranslate($RELATED_LINK->getLabel(),$RELATEDMODULENAME)}
                                                                                <li class="more-tab {if (trim($RELATED_LINK->getLabel())== trim($SELECTED_TAB_LABEL)) && ($RELATED_LINK->getId() == $SELECTED_RELATION_ID)}active{/if}" data-url="{$RELATED_LINK->getUrl()}&tab_label={$RELATED_LINK->getLabel()}&app={$SELECTED_MENU_CATEGORY}" data-label-key="{$RELATED_LINK->getLabel()}"
                                                                                        data-module="{$RELATEDMODULENAME}" title="" data-relation-id="{$RELATED_LINK->getId()}" {if $RELATEDFIELDNAME}data-relatedfield ="{$RELATEDFIELDNAME}"{/if}>
                                                                                        <a href="index.php?{$RELATED_LINK->getUrl()}&tab_label={$RELATED_LINK->getLabel()}&app={$SELECTED_MENU_CATEGORY}" displaylabel="{$DETAILVIEWRELATEDLINKLBL}" recordsCount="">
                                                                                                {if $RELATEDMODULENAME eq "ModComments"}
                                                                                                        <span class="tab-icon textOverflowEllipsis">
                                                                                                        <i class="fa fa-comment"></i> &nbsp;<span class="content">{$DETAILVIEWRELATEDLINKLBL}</span>
                                                                                                        </span>
                                                                                                {else}
                                                                                                        {assign var=RELATED_MODULE_MODEL value=Vtiger_Module_Model::getInstance($RELATEDMODULENAME)}
                                                                                                        <span class="tab-icon textOverflowEllipsis">
                                                                                                                {* {$RELATED_MODULE_MODEL->getModuleIcon()} *}
                                                                                                                <span class="content"> &nbsp;{$DETAILVIEWRELATEDLINKLBL}</span>
                                                                                                        </span>
                                                                                                {/if}
                                                                                                {*  &nbsp;<span class="numberCircle hide">0</span> *}
                                                                                        </a>
                                                                                </li>
                                                                        {/for}
                                                                </ul>
                                                        </li>
                                                {/if}
                                                {/if}
                                        {/if}
				</ul>
                              
			</div>

		</nav>
	</div>
	{strip}