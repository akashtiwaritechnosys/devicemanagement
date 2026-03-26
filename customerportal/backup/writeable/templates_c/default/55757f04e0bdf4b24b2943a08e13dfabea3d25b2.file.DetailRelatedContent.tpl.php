<?php /* Smarty version Smarty-3.1.19, created on 2022-06-24 08:25:54
         compiled from "C:\xampp\htdocs\beml\customerportal\layouts\default\templates\Portal\partials\DetailRelatedContent.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19545092386283af753c4ae7-11675074%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '55757f04e0bdf4b24b2943a08e13dfabea3d25b2' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beml\\customerportal\\layouts\\default\\templates\\Portal\\partials\\DetailRelatedContent.tpl',
      1 => 1656004261,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19545092386283af753c4ae7-11675074',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_6283af753e80d3_86020412',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6283af753e80d3_86020412')) {function content_6283af753e80d3_86020412($_smarty_tpl) {?>

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
                        <div ng-hide="selection!=='Equipment'"> 
                            <p>Euipment Listing Goes Here</p>
                        </div>
                    </div>
                    </div>
<?php }} ?>
