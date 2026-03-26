<?php /* Smarty version Smarty-3.1.19, created on 2022-05-17 16:21:41
         compiled from "C:\xampp\htdocs\beml\customerportal\layouts\default\templates\Project\partials\ProjectTaskContent.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5809437106283af755a1123-29947947%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b686cefe08800922e1f0f80743ffecf1ba848c7d' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beml\\customerportal\\layouts\\default\\templates\\Project\\partials\\ProjectTaskContent.tpl',
      1 => 1651513020,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5809437106283af755a1123-29947947',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_6283af755b8052_84867400',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6283af755b8052_84867400')) {function content_6283af755b8052_84867400($_smarty_tpl) {?>


    <div class="cp-table-container" ng-show="projecttaskrecords">
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-detailed dataTable no-footer">
                <thead>
                    <tr class="listViewHeaders">
                        <th ng-hide="header=='id'" ng-repeat="header in projecttaskheaders" nowrap="" class="medium">
                            <a href="javascript:void(0);" class="listViewHeaderValues" data-nextsortorderval="ASC" data-columnname="{{header}}" translate="{{header}}">{{header}}&nbsp;&nbsp;</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="listViewEntries" ng-repeat="record in projecttaskrecords">
                        <td ng-hide="header=='id'" ng-repeat="header in projecttaskheaders" class="listViewEntryValue medium" nowrap="" style='cursor: pointer;' ng-mousedown="ChangeLocation(record, 'ProjectTask')">
                <ng-switch on="record[header].type">
                    <a ng-href="index.php?module=ProjectTask&view=Detail&id={{record.id}}"></a>
                    <span ng-switch-default>{{record[header]}}</span>
                </ng-switch>
                </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <a ng-if="!tasksLoaded && !noTasks" ng-click="loadProjectTaskPage(projectTaskPageNo)">{{'more'|translate}}...</a>
    <p ng-if="tasksLoaded" class="text-muted">{{'No Tasks'|translate}}</p>
    <p ng-if="!tasksLoaded && noTasks" class="text-muted">{{'No more Tasks'|translate}}</p>

<?php }} ?>
