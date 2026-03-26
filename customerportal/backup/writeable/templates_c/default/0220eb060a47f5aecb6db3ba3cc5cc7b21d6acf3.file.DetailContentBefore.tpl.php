<?php /* Smarty version Smarty-3.1.19, created on 2022-05-17 16:49:06
         compiled from "C:\xampp\htdocs\beml\customerportal\layouts\default\templates\Portal\partials\DetailContentBefore.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12385642936283b5e289ac98-56127906%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0220eb060a47f5aecb6db3ba3cc5cc7b21d6acf3' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beml\\customerportal\\layouts\\default\\templates\\Portal\\partials\\DetailContentBefore.tpl',
      1 => 1651513022,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12385642936283b5e289ac98-56127906',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_6283b5e28f2460_29446760',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6283b5e28f2460_29446760')) {function content_6283b5e28f2460_29446760($_smarty_tpl) {?>


    <div class="col-lg-12 col-md-12 col-sm-7 col-xs-7 detail-header detail-header-row">
      <h3 class="fsmall">
        <detail-navigator>
          <span>
            <a ng-click="navigateBack(module)" style="font-size:small;">{{ptitle}}
            </a>
            </span>
        </detail-navigator>{{record[header]}}
        <button ng-if="isEditable" class="btn btn-soft-primary attach-files-ticket" ng-click="editRecord(module,id)">{{'Edit'|translate}} {{ptitle}}</button>
      </h3>
    </div>
</div>

<hr class="hrHeader">
<div class="container-fluid">

<?php }} ?>
