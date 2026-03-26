<?php /* Smarty version Smarty-3.1.19, created on 2023-03-06 10:17:17
         compiled from "C:\xampp\htdocs\beml\customerportal\layouts\default\templates\Portal\Login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:136189019562837466d082d6-38281457%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '35e9b4a9ec9377365c774f0faf1685813c0b4fb3' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beml\\customerportal\\layouts\\default\\templates\\Portal\\Login.tpl',
      1 => 1678094230,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '136189019562837466d082d6-38281457',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_62837466d32232_32040621',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_62837466d32232_32040621')) {function content_62837466d32232_32040621($_smarty_tpl) {?>﻿

<style>
    /*.carousel*/
    /*.carousel-inner .item img */
    .customer_portal{
        background: url(./layouts/default/skins/images/b1.jpg);
        background-size:cover;
        height: 100%;
    }
    .login_title{
        margin: 50px 0;
    }
    .login-form{
        margin: auto;
        max-width: 450px;
        padding-top:5px;
        padding-bottom:5px;
        border-radius: 4px;
        box-shadow: 0 0 10px grey;
    }
    .login_title h1 {
        font-weight: bold;
        margin-bottom: 30px;
        margin-left: 100px;
    }
    .gradient-text {
  /* Fallback: Set a background color. */
  background-color: #CA4246;
  
  /* Create the gradient. */
   background-image: linear-gradient(
        45deg,
        #CA4246 16.666%, 
        #E16541 16.666%, 
        #E16541 33.333%, 
        #F18F43 33.333%, 
        #F18F43 50%, 
        #8B9862 50%, 
        #8B9862 66.666%, 
        #476098 66.666%, 
        #476098 83.333%, 
        #A7489B 83.333%);
  
  /* Set the background size and repeat properties. */
  background-size: 100%;
  background-repeat: repeat;

  /* Use the text as a mask for the background. */
  /* This will show the gradient as a text color rather than element bg. */
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent; 
  
  /* Animate the text when loading the element. */
    /* This animates it on page load and when hovering out. */
    animation: rainbow-text-simple-animation-rev 0.75s ease forwards;

}

.gradient-text:hover{
    animation: rainbow-text-simple-animation 0.5s ease-in forwards;
}


/* Move the background and make it smaller. */
/* Animation shown when entering the page and after the hover animation. */
@keyframes rainbow-text-simple-animation-rev {
    0% {
        background-size: 650%;
    }
    40% {
        background-size: 650%;
    }
    100% {
        background-size: 100%;
    }
}

/* Move the background and make it larger. */
/* Animation shown when hovering over the text. */
@keyframes rainbow-text-simple-animation {
    0% {
        background-size: 100%;
    }
    80% {
        background-size: 650%;
    }
    100% {
        background-size: 650%;
    }
}
  
    .customer_portal_logo img{
        margin: auto;
        padding:
        padding-bottom: 25px;
    }
    .customer_portal_logo p{
        margin-top:20px;
        margin-bottom:10px;
    }
    .customer_portal .login-form .form-horizontal .control-label {
        text-align: left;
        padding-bottom: 3px;
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
        margin-top: 40px;
    }
    nav.navbar {
        min-height:0px !important
        }
        body{
            background:#fff;
            margin-top:-30px;
            overflow : hidden;
        }
    
        .login_title h1 {
            font-size: 40px;
            line-height: 1.5;  
            margin-top:0px;
            margin-bottom:0px;         
        }

</style>
<div class="container-fluid">
    <div class="row customer_portal">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 login_title">
            <h1 class="gradient-text text-center">&nbsp&nbsp&nbsp&nbsp&nbspBEML CCHS CUSTOMER PORTAL</h1>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">

                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" >
                    <div class="login-form">
                        <form class="form-horizontal" novalidate="novalidate" ng-submit="makeAutoComplete();login(loginForm.$valid)" name="loginForm">

                            <div class="customer_portal_logo">
                                <img src="../test/logo/logo_beml1.png" class="img-responsive user-logo">
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
                                <img src="../test/logo/slider/BEML_CRM_SLIDES_SR.jpg" alt="Los Angeles">
                            </div>
                            <div class="item">
                                <img src="../test/logo/slider/BEML_CRM_CCH.jpg" alt="Los Angeles">
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
