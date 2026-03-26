<?php /* Smarty version Smarty-3.1.19, created on 2022-06-11 08:58:15
         compiled from "C:\xampp\htdocs\bemlanother\customerportal\layouts\default\templates\Portal\Login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:152474630162a43d07a3f4c0-38941978%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '92f05a1b0caeb996a44c8a869e5374b716b76958' => 
    array (
      0 => 'C:\\xampp\\htdocs\\bemlanother\\customerportal\\layouts\\default\\templates\\Portal\\Login.tpl',
      1 => 1654096700,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '152474630162a43d07a3f4c0-38941978',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62a43d07b98446_30683981',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62a43d07b98446_30683981')) {function content_62a43d07b98446_30683981($_smarty_tpl) {?>﻿

<style>
    /*.carousel*/
    /*.carousel-inner .item img */
    .customer_portal{
        background-color: white;
        height: 100%;
    }
    .login_title{
        margin: 50px 0;
    }
    .login-form{
        margin: auto;
        max-width: 450px;
        padding: 6.25rem 2rem!important;
        border-radius: 4px;
        box-shadow: 0 0 10px grey;
        margin-bottom: 20px;
    }
    .login_title h1 {
        font-weight: bold;
        margin-bottom: 30px;
    }
    .customer_portal_logo img{
        margin: auto;
        padding-bottom: 25px;
    }
    .customer_portal_logo p{
        padding-bottom: 25px;
    }
    .customer_portal .login-form .form-horizontal .control-label {
        text-align: left;
        padding-bottom: 10px;
        padding-top: 10px;
    }
    .buttonBlue {
        background-color: #5671f0;
    }
    .mr_top{
        margin: 15px 0;
    }
    .mr_top button{
        line-height: 25px;
        font-size: 15px;
        width: 100%;
    }
    .forgot-password{
        float: none;
    }
    #customerCarousel {
        margin-top: 100px;
    }
    @media only screen and (max-width: 991px){
        .login_title h1 {
            font-size: 20px;
            line-height: 1.5;
        }
    }

</style>
<div class="container-fluid">
    <div class="row customer_portal">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 login_title">
            <h1 class="text-center">Credilio CUSTOMER PORTAL</h1>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" >
                    <div class="login-form">
                        <form class="form-horizontal" novalidate="novalidate" ng-submit="makeAutoComplete();login(loginForm.$valid)" name="loginForm">

                            <div class="customer_portal_logo">
                                <img src="https://3.7.71.53/beml/test/logo/logo_beml1.png" class="img-responsive user-logo">
                                <p class="text-muted mb-4 mt-3 auto_text text-center">Welcome to Customer Complaint Handling Solutions Portal </p>
                            </div>

                            <div class="form-group">
                                <label for="Email" translate="User Name" class="col-sm-12 control-label">User Name</label>
                                <div class="col-sm-12">
                                    <input type="text" ng-model-options="{updateOn:'blur'}"  class="form-control"  ng-model="username" name="username" ng-required="true" autofill="autofill">
                                    <span class="text-danger" ng-if="loginForm.username.$error.pattern">Please enter a valid email address.</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="Password" translate="Password" class="col-sm-12 control-label">Password</label>
                                <div class="col-sm-12">
                                    <input type="password" class="form-control"  ng-model="password" name="password" ng-required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="language" translate="Language" class="col-sm-12 control-label">Language</label>
                                <div class="col-sm-12">
                                    <select name="language" ng-model="language" ng-change="setLanguage(language)"  class="select form-control" placeholder="Language">
                                        <option value="en_us">US English</option>
                                        <option value="de_de">DE Deutsch</option>
                                        <option value="pt_br">PT Brasil</option>
                                        <option value="fr_fr">Francais</option>
                                        <option value="tr_tr">Turkce Dil Paketi</option>
                                        <option value="es_es">ES Spanish</option>
                                        <option value="nl_nl">NL-Dutch</option>
                                        <option value="zh_cn">简体中文</option>
                                        <option value="zh_tw">繁體中文</option>
                                    </select>
                                </div>
                            </div>
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
                                <div class=" col-sm-12 mr_top">
                                    <button type="submit" translate="Sign in" class="btn btn-primary buttonBlue ">Sign in</button>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <p>
                                    <a href="#" class="text-info forgot-password col-sm-12" ng-click="forgotPassword()">
                                        {{'Forgot password?' | translate}}
                                    </a>
                                </p>
                               <p>
                                   <a href="index.php?module=Portal&view=SignUp" class="text-info col-sm-12">Register Now</a>
                               </p>

                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                    <div id="customerCarousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <li data-target="#customerCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#customerCarousel" data-slide-to="1"></li>
                            
                            
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <div class="item active">
                                <img src="https://3.7.71.53/beml/test/logo/slider/BEML_CRM_SLIDES_SR.jpg" alt="Los Angeles">
                            </div>
                            <div class="item">
                                <img src="https://3.7.71.53/beml/test/logo/slider/BEML_CRM_CCH.jpg" alt="Los Angeles">
                            </div>

                            
                            
                            

                            
                            
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

    <script type="text/ng-template" id="forgotPassword.template">
        <div class="modal-header">
        <button type="button" class="close" ng-click="cancel()" title="Close">×</button>
        <h3 class="modal-title">{{'Forgot Password'|translate}}</h3>
        </div>
        <form name="forgotPassword"  ng-submit="updatePassword()" class="form-horizontal" role="form">
        <div class="modal-body">
        <div class="form-group">
        <label class="col-sm-4 control-label">{{'E-mail'|translate}}</label>
        <div class="col-sm-5">
        <input ng-model="data.email" name="email" ng-pattern='/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/' type="email" class="form-control" required></input>
        <span class="text-danger"  ng-show="data.email===undefined">Enter a valid email address</span>
        </div>
        </div>
        </div>
        <div class="modal-footer">
          <button ng-if="data.email" class="btn btn-soft-success" type="submit">{{'Submit'|translate}}</button>
        </div>
      </form>
    </script>

<?php }} ?>
