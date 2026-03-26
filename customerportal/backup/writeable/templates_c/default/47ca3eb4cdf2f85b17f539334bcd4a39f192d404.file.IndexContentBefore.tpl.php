<?php /* Smarty version Smarty-3.1.19, created on 2022-06-11 08:37:13
         compiled from "C:\xampp\htdocs\bemlanother\customerportal\layouts\default\templates\HelpDesk\partials\IndexContentBefore.tpl" */ ?>
<?php /*%%SmartyHeaderCode:191942158762a438199d2da2-55027668%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '47ca3eb4cdf2f85b17f539334bcd4a39f192d404' => 
    array (
      0 => 'C:\\xampp\\htdocs\\bemlanother\\customerportal\\layouts\\default\\templates\\HelpDesk\\partials\\IndexContentBefore.tpl',
      1 => 1651513023,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '191942158762a438199d2da2-55027668',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62a43819a0c743_02018744',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62a43819a0c743_02018744')) {function content_62a43819a0c743_02018744($_smarty_tpl) {?>


    <div class="navigation-controls-row">
        <div ng-if="checkRecordsVisibility(filterPermissions)" class="panel-title col-md-12 module-title">{{ptitle}}
        </div>
    </div>
    <div class="row portal-controls-row">
        <div class="col-lg-2 col-md-2 col-sm-8 col-xs-7 top_space">
            <div ng-if="!checkRecordsVisibility(filterPermissions)" class="panel-title col-md-12 module-title">{{ptitle}}</div>
            <div class="btn-group btn-group-justified" ng-if="checkRecordsVisibility(filterPermissions)">
                <div class="btn-group">
                    <button type="button" translate="Mine"
                            ng-class="{'btn btn-soft-secondary btn-soft-primary':searchQ.onlymine, 'btn btn-soft-secondary':!searchQ.onlymine}" ng-click="searchQ.onlymine=true">Mine</button>
                </div>
                <div class="btn-group">
                    <button type="button" translate="All"
                            ng-class="{'btn btn-soft-secondary btn-soft-primary':!searchQ.onlymine, 'btn btn-soft-secondary':searchQ.onlymine}" ng-click="searchQ.onlymine=false">All</button>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-5 top_space">
            <div class="btn-group addbtnContainer" ng-if="isCreatable">
                <button type="button" translate= "New Ticket" class="btn btn-soft-primary" ng-click="create()"></button>
            </div>
        </div>
        <!--<div class="hidden-md hidden-lg" style="height: 20px;"></div>-->
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 top_space helpdesk_mobile">
            <div class="row" ng-if="activateStatus">
                <div class="col-xs-12 selectric_mob">
                    <hp-selectric items="ticketStatus" ng-model="searchQ.ticketstatus"></hp-selectric>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 top_space">
            <button ng-if="records" class="btn btn-soft-primary" ng-csv="exportRecords(module)" csv-header="csvHeaders" add-bom="true" filename="{{filename}}.csv">{{'Export'|translate}}&nbsp;{{ptitle}}</button>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 pagination-holder top_space">
            <div class="pull-right">
                <div class="text-center">
                    <pagination
                            total-items="totalPages" max-size="3" ng-model="currentPage" ng-change="pageChanged(currentPage)" boundary-links="true">
                    </pagination>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="table-header" ng-show="pageInitialized"><h4>Tickets {{searchQ.type}</h4></div> -->
    <input name="visited" type="hidden" ng-init="beforeRefresh='0'" ng-model="beforeRefresh">

<?php }} ?>
