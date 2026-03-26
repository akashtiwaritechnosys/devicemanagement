<?php /* Smarty version Smarty-3.1.19, created on 2022-05-17 13:22:37
         compiled from "C:\xampp\htdocs\beml\customerportal\layouts\default\templates\Documents\partials\IndexContentBefore.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14833988916283857db8cf90-01365671%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '721e7bd9b09ea709954a42399584509b2fb5c7a5' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beml\\customerportal\\layouts\\default\\templates\\Documents\\partials\\IndexContentBefore.tpl',
      1 => 1651513023,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14833988916283857db8cf90-01365671',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_6283857dbb3085_50359465',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6283857dbb3085_50359465')) {function content_6283857dbb3085_50359465($_smarty_tpl) {?>


<div class="navigation-controls-row">
<div ng-if="checkRecordsVisibility(filterPermissions)" class="panel-title col-md-12 module-title">{{ptitle}}
</div>
</div>
    <div class="row portal-controls-row">
      <div ng-if="!checkRecordsVisibility(filterPermissions)" class="panel-title col-md-12 module-title">{{ptitle}}</div>
        <div class="col-lg-3 col-md-3 col-sm-8 col-xs-8 top_space" ng-if="checkRecordsVisibility(filterPermissions)">
            <div class="btn-group btn-group-justified">
                <div class="btn-group">
                    <button type="button"
                            ng-class="{'btn btn-soft-secondary btn-soft-primary':searchQ.onlymine, 'btn btn-soft-secondary':!searchQ.onlymine}" ng-click="searchQ.onlymine=true">{{'Mine' | translate}}</button>
                </div>
                <div class="btn-group">
                    <button type="button"
                            ng-class="{'btn btn-soft-secondary btn-soft-primary':!searchQ.onlymine, 'btn btn-soft-secondary':searchQ.onlymine}" ng-click="searchQ.onlymine=false">{{'All' | translate}}</button>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-8 top_space">
            <div class="btn-group addbtnContainer" ng-if="isCreateable">
                <button type="button" class="btn btn-soft-primary addBtn" ng-click="create()">{{'Add Document' | translate}}</button>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 top_space pagination-holder pull-right">
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
