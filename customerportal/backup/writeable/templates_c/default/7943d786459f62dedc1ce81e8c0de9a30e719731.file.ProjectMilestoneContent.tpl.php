<?php /* Smarty version Smarty-3.1.19, created on 2022-05-17 16:21:41
         compiled from "C:\xampp\htdocs\beml\customerportal\layouts\default\templates\Project\partials\ProjectMilestoneContent.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11244252996283af7561cd18-62364605%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7943d786459f62dedc1ce81e8c0de9a30e719731' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beml\\customerportal\\layouts\\default\\templates\\Project\\partials\\ProjectMilestoneContent.tpl',
      1 => 1651513020,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11244252996283af7561cd18-62364605',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_6283af75633279_56638244',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6283af75633279_56638244')) {function content_6283af75633279_56638244($_smarty_tpl) {?>


    <div class="cp-table-container" ng-show="projectmilestonerecords">
        <div class="table-responsive">
            <table class="table table-hover table-condensed table-detailed dataTable no-footer">
                <thead>
                    <tr class="listViewHeaders">
                        <th ng-hide="header=='id'" ng-repeat="header in projectmilestoneheaders" nowrap="" class="medium">
                            <a href="javascript:void(0);" class="listViewHeaderValues" data-nextsortorderval="ASC" data-columnname="{{header}}" translate="{{header}}">{{header}}&nbsp;&nbsp;</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="listViewEntries" ng-repeat="record in projectmilestonerecords">
                        <td ng-hide="header=='id'" ng-repeat="header in projectmilestoneheaders" class="listViewEntryValue medium" nowrap="" style='cursor: pointer;' ng-mousedown="ChangeLocation(record, 'ProjectMilestone')">
                <ng-switch on="record[header].type">
                    <a ng-href="index.php?module=ProjectMilestone&view=Detail&id={{record.id}}"></a>
                    <span ng-switch-default>{{record[header]}}</span>
                </ng-switch>
                </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <a href="" ng-if="!milestonesLoaded && !noMilestones" ng-click="loadProjectMilestonePage(projectMilestonePageNo)">{{'more'|translate}}...</a>
    <p ng-if="milestonesLoaded" class="text-muted">{{'No Milestones'|translate}}</p>
    <p ng-if="!milestonesLoaded && noMilestones" class="text-muted">{{'No more Milestones'|translate}}</p>

<?php }} ?>
