<?php /* Smarty version Smarty-3.1.19, created on 2022-06-11 09:51:58
         compiled from "C:\xampp\htdocs\bemlanother\customerportal\layouts\default\templates\Portal\partials\DetailContentBefore.tpl" */ ?>
<?php /*%%SmartyHeaderCode:144528584762a4499ea0a851-02915499%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eed1c775a7830571589c66561b6885d69023c684' => 
    array (
      0 => 'C:\\xampp\\htdocs\\bemlanother\\customerportal\\layouts\\default\\templates\\Portal\\partials\\DetailContentBefore.tpl',
      1 => 1651513022,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '144528584762a4499ea0a851-02915499',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62a4499ea48874_36244991',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62a4499ea48874_36244991')) {function content_62a4499ea48874_36244991($_smarty_tpl) {?>


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
