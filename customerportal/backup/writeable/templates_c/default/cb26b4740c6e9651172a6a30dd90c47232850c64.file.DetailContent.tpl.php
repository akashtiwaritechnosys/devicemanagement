<?php /* Smarty version Smarty-3.1.19, created on 2023-04-04 12:07:10
         compiled from "C:\xampp\htdocs\beml\customerportal\layouts\default\templates\HelpDesk\partials\DetailContent.tpl" */ ?>
<?php /*%%SmartyHeaderCode:153213299562c81ee3aaffb5-81043681%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cb26b4740c6e9651172a6a30dd90c47232850c64' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beml\\customerportal\\layouts\\default\\templates\\HelpDesk\\partials\\DetailContent.tpl',
      1 => 1680602053,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '153213299562c81ee3aaffb5-81043681',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62c81ee3af0c48_53848018',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62c81ee3af0c48_53848018')) {function content_62c81ee3af0c48_53848018($_smarty_tpl) {?>
    <div ng-class="{'col-lg-5 col-md-5 col-sm-12 col-xs-12 leftEditContent':splitContentView, 'col-lg-12 col-md-12 col-sm-12 col-xs-12 leftEditContent nosplit':!splitContentView}">
        <div class="container-fluid">
            <div class="row">
                <div class="row detailRow" ng-repeat="(blockname, blockInfo) in moduleFieldGroups">
                    <h4><b>{{blockInfo.blocklabel}}</b></h4>
                    <div class="row detailRow" ng-repeat="(fieldname, fieldInfo) in blockInfo.fields">
                        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                            <label class="fieldLabel" style="word-break: break-word !important;" translate="{{fieldInfo.label}}"> {{fieldInfo.label}} </label>
                        </div>
                        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                            <span style="white-space: pre-line;" class="value detail-break">{{fieldInfo.fieldValue}}</span>
                        </div>
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
