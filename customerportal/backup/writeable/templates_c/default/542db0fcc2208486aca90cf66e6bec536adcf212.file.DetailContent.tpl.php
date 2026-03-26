<?php /* Smarty version Smarty-3.1.19, created on 2023-03-31 21:48:01
         compiled from "C:\xampp\htdocs\beml\customerportal\layouts\default\templates\Portal\partials\DetailContent.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1230007186283af75356bb9-31890459%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '542db0fcc2208486aca90cf66e6bec536adcf212' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beml\\customerportal\\layouts\\default\\templates\\Portal\\partials\\DetailContent.tpl',
      1 => 1680292076,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1230007186283af75356bb9-31890459',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_6283af7536ead6_97056819',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6283af7536ead6_97056819')) {function content_6283af7536ead6_97056819($_smarty_tpl) {?>


    <div ng-if="module!='ServiceReports'" ng-class="{'col-lg-5 col-md-5 col-sm-12 col-xs-12 leftEditContent':splitContentView, 'col-lg-12 col-md-12 col-sm-12 col-xs-12 leftEditContent nosplit':!splitContentView}">
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
