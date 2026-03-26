<?php /* Smarty version Smarty-3.1.19, created on 2023-03-31 17:53:28
         compiled from "C:\xampp\htdocs\beml\customerportal\layouts\default\templates\Portal\partials\IndexContentBefore.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17213310906283857dc839e0-38668335%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'de70909474369ebe531c8579ee9c2b9166f94ccc' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beml\\customerportal\\layouts\\default\\templates\\Portal\\partials\\IndexContentBefore.tpl',
      1 => 1680278005,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17213310906283857dc839e0-38668335',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_6283857dcbc983_33149512',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6283857dcbc983_33149512')) {function content_6283857dcbc983_33149512($_smarty_tpl) {?>


    <div class="navigation-controls-row">
        <div ng-if="checkRecordsVisibility(filterPermissions)" class="panel-title col-md-12 module-title">{{ptitle}}
        </div>
    </div>
    <div class="row portal-controls-row">
        <div class="col-lg-3 col-md-2 col-sm-4 col-xs-4 top_space">
            <div class="addbtnContainer" ng-if="isCreatable">
                <button class="btn btn-soft-primary" ng-click="createRecord(module)">New {{ptitle}}</button>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 top_space">
            &nbsp;
        </div>
        <div class="col-lg-3 col-md-2 col-sm-12 col-xs-12 top_space">
            <button class="btn btn-soft-primary" ng-if="exportEnabled" ng-csv="exportRecords(module)" csv-header="csvHeaders" add-bom="true" filename="{{filename}}.csv">{{'Export'|translate}}&nbsp;{{ptitle}}</button>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 top_space pagination-holder">
            <div class="pull-right">
                <div class="text-center">
                    <pagination
                            total-items="totalPages" max-size="3" ng-model="currentPage" ng-change="pageChanged(currentPage)" boundary-links="true">
                    </pagination>
                </div>
            </div>
        </div>
    </div>

<?php }} ?>
