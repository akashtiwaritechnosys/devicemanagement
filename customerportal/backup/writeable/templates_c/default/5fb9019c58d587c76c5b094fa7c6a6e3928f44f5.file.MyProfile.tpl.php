<?php /* Smarty version Smarty-3.1.19, created on 2022-05-17 16:20:18
         compiled from "C:\xampp\htdocs\beml\customerportal\layouts\default\templates\Portal\MyProfile.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7660710166283af22594e99-26292875%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5fb9019c58d587c76c5b094fa7c6a6e3928f44f5' => 
    array (
      0 => 'C:\\xampp\\htdocs\\beml\\customerportal\\layouts\\default\\templates\\Portal\\MyProfile.tpl',
      1 => 1651513021,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7660710166283af22594e99-26292875',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19',
  'unifunc' => 'content_6283af2278aa12_69170547',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_6283af2278aa12_69170547')) {function content_6283af2278aa12_69170547($_smarty_tpl) {?>

<div class="container-fluid ng-scope my_profile" ng-controller="PortalProfile_DetailView_Component">

	<div class="row">

		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 " style="border-right:none;">
			<div class="leftEditContent my_profile_left">

				
					<h3>{{'Personal Details'|translate}}</h3>
				<hr class="hrHeader">
				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 leftEditContent" style="min-height:40%;">

						
							<img alt="Contact Picture" style="width:100%;" src="data:{{contactDetails.imagetype}};base64,{{contactDetails.imagedata}}"> 
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 rightEditContent" style="min-height:60%">
						

							<div class="row profile-fields">
								<span class="text-muted col-lg-4 col-md-4 col-sm-4 col-xs-3" translate="First Name"></span>
								<span ng-mouseover="hoverEditIn('contactFirstName')" ng-mouseleave="hoverEditLeave('contactFirstName')" class="text-primary col-lg-8 col-md-8 col-sm-8 col-xs-9">{{contactDetails.firstname}}&nbsp;&nbsp;<i ng-show="hoverEdit['contactFirstName']" class="glyphicon glyphicon-pencil" editable-text="contactDetails.firstname" onbeforesave="saveContactDetails($data,'firstname')" onhide="hoverEditLeave('contactFirstName')"></i></span>
							</div>
							<div class="row profile-fields">
								<span class="text-muted col-lg-4 col-md-4 col-sm-4 col-xs-3" translate="Last Name"></span>
								<span ng-mouseover="hoverEditIn('contactLastName')" ng-mouseleave="hoverEditLeave('contactLastName')" class="text-primary col-lg-8 col-md-8 col-sm-8 col-xs-9">{{contactDetails.lastname}}&nbsp;&nbsp;<i ng-show="hoverEdit['contactLastName']" class="glyphicon glyphicon-pencil"  editable-text="contactDetails.lastname" onbeforesave="saveContactDetails($data,'lastname')" onhide="hoverEditLeave('contactLastName')"></i></span>
							</div>
							<div class="row profile-fields">
								<span class="text-muted col-lg-4 col-md-4 col-sm-4 col-xs-3" translate="Primary Email"></span>
								<span ng-mouseover="hoverEditIn('contactPrimaryEmail')" ng-mouseleave="hoverEditLeave('contactPrimaryEmail')" class="text-primary col-lg-8 col-md-8 col-sm-8 col-xs-9">{{contactDetails.email}}&nbsp;&nbsp;<i ng-show="hoverEdit['contactPrimaryEmail']" class="glyphicon glyphicon-pencil" editable-text="contactDetails.email" onbeforesave="saveContactDetails($data,'email','email')" onhide="hoverEditLeave('contactPrimaryEmail')"></i></span>
							</div>
							<div class="row profile-fields">
								<span class="text-muted col-lg-4 col-md-4 col-sm-4 col-xs-3" translate="Secondary Email"></span>
								<span ng-mouseover="hoverEditIn('contactSecondaryEmail')" ng-mouseleave="hoverEditLeave('contactSecondaryEmail')" class="text-primary col-lg-8 col-md-8 col-sm-8 col-xs-9">{{contactDetails.secondaryemail}}&nbsp;&nbsp;<i ng-show="hoverEdit['contactSecondaryEmail']" class="glyphicon glyphicon-pencil" editable-text="contactDetails.secondaryemail" onbeforesave="saveContactDetails($data,'secondaryemail','email')" onhide="hoverEditLeave('contactSecondaryEmail')"></i></span>
							</div>
							<div class="row profile-fields">
								<span class="text-muted col-lg-4 col-md-4 col-sm-4 col-xs-3" translate="Mobile Phone"></span>
								<span ng-mouseover="hoverEditIn('contactMobilePhone')" ng-mouseleave="hoverEditLeave('contactMobilePhone')" class="text-primary col-lg-8 col-md-8 col-sm-8 col-xs-9">{{contactDetails.mobile}}&nbsp;&nbsp;<i ng-show="hoverEdit['contactMobilePhone']" class="glyphicon glyphicon-pencil" editable-text="contactDetails.mobile" onbeforesave="saveContactDetails($data,'mobile')" onhide="hoverEditLeave('contactMobilePhone')"></i></span>
							</div>
							<div class="row profile-fields">
								<span class="text-muted col-lg-4 col-md-4 col-sm-4 col-xs-3" translate="Office Phone"></span>
								<span ng-mouseover="hoverEditIn('contactOfficePhone')" ng-mouseleave="hoverEditLeave('contactOfficePhone')" class="text-primary col-lg-8 col-md-8 col-sm-8 col-xs-9">{{contactDetails.phone}}&nbsp;&nbsp;<i ng-show="hoverEdit['contactOfficePhone']" class="glyphicon glyphicon-pencil"  editable-text="contactDetails.phone" onbeforesave="saveContactDetails($data,'phone')" onhide="hoverEditLeave('contactOfficePhone')"></i></span>
							</div>

						
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 " style="background:none;border-left:none;">
			<div class="rightEditContent my_profile_right">
				
					<h3>{{'Company Details'|translate}}</h3>
				<hr class="hrHeader">

				<div class="row">
					<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 leftEditContent" style="min-height:40%;">
						
							<img alt="Company Logo" style="width:100%;" src="data:{{accountDetails.imagetype}};base64,{{accountDetails.imagedata}}"> 

					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 rightEditContent" style="min-height:60%">
						
							<div class="row profile-fields">
								<span class="text-muted col-lg-4 col-md-4 col-sm-4 col-xs-3" translate="Name"></span>
								<span ng-mouseover="hoverEditIn('accountName')" ng-mouseleave="hoverEditLeave('accountName')" class="text-primary col-lg-8 col-md-8 col-sm-8 col-xs-9">{{accountDetails.accountname}}&nbsp;&nbsp;<i ng-show="hoverEdit['accountName']" class="glyphicon glyphicon-pencil" editable-text="accountDetails.accountname" onbeforesave="saveOrganizationDetails($data,'accountname')" onhide="hoverEditLeave('accountName')"></i></span>
							</div>
							<div class="row profile-fields">
								<span class="text-muted col-lg-4 col-md-4 col-sm-4 col-xs-3" translate="Website"></span>
								<span ng-mouseover="hoverEditIn('accountWebsite')" ng-mouseleave="hoverEditLeave('accountWebsite')" class="text-primary col-lg-8 col-md-8 col-sm-8 col-xs-9"><a href="{{accountDetails.weburl}}" target="_blank">{{accountDetails.website}}</a><i ng-show="hoverEdit['accountWebsite']" class="glyphicon glyphicon-pencil" editable-text="accountDetails.website" onbeforesave="saveOrganizationDetails($data,'website','weburl')" onhide="hoverEditLeave('accountWebsite')"></i></span>
							</div>
							<div class="row profile-fields">
								<span class="text-muted col-lg-4 col-md-4 col-sm-4 col-xs-3" translate="Email"></span>
								<span ng-mouseover="hoverEditIn('accountEmail')" ng-mouseleave="hoverEditLeave('accountEmail')" class="text-primary col-lg-8 col-md-8 col-sm-8 col-xs-9">{{accountDetails.email1}}&nbsp;&nbsp;<i ng-show="hoverEdit['accountEmail']" class="glyphicon glyphicon-pencil"  editable-text="accountDetails.email1" onbeforesave="saveOrganizationDetails($data,'email1','email')" onhide="hoverEditLeave('accountEmail')"></i></span>
							</div>
							<div class="row profile-fields">
								<span class="text-muted col-lg-4 col-md-4 col-sm-4 col-xs-3" translate="Phone"></span>
								<span ng-mouseover="hoverEditIn('accountPhone')" ng-mouseleave="hoverEditLeave('accountPhone')" class="text-primary col-lg-8 col-md-8 col-sm-8 col-xs-9">{{accountDetails.phone}}&nbsp;&nbsp;<i ng-show="hoverEdit['accountPhone']" class="glyphicon glyphicon-pencil"  editable-text="accountDetails.phone" onbeforesave="saveOrganizationDetails($data,'phone')" onhide="hoverEditLeave('accountPhone')"></i></span>
							</div>
						
					</div>
				</div>
			</div>
		</div>
	</div>

</div>
<?php }} ?>
