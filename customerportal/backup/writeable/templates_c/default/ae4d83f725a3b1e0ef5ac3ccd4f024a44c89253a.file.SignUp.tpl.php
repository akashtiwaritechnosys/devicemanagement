<?php /* Smarty version Smarty-3.1.19, created on 2023-03-06 10:18:11
         compiled from "C:\xampp\htdocs\beml\customerportal\layouts\default\templates\Portal\SignUp.tpl" */ ?>
<?php /*%%SmartyHeaderCode:186627347262835f31404d48-39901015%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ae4d83f725a3b1e0ef5ac3ccd4f024a44c89253a' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beml\\customerportal\\layouts\\default\\templates\\Portal\\SignUp.tpl',
      1 => 1678094288,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '186627347262835f31404d48-39901015',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62835f31446665_71866549',
  'variables' => 
  array (
    'CONTACTBLOCKS' => 0,
    'blockitem' => 0,
    'item' => 0,
    'itemopt' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62835f31446665_71866549')) {function content_62835f31446665_71866549($_smarty_tpl) {?>﻿<script type="text/javascript" src="//code.jquery.com/jquery-2.1.3.js"></script>
    <link rel="stylesheet" href="build/css/intlTelInput.css">
    <link rel="stylesheet" href="build/css/demo.css">
    <style>
        .hide {
            display: none;
        }
        .customer_portal{
        background: url(./layouts/default/skins/images/b2.webp);
        background-size:cover;
        height: 100%;
        }
       
        .form-horizontal .control-label {
             text-align: Left;
        }
        .navbar {
            display : none !important;
        }
        nav.navbar {
        min-height:0px !important
        }
        body{
            background:#def3f3;
            margin-top:-20px;
            
        }
        .iti { width: 100%; }
       
    .mainlogo
    {
        max-width:25%;
         height:auto;
         margin:0px auto;
          }
    .customer_portal_logo
    {
        text-align:center;
        padding-top:20px;
    }
        
    </style>
<div class="container-fluid" ng-controller="SignUp_IndexView_Component">
    <div class="row customer_portal">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">&nbsp;</div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="login-form">
                        <form class="form-horizontal" id="signupform" novalidate="novalidate" ng-submit="makeAutoComplete();doSignUp(signupform)" name="signupform">

                          <div class="customer_portal_logo">
                            <img class="mainlogo" src="../test/logo/logo_beml1.png" class="img-responsive user-logo">
                            </div>

                            <h3 style="text-align:center;" translate="Please Provide Your Following Information For Sign Up">Please Provide Your Following Information For Sign Up</h3>
                            
                            <?php  $_smarty_tpl->tpl_vars['blockitem'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['blockitem']->_loop = false;
 $_smarty_tpl->tpl_vars['blockkey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['CONTACTBLOCKS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['blockitem']->key => $_smarty_tpl->tpl_vars['blockitem']->value) {
$_smarty_tpl->tpl_vars['blockitem']->_loop = true;
 $_smarty_tpl->tpl_vars['blockkey']->value = $_smarty_tpl->tpl_vars['blockitem']->key;
?>
                                <h3 style="text-align: center; text-decoration: underline; background: linear-gradient(to right, #f32170, #ff6b08, #cf23cf, #eedd44);
                                    -webkit-text-fill-color: transparent;
                                    -webkit-background-clip: text;"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['blockitem']->value['label'];?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
</h3>
                                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['blockitem']->value['fields']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                                <div class="form-group">
                                    <?php if ($_smarty_tpl->tpl_vars['item']->value['name']=='assigned_user_id') {?>
                                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['type']['name']=='picklist') {?>
                                        <label for="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>
" class="col-sm-4 control-label"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['label'];?>
<?php $_tmp3=ob_get_clean();?><?php echo $_tmp3;?>
 <span ng-if="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['mandatory'];?>
<?php $_tmp4=ob_get_clean();?><?php echo $_tmp4;?>
" class="text-danger">*</span> </label>
                                        <div class="col-sm-8">
                                        <select id="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp5=ob_get_clean();?><?php echo $_tmp5;?>
" data-field="<?php echo json_encode($_smarty_tpl->tpl_vars['item']->value);?>
" onchange="handleDependency(event)" class="form-control" data-fieldtype="picklist" ng-required="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['mandatory'];?>
<?php $_tmp6=ob_get_clean();?><?php echo $_tmp6;?>
" name="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp7=ob_get_clean();?><?php echo $_tmp7;?>
" ng-model="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp8=ob_get_clean();?><?php echo $_tmp8;?>
"  portal-select>
                                            <?php  $_smarty_tpl->tpl_vars['itemopt'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['itemopt']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['item']->value['type']['picklistValues']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['itemopt']->key => $_smarty_tpl->tpl_vars['itemopt']->value) {
$_smarty_tpl->tpl_vars['itemopt']->_loop = true;
?>
                                                <option value="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['itemopt']->value['value'];?>
<?php $_tmp9=ob_get_clean();?><?php echo $_tmp9;?>
">
                                                    <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['itemopt']->value['label'];?>
<?php $_tmp10=ob_get_clean();?><?php echo $_tmp10;?>

                                                </option>
                                            <?php } ?>
                                        </select>
                                        <span class="text-danger" ng-if="signupform.<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp11=ob_get_clean();?><?php echo $_tmp11;?>
 .$error.required && submit">Please enter a valid  <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['label'];?>
<?php $_tmp12=ob_get_clean();?><?php echo $_tmp12;?>
 .</span>
                                        </div>
                                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['type']['name']=='phone') {?>
                                        <h3 style="text-align: center;background: linear-gradient(to right, #f32170, #ff6b08, #cf23cf, #eedd44);
                                         -webkit-text-fill-color: transparent;
                                         -webkit-background-clip: text;">Enter Your Mobile Number</h3>
                                        <h4 style="text-align: center;margin-top: 1px;margin-bottom: 5px;">(OTP Will Be Sent To Verify your Mobile Number)</h4>
                                        <label for="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp13=ob_get_clean();?><?php echo $_tmp13;?>
" class="col-sm-4 control-label"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['label'];?>
<?php $_tmp14=ob_get_clean();?><?php echo $_tmp14;?>
 <span ng-if="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['mandatory'];?>
<?php $_tmp15=ob_get_clean();?><?php echo $_tmp15;?>
" class="text-danger">*</span> </label>
                                        <div class="col-sm-8">
                                            <input  id="phone" type="tel"  placeholder="" ng-model-options="{updateOn:'blur'}"  class="form-control"  ng-model="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp16=ob_get_clean();?><?php echo $_tmp16;?>
" name="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp17=ob_get_clean();?><?php echo $_tmp17;?>
" ng-required="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['mandatory'];?>
<?php $_tmp18=ob_get_clean();?><?php echo $_tmp18;?>
" autofill="autofill">
                                            <span class="text-danger" ng-if="signupform.<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp19=ob_get_clean();?><?php echo $_tmp19;?>
 .$error.required && submit">Please enter a valid  <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['label'];?>
<?php $_tmp20=ob_get_clean();?><?php echo $_tmp20;?>
 .</span>
                                            <span id="valid-msg" class="hide text-success">Phone Number is valid</span>
                                            <span id="error-msg" class="hide text-danger">Invalid number</span>
                                        </div>
                                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['type']['name']=='password') {?>
                                        <?php if ($_smarty_tpl->tpl_vars['item']->value['name']=='user_password') {?>
                                        <span id="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp21=ob_get_clean();?><?php echo $_tmp21;?>
" <?php if ($_smarty_tpl->tpl_vars['item']->value['initialDisplay']=='no') {?>style="display: none" <?php }?>>
                                            <label for="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp22=ob_get_clean();?><?php echo $_tmp22;?>
" class="col-sm-4 control-label"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['label'];?>
<?php $_tmp23=ob_get_clean();?><?php echo $_tmp23;?>
 <span ng-if="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['mandatory'];?>
<?php $_tmp24=ob_get_clean();?><?php echo $_tmp24;?>
" class="text-danger">*</span> </label>
                                            <div class="col-sm-8">
                                                <input type="password" id="password_1"   ng-model-options="{updateOn:'blur'}"  class="form-control"  ng-model="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp25=ob_get_clean();?><?php echo $_tmp25;?>
" name="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp26=ob_get_clean();?><?php echo $_tmp26;?>
" ng-required="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['mandatory'];?>
<?php $_tmp27=ob_get_clean();?><?php echo $_tmp27;?>
" autofill="autofill">
                                                  <span id="togglePassword1" style="margin-top: -25px ;margin-right:10px;float: right;cursor: pointer;" class="glyphicon glyphicon-eye-open"></span> 
                                                <span class="text-danger" ng-if="signupform.<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp28=ob_get_clean();?><?php echo $_tmp28;?>
 .$error.required && submit">Please enter a valid  <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['label'];?>
<?php $_tmp29=ob_get_clean();?><?php echo $_tmp29;?>
 .</span>
                                            </div>
                                               <label class="col-sm-4 text-muted"><p class="PassStrength"></p></label>
                                        </span>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['name']=='confirm_password') {?>
                                            <span id="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp30=ob_get_clean();?><?php echo $_tmp30;?>
" <?php if ($_smarty_tpl->tpl_vars['item']->value['initialDisplay']=='no') {?>style="display: none" <?php }?>>
                                                <label for="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp31=ob_get_clean();?><?php echo $_tmp31;?>
" class="col-sm-4 control-label"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['label'];?>
<?php $_tmp32=ob_get_clean();?><?php echo $_tmp32;?>
 <span ng-if="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['mandatory'];?>
<?php $_tmp33=ob_get_clean();?><?php echo $_tmp33;?>
" class="text-danger">*</span> </label>
                                                <div class="col-sm-8">
                                                    <input type="password" id="password_2"   ng-model-options="{updateOn:'blur'}"  class="form-control"  ng-model="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp34=ob_get_clean();?><?php echo $_tmp34;?>
" name="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp35=ob_get_clean();?><?php echo $_tmp35;?>
" ng-required="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['mandatory'];?>
<?php $_tmp36=ob_get_clean();?><?php echo $_tmp36;?>
" autofill="autofill">
                                                    <span id="togglePassword2" style="margin-top: -25px ;margin-right:10px;float: right;cursor: pointer;" class="glyphicon glyphicon-eye-open"></span> 
                                                    <span class="text-danger" ng-if="signupform.<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp37=ob_get_clean();?><?php echo $_tmp37;?>
 .$error.required && submit">Please enter a valid  <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['label'];?>
<?php $_tmp38=ob_get_clean();?><?php echo $_tmp38;?>
 .</span>
                                                </div>
                                                <label class="col-sm-4 text-muted"><p class="PassMatch"></p></label> 
                                            </span>
                                        <?php }?>
                                    <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['name']=='email') {?>   
                                          <span id="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp39=ob_get_clean();?><?php echo $_tmp39;?>
" <?php if ($_smarty_tpl->tpl_vars['item']->value['initialDisplay']=='no') {?>style="display: none" <?php }?>>
                                            <label for="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp40=ob_get_clean();?><?php echo $_tmp40;?>
" class="col-sm-4 control-label"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['label'];?>
<?php $_tmp41=ob_get_clean();?><?php echo $_tmp41;?>
 <span ng-if="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['mandatory'];?>
<?php $_tmp42=ob_get_clean();?><?php echo $_tmp42;?>
" class="text-danger">*</span> </label>
                                            <div class="col-sm-8">
                                                <input type="email"  ng-model-options="{updateOn:'blur'}"  class="form-control"  ng-model="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp43=ob_get_clean();?><?php echo $_tmp43;?>
" name="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp44=ob_get_clean();?><?php echo $_tmp44;?>
" ng-required="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['mandatory'];?>
<?php $_tmp45=ob_get_clean();?><?php echo $_tmp45;?>
" autofill="autofill">
                                                <span id="email-error-msg" class="hide text-danger"> Email is not valid</span>
                                                <span class="text-danger" ng-if="signupform.<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp46=ob_get_clean();?><?php echo $_tmp46;?>
 .$error.required && submit">Please enter a valid  <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['label'];?>
<?php $_tmp47=ob_get_clean();?><?php echo $_tmp47;?>
 .</span>
                                            </div>
                                        </span>
                                    <?php } else { ?>
                                        <span id="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp48=ob_get_clean();?><?php echo $_tmp48;?>
" <?php if ($_smarty_tpl->tpl_vars['item']->value['initialDisplay']=='no') {?>style="display: none" <?php }?>>
                                            <label for="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp49=ob_get_clean();?><?php echo $_tmp49;?>
" class="col-sm-4 control-label"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['label'];?>
<?php $_tmp50=ob_get_clean();?><?php echo $_tmp50;?>
 <span ng-if="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['mandatory'];?>
<?php $_tmp51=ob_get_clean();?><?php echo $_tmp51;?>
" class="text-danger">*</span> </label>
                                            <div class="col-sm-8">
                                                <input type="text"  ng-model-options="{updateOn:'blur'}"  class="form-control"  ng-model="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp52=ob_get_clean();?><?php echo $_tmp52;?>
" name="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp53=ob_get_clean();?><?php echo $_tmp53;?>
" ng-required="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['mandatory'];?>
<?php $_tmp54=ob_get_clean();?><?php echo $_tmp54;?>
" autofill="autofill">
                                                <span class="text-danger" ng-if="signupform.<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
<?php $_tmp55=ob_get_clean();?><?php echo $_tmp55;?>
 .$error.required && submit">Please enter a valid  <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['item']->value['label'];?>
<?php $_tmp56=ob_get_clean();?><?php echo $_tmp56;?>
 .</span>
                                            </div>
                                        </span>
                                    <?php }?>
                                </div>
                                <?php } ?>
                            <?php } ?>
                           
                            <div class="form-group" ng-if="loginFailed && !loginForm.username.$error.pattern">
                                <label for="  " class="col-sm-4">
                                </label>
                                <div class="col-sm-8 text-danger">{{loginMessage}}</div>
                            </div>
                              <div class="form-group" ng-if="noUserName">
                                <label ng-hide="loginForm.username.$dirty && loginForm.username.$viewValue!==''" for="  " class="col-sm-4">
                                </label>
                                <div class="col-sm-8 text-danger" ng-hide="loginForm.username.$dirty && loginForm.username.$viewValue!==''">Enter your email address.</div>
                            </div>

                              <div class="form-group" ng-if="noPassword">
                                <label ng-hide="loginForm.username.$invalid && loginForm.username.$viewValue!==''" for="  " class="col-sm-4">
                                </label>
                                <div class="col-sm-8 text-danger" ng-hide="loginForm.username.$invalid && loginForm.username.$viewValue!==''">Enter your password.</div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <button type="submit" translate="Sign Up" class="btn btn-success" style="width: 300px; margin-left: 50px; font-weight: bold;">Sign Up</button>
                                </div>
                            </div>
                        </form>
                        <div>
                            <a href="index.php?module=Portal&view=Login" class="btn btn-info" style="font-weight: bold;">
                                <span class="glyphicon glyphicon-chevron-left"></span> Back to Login
                            </a>
                        </div>
                    </div>
                </div>
                <input id="uidsaver" type="text" hidden>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">&nbsp;</div>
            </div>
        </div>
    </div>
  <script src="build/js/intlTelInput.js"></script>
     <script type="text/javascript" src="layouts/<?php echo portal_layout();?>
/resources/components/signup.js"></script>
</div>

    <script type="text/ng-template" id="askotp.template">
        <div class="modal-header">
            <button type="button" class="close" ng-click="cancel()" title="Close">×</button>
            <h3 class="modal-title">{{'Enter OTP'|translate}}</h3>
        </div>
        <form name="forgotPassword"  class="form-horizontal" role="form">
            <div class="modal-body">
                <div class="form-group">
                    <label class="col-sm-4 control-label">{{'OTP'|translate}}</label>
                    <div class="col-sm-5">
                        <input ng-model="data.email" name="email" class="form-control" required></input>
                        <span class="text-danger"  ng-show="data.email===undefined">Enter a valid email address</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button ng-if="data.email" ng-click="doRealSignUp()" class="btn btn-success" type="submit">{{'Submit'|translate}}</button>
            </div>
        </form>
        <form class="form-horizontal" role="form">
            <div class="modal-body">
                <div id="time">
                    <span>Resend OTP In </span><div id="output">00:00</div>
                </div>
                <div id="resendOtpDiv" style="display:none">
                    <button id="resendOtp" ng-click="handleResendOTP()" class="button buttonBlue crm_btn btn btn-primary">Resend OTP</button><br>
                </div>
            </div>
        </form>
    </script>
<?php }} ?>
