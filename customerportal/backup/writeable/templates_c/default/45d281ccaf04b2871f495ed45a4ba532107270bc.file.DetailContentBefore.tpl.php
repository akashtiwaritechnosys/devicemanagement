<?php /* Smarty version Smarty-3.1.19, created on 2022-06-23 16:23:27
         compiled from "C:\xampp\htdocs\beml\customerportal\layouts\default\templates\ProjectTask\partials\DetailContentBefore.tpl" */ ?>
<?php /*%%SmartyHeaderCode:60628726462b4775f042485-23285191%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '45d281ccaf04b2871f495ed45a4ba532107270bc' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beml\\customerportal\\layouts\\default\\templates\\ProjectTask\\partials\\DetailContentBefore.tpl',
      1 => 1651513021,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '60628726462b4775f042485-23285191',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62b4775f0a9f01_77231001',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62b4775f0a9f01_77231001')) {function content_62b4775f0a9f01_77231001($_smarty_tpl) {?>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ticket-detail-header-row ">
  <h3 class="fsmall">
    <detail-navigator>
      <span>
        <a ng-click="navigateBack(module)" style="font-size:small;">{{ptitle}}
        </a>
      </span>
      </detail-navigator>
      {{record[header]}}
</div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

<?php }} ?>
