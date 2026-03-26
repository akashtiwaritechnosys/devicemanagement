<?php /* Smarty version Smarty-3.1.19, created on 2022-06-11 09:58:55
         compiled from "C:\xampp\htdocs\bemlanother\customerportal\layouts\default\templates\Documents\partials\IndexContentBefore.tpl" */ ?>
<?php /*%%SmartyHeaderCode:105728541062a44b3fa41607-18709474%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b10d314c00ed6ec2bd46e1c282c9dff6a43fc5f5' => 
    array (
      0 => 'C:\\xampp\\htdocs\\bemlanother\\customerportal\\layouts\\default\\templates\\Documents\\partials\\IndexContentBefore.tpl',
      1 => 1651513023,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '105728541062a44b3fa41607-18709474',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62a44b3fa87135_50536691',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62a44b3fa87135_50536691')) {function content_62a44b3fa87135_50536691($_smarty_tpl) {?>


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
