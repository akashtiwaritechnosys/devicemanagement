<?php /* Smarty version Smarty-3.1.19, created on 2022-06-11 09:39:56
         compiled from "C:\xampp\htdocs\bemlanother\customerportal\layouts\default\templates\Portal\Detail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:128705959362a446cc657db7-27999824%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c8009ebfaa8895da012c95ba48cb755f78d2743' => 
    array (
      0 => 'C:\\xampp\\htdocs\\bemlanother\\customerportal\\layouts\\default\\templates\\Portal\\Detail.tpl',
      1 => 1651513021,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '128705959362a446cc657db7-27999824',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62a446cc6bc241_28240125',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62a446cc6bc241_28240125')) {function content_62a446cc6bc241_28240125($_smarty_tpl) {?>

<div class="container-fluid" ng-controller="<?php echo portal_componentjs_class($_smarty_tpl->tpl_vars['MODULE']->value,'DetailView_Component');?>
">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php echo $_smarty_tpl->getSubTemplate (portal_template_resolve($_smarty_tpl->tpl_vars['MODULE']->value,"partials/DetailContentBefore.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            <?php echo $_smarty_tpl->getSubTemplate (portal_template_resolve($_smarty_tpl->tpl_vars['MODULE']->value,"partials/DetailContent.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            <?php echo $_smarty_tpl->getSubTemplate (portal_template_resolve($_smarty_tpl->tpl_vars['MODULE']->value,"partials/DetailRelatedContent.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            <?php echo $_smarty_tpl->getSubTemplate (portal_template_resolve($_smarty_tpl->tpl_vars['MODULE']->value,"partials/DetailContentAfter.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        </div>
    </div>
</div>
<hr>
<?php }} ?>
