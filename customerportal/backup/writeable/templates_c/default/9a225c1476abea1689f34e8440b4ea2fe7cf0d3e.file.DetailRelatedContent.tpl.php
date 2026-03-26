<?php /* Smarty version Smarty-3.1.19, created on 2022-06-11 09:39:56
         compiled from "C:\xampp\htdocs\bemlanother\customerportal\layouts\default\templates\Portal\partials\DetailRelatedContent.tpl" */ ?>
<?php /*%%SmartyHeaderCode:165721159562a446ccd3f633-54484143%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9a225c1476abea1689f34e8440b4ea2fe7cf0d3e' => 
    array (
      0 => 'C:\\xampp\\htdocs\\bemlanother\\customerportal\\layouts\\default\\templates\\Portal\\partials\\DetailRelatedContent.tpl',
      1 => 1651513022,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '165721159562a446ccd3f633-54484143',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62a446ccd558a6_83428235',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62a446ccd558a6_83428235')) {function content_62a446ccd558a6_83428235($_smarty_tpl) {?>

<div ng-if="splitContentView" class="col-lg-6 col-md-6 col-sm-12 col-xs-12 rightEditContent rightedit_tabs">
    
        <ul tabset class="rightedit_ul">
            <tab ng-repeat="relatedModule in relatedModules" select="selectedTab(relatedModule.name)" ng-if="relatedModule.value" heading={{relatedModule.name}} active="tab.active" disabled="tab.disabled">
                <tab-heading><strong translate="{{relatedModule.uiLabel}}">{{relatedModule.uiLabel}}</strong><tab-heading>
						</ul>
                    
                    <br>
                    <div class="tab-content">
                        <div ng-show="selection==='ModComments'">
                            <?php echo $_smarty_tpl->getSubTemplate ("Portal/partials/CommentContent.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

                        </div>
                        <div ng-hide="selection!=='History'"> 
                            <?php echo $_smarty_tpl->getSubTemplate ("Portal/partials/UpdatesContent.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

                        </div>
                        <div ng-hide="selection!=='ProjectTask'"> 
                            <?php echo $_smarty_tpl->getSubTemplate ("Project/partials/ProjectTaskContent.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

                        </div>
                        <div ng-hide="selection!=='ProjectMilestone'"> 
                            <?php echo $_smarty_tpl->getSubTemplate ("Project/partials/ProjectMilestoneContent.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

                        </div>
                        <div ng-hide="selection!=='Documents'"> 
                            <?php echo $_smarty_tpl->getSubTemplate ("Documents/partials/RelatedDocumentsContent.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

                        </div>
                    </div>
                    </div>
<?php }} ?>
