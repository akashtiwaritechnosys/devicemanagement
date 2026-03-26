<?php /* Smarty version Smarty-3.1.19, created on 2023-03-31 17:48:17
         compiled from "C:\xampp\htdocs\beml\customerportal\layouts\default\templates\HelpDesk\partials\IndexContentBefore.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13978827526283857a8397e5-69269415%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4d6ff3c2e95a42e0479088eda374bb8ec596e6de' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beml\\customerportal\\layouts\\default\\templates\\HelpDesk\\partials\\IndexContentBefore.tpl',
      1 => 1680277694,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13978827526283857a8397e5-69269415',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_6283857a83dda0_51424850',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6283857a83dda0_51424850')) {function content_6283857a83dda0_51424850($_smarty_tpl) {?>
    <div class="row portal-controls-row">
        <div class="col-lg-4 col-md-2 col-sm-4 col-xs-5 top_space">
            <div class="btn-group addbtnContainer" ng-if="isCreatable">
                <button type="button" translate= "Add {{igModuleTransLatedLabel}}" class="btn btn-soft-primary" ng-click="create()"></button>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 top_space helpdesk_mobile">
            <div class="row" ng-if="activateStatus">
                <div class="col-xs-12 selectric_mob">
                    <hp-selectric items="ticketStatus" ng-model="searchQ.ticketstatus"></hp-selectric>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-3 col-sm-12 col-xs-12 pagination-holder top_space">
            <div class="pull-right">
                <div class="text-center">
                    <pagination
                            total-items="totalPages" max-size="3" ng-model="currentPage" ng-change="pageChanged(currentPage)" boundary-links="true">
                    </pagination>
                </div>
            </div>
        </div>
    </div>
    <input name="visited" type="hidden" ng-init="beforeRefresh='0'" ng-model="beforeRefresh">

<?php }} ?>
