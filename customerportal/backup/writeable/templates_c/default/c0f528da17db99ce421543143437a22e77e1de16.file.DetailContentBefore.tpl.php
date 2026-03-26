<?php /* Smarty version Smarty-3.1.19, created on 2022-05-17 16:21:41
         compiled from "C:\xampp\htdocs\beml\customerportal\layouts\default\templates\Quotes\partials\DetailContentBefore.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19712609006283af752bcce5-86440042%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c0f528da17db99ce421543143437a22e77e1de16' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beml\\customerportal\\layouts\\default\\templates\\Quotes\\partials\\DetailContentBefore.tpl',
      1 => 1651513021,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19712609006283af752bcce5-86440042',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_6283af752e2232_68944696',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6283af752e2232_68944696')) {function content_6283af752e2232_68944696($_smarty_tpl) {?>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ticket-detail-header-row ">
  <h3 class="fsmall">
    <detail-navigator>
      <span>
        <a ng-click="navigateBack(module)" style="font-size:small;">{{ptitle}}</a>
      </span>
    </detail-navigator>
      {{record[header]}}
    <button ng-if="quoteAccepted" translate="Accept Quote" class="btn btn-soft-success close-ticket" ng-click="acceptQuote();"></button>
  </h3>
</div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  
  <script type="text/javascript" src="<?php echo portal_componentjs_file('Documents');?>
"></script>
  <?php echo $_smarty_tpl->getSubTemplate (portal_template_resolve('Documents',"partials/IndexContentAfter.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }} ?>
