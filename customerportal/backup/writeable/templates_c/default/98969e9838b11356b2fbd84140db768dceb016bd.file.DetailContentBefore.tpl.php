<?php /* Smarty version Smarty-3.1.19, created on 2022-06-11 09:39:56
         compiled from "C:\xampp\htdocs\bemlanother\customerportal\layouts\default\templates\HelpDesk\partials\DetailContentBefore.tpl" */ ?>
<?php /*%%SmartyHeaderCode:203590168462a446cc77cd14-10664356%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '98969e9838b11356b2fbd84140db768dceb016bd' => 
    array (
      0 => 'C:\\xampp\\htdocs\\bemlanother\\customerportal\\layouts\\default\\templates\\HelpDesk\\partials\\DetailContentBefore.tpl',
      1 => 1651513023,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '203590168462a446cc77cd14-10664356',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62a446cc7b64e6_37308031',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62a446cc7b64e6_37308031')) {function content_62a446cc7b64e6_37308031($_smarty_tpl) {?>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ticket-detail-header-row ">
  <div class="col-lg-6 col-md-5 col-sm-4 col-xs-12">
    <h3 class="fsmall">
      <detail-navigator>
      <span>
        <a ng-click="navigateBack(module)" style="font-size:small;">{{ptitle}}</a>
      </span>
      </detail-navigator>

      {{record[header]}}
    </h3>
  </div>
  <div class="col-lg-6 col-md-7 col-sm-8 col-xs-12 top_space_helpdesk">
    <button ng-if="(closeButtonDisabled && HelpDeskIsStatusEditable && isEditable)" translate="Mark as closed" class="btn btn-soft-success close-ticket" ng-click="close();"></button>
    <button ng-if="closeButtonDisabled && documentsEnabled" translate="Attach document to this ticket" class="btn btn-soft-primary attach-files-ticket" ng-click="attachDocument('Documents','LBL_ADD_DOCUMENT')"></button>
    <button translate="Edit Ticket" class="btn btn-soft-primary attach-files-ticket" ng-if="isEditable" ng-click="edit(module,id)"></button>

  </div>


</div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  
  <script type="text/javascript" src="<?php echo portal_componentjs_file('Documents');?>
"></script>
  <?php echo $_smarty_tpl->getSubTemplate (portal_template_resolve('Documents',"partials/IndexContentAfter.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }} ?>
