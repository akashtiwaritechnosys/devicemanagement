<?php /* Smarty version Smarty-3.1.19, created on 2022-06-23 16:22:32
         compiled from "C:\xampp\htdocs\beml\customerportal\layouts\default\templates\Project\partials\DetailContentBefore.tpl" */ ?>
<?php /*%%SmartyHeaderCode:160486507262b47728712e81-41451527%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fed69e57ea275f8be366a497a09ba794a92eb7bc' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beml\\customerportal\\layouts\\default\\templates\\Project\\partials\\DetailContentBefore.tpl',
      1 => 1651513020,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '160486507262b47728712e81-41451527',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b4772876aa19_43426862',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b4772876aa19_43426862')) {function content_62b4772876aa19_43426862($_smarty_tpl) {?>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ticket-detail-header-row ">
  <h3 class="fsmall">
    <detail-navigator>
      <span>
        <a ng-click="navigateBack(module)" style="font-size:small;">{{ptitle}}
        </a>
      </span>
    </detail-navigator>
    {{record[header]}}
  <button ng-if="documentsEnabled" translate="Attach document to this project" class="btn btn-soft-primary attach-files-ticket" ng-click="attachDocument('Documents','LBL_ADD_DOCUMENT')"></button></h3>
</div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

<script type="text/javascript" src="<?php echo portal_componentjs_file('Documents');?>
"></script>
<?php echo $_smarty_tpl->getSubTemplate (portal_template_resolve('Documents',"partials/IndexContentAfter.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }} ?>
