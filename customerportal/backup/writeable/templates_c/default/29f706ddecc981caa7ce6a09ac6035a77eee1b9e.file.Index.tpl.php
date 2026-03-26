<?php /* Smarty version Smarty-3.1.19, created on 2022-06-11 09:58:44
         compiled from "C:\xampp\htdocs\bemlanother\customerportal\layouts\default\templates\Faq\Index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10420282762a44b34ba2d88-54530164%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '29f706ddecc981caa7ce6a09ac6035a77eee1b9e' => 
    array (
      0 => 'C:\\xampp\\htdocs\\bemlanother\\customerportal\\layouts\\default\\templates\\Faq\\Index.tpl',
      1 => 1651513021,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10420282762a44b34ba2d88-54530164',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62a44b34bfb892_34402124',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62a44b34bfb892_34402124')) {function content_62a44b34bfb892_34402124($_smarty_tpl) {?>

<div class="container-fluid"  ng-controller="<?php echo portal_componentjs_class($_smarty_tpl->tpl_vars['MODULE']->value,'IndexView_Component');?>
">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php echo $_smarty_tpl->getSubTemplate (portal_template_resolve($_smarty_tpl->tpl_vars['MODULE']->value,"partials/IndexContent.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        </div>
    </div>
</div>
<?php }} ?>
