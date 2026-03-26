<?php /* Smarty version Smarty-3.1.19, created on 2022-06-11 09:39:56
         compiled from "C:\xampp\htdocs\bemlanother\customerportal\layouts\default\templates\Portal\partials\DetailContent.tpl" */ ?>
<?php /*%%SmartyHeaderCode:115453655362a446cccc07b9-26415417%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2282cbeac910426e471aeea6b2a70119f19b46db' => 
    array (
      0 => 'C:\\xampp\\htdocs\\bemlanother\\customerportal\\layouts\\default\\templates\\Portal\\partials\\DetailContent.tpl',
      1 => 1651513022,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '115453655362a446cccc07b9-26415417',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62a446cccdab04_76913052',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62a446cccdab04_76913052')) {function content_62a446cccdab04_76913052($_smarty_tpl) {?>


    <div ng-class="{'col-lg-5 col-md-5 col-sm-12 col-xs-12 leftEditContent':splitContentView, 'col-lg-12 col-md-12 col-sm-12 col-xs-12 leftEditContent nosplit':!splitContentView}">
        <div class="container-fluid">
            <div class="row">
                <div class="row detailRow" ng-hide="fieldname=='id' || fieldname=='identifierName' || fieldname=='{{header}}' || fieldname=='documentExists' || fieldname=='referenceFields'"  ng-repeat="(fieldname, value) in record">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label class="fieldLabel" translate="{{fieldname}}"> {{fieldname}} </label>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <!-- <span class="label label-default">{{value}}</span> -->
                        <span style="white-space: pre-line;" class="value detail-break">{{value}}</span>
                    </div>
                </div>
                <div class="row detailRow" ng-if="module == 'Documents'">
                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label ng-if="module=='Documents'" class="fieldLabel" translate="Attachments">Attachments</label>
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" ng-if="documentExists">

                        <button class="btn btn-soft-primary" ng-click="downloadFile(module,id,parentId)" title="Download {{record[header]}}">Download</button>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php }} ?>
