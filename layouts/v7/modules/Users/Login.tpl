{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{* modules/Users/views/Login.php *}

{strip}

	<style>
	body {
	  background: url(layouts/v7/resources/Images/login-body.jpg); 
		// background: url("");
		background-position: center;
		background-size: cover;
		width: 100%;
		background-repeat: no-repeat;
		position: relative;
	}
	body::before {
		content: '';
		background: rgb(229 229 229 / 60%);
		width: 100%;
		height: 100vh;
		position: absolute;
		top: 0;
	}
	#page {
		padding-top: 0px;
		padding-bottom: 0px;
	}
	.main-dashboard-content {
		width: 70% !important;
		padding: 0 !important;
		position: relative !important;
		right: 0 !important;
		margin: auto;
		border-radius: 10px;
		display: flex;
		justify-content: center;
		align-items: center;
		text-align: center;
		min-height: 100vh;
		flex-direction: column;
		max-width: 1000px;
	}
	.blockLink {
		border: 1px solid var(--border-light-color);
		padding: 3px 5px;
	}
	.inActiveImgDiv {
		padding: 5px;
		text-align: center;
		margin: 30px 0px;
	}
	.app-footer p {
		margin-top: 0px;
	}
	.footer {
		background-color: var(--white-color);
		height: 26px;
	}
	.mCSB_container {
		height: inherit;
	}
	.widgetHeight {
		text-align: center;
	}

/* ============== login page starts here ================= */
.dashBoardContainer,
.loginPageContainer {
  min-height: calc(100vh - 110px);
}


.login-container {
  display: flex;
  max-width: 100%;
  width: 100%;
  background: var(--white-color);
  border-radius: 10px;
 box-shadow: #7367f0 0px 5px 15px;
  overflow: hidden;
}
.login-form-container {
  flex: 1;
  padding: 20px;
  /* display: flex;
  flex-direction: column;
  justify-content: center; */
}
select {
  font-size: 16px;
}
.button {
  position: relative;
  display: inline-block;
  padding: 12px 9px;
  margin: 0.3em 0 1em 0;
  width: 100%;
  vertical-align: middle;
  font-size: 16px;
  line-height: 20px;
  -webkit-font-smoothing: antialiased;
  text-align: center;
  letter-spacing: 1px;
  cursor: pointer;
  transition: all 0.4s ease;
}
.button:focus {
  outline: 0;
}
.button:hover {
  transform: translateY(-5px);
}
.forgotPasswordLink {
  color: var(--text-dark-color);
  font-size: 14px;
  &:hover {
    color: var(--primary-color);
  }
}
.ripples {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
  background: transparent;
}

/* //Animations */
@keyframes inputHighlighter {
  from {
    background: #4a89dc;
  }
  to {
    width: 0;
    background: transparent;
  }
}
@keyframes ripples {
  0% {
    opacity: 0;
  }
  25% {
    opacity: 1;
  }
  100% {
    width: 200%;
    padding-bottom: 200%;
    opacity: 0;
  }
}

.user-logo {
  width: 190px;
  margin: 12px auto;
  margin-bottom: 35px;
}
.group {
  position: relative;
  margin: 20px 0px 30px;
}
.failureMessage {
  color: var(--red-text-color);
  display: block;
  text-align: center;
  padding: 10px 0;
  font-size: 14px;
  margin-bottom: 35px;
  border-radius: 6px;
  background-color: var(--red-light-bg-color);
}
.successMessage {
  color: var(--text-dark-color);
  display: block;
  text-align: center;
  padding: 10px 0;
  font-size: 14px;
  margin-bottom: 30px;
  border-radius: 6px;
  background-color: var(--bg-success);
}

.form-title {
  color: var(--text-dark-color);
}
.form-subtitle {
  color: var(--text-light-color);
  margin-bottom: 30px;
}

.input-group {
  margin-bottom: 25px;
  position: relative;
  float: none;
  min-width: 388px;
}
.form-input {
  width: 100%;
  padding: 16px 15px;
  border: 1px solid var(--border-light-color);
  border-radius: 5px;
  font-size: 15px;
  -webkit-appearance: none;
  display: block;
  transition: all 0.3s ease;
  background-color: var(--white-color) !important;
}

.input-label {
  position: absolute;
  left: 12px;
  top: 13px;
  color: var(--dark-gray);
  transition: all 0.2s ease;
  pointer-events: none;
  background: var(--white-color);
  padding: 2px 7px;
  border-radius: 3px;
  background: transparent;
  font-size: 14px;
}

.form-input:focus + .input-label,
.form-input:not(:placeholder-shown) + .input-label {
  top: -16px;
  left: 2px;
  color: var(--primary-color);
  background: var(--white-color);
  border-color: var(--primary-color);
  outline: none;
  box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
}
.form-input:focus {
  border-color: var(--primary-color);
  outline: none;
  box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
}

.login-hero {
  flex: 1;
  background: linear-gradient(135deg, var(--primary-color) 46.5%, #4e4e4e 45%);
  color: var(--white-color);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 20px;
  text-align: center;
}
.hero-title {
  margin-bottom: 15px;
}
.hero-subtitle {
  margin-bottom: 30px;
  max-width: 350px;
  color: var(--white-color-3);
}
.hero-image {
  width: 100%;
  max-width: 300px;
}
.password-group .toggle-password {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: var(--dark-gray);
    font-size: 16px;
    transition: color 0.3s ease;
    display: none;
}
.password-group .toggle-password:hover {
    color: var(--primary-color);
}

/* login page ends here  */

	</style>

	<span class="app-nav"></span>
	<div class="login-container">
		<div class="login-hero hidden-xs hidden-sm hidden-md">
			<h3 class="hero-title">CRM Doctor</h3>
			<p class="hero-subtitle">Streamline your customer relationships and boost your business productivity with our powerful CRM solution.</p>
			<img src="layouts/v7/resources/Images/login-hero.svg" alt="CRM Illustration" class="hero-image">
			
		</div>

		<div class="login-form-container">
			<div class="loginDiv widgetHeight">
				<img class="img-responsive user-logo" src="layouts/v7/resources/Images/crm-logo.png">
				
				<h4 class="form-title">Welcome Back</h4>
				<p class="form-subtitle">Please enter your credentials to signin</p>
				<div>
					<span class="{if !$ERROR}hide{/if} failureMessage" id="validationMessage">{$MESSAGE}</span>
					<span class="{if !$MAIL_STATUS}hide{/if} successMessage">{$MESSAGE}</span>
				</div>

				<div id="loginFormDiv">
					<form class="form-horizontal" method="POST" action="index.php">
						<input type="hidden" name="module" value="Users"/>
						<input type="hidden" name="action" value="Login"/>
						<div class="group">
							<input id="username" class="form-input" type="text" name="username" placeholder="">
							<label class="input-label">Username</label>
						</div>
						<div class="group password-group">
							<input id="password" class="form-input" type="password" name="password" placeholder="">
							<label class="input-label">Password</label>
							<span class="toggle-password" id="togglePassword"><i class="fa fa-eye"></i></span>
						</div>

						{assign var="CUSTOM_SKINS" value=Vtiger_Theme::getAllSkins()}
						{if !empty($CUSTOM_SKINS)}
						<div class="group" style="margin-bottom: 10px;">
							<select id="skin" name="skin" placeholder="Skin" style="text-transform: capitalize; width:100%;height:30px;">
								<option value="">Default Skin</option>
								{foreach item=CUSTOM_SKIN from=$CUSTOM_SKINS}
								<option value="{$CUSTOM_SKIN}">{$CUSTOM_SKIN}</option>
								{/foreach}
							</select>
						</div>
						{/if}
					<div class="">
							<button type="submit" class="btn button">Sign in</button>
							<a class="forgotPasswordLink">forgot password?</a>
						</div>
					</form>
				</div>

				<div id="forgotPasswordDiv" class="hide">
					<form class="form-horizontal" action="forgotPassword.php" method="POST">
						<div class="group">
							<input id="fusername" class="form-input" type="text" name="username" placeholder="" >
							<label class="input-label">Username</label>
						</div>
						<div class="group">
							<input id="email" class="form-input" type="email" name="emailId" placeholder="" >
							<label class="input-label">Email</label>
						</div>
						<div class="">
							<button type="submit" class="btn button forgot-submit-btn">Submit</button>
							<span>Please enter details and submit<a class="forgotPasswordLink pull-right">Back to signin</a></span>
						</div>
					</form>
				</div>
			</div>
		</div>

		{* <div class="col-lg-1 hidden-xs hidden-sm hidden-md">
			<div class="separatorDiv"></div>
		</div> *}

		

		<script>
			jQuery(document).ready(function () {
				var validationMessage = jQuery('#validationMessage');
				var forgotPasswordDiv = jQuery('#forgotPasswordDiv');

				var loginFormDiv = jQuery('#loginFormDiv');
				loginFormDiv.find('#password').focus();

				loginFormDiv.find('a').click(function () {
					loginFormDiv.toggleClass('hide');
					forgotPasswordDiv.toggleClass('hide');
					validationMessage.addClass('hide');
				});

				forgotPasswordDiv.find('a').click(function () {
					loginFormDiv.toggleClass('hide');
					forgotPasswordDiv.toggleClass('hide');
					validationMessage.addClass('hide');
				});

				loginFormDiv.find('button').on('click', function () {
					var username = loginFormDiv.find('#username').val();
					var password = jQuery('#password').val();
					var result = true;
					var errorMessage = '';
					if (username === '') {
						errorMessage = 'Please enter valid username';
						result = false;
					} else if (password === '') {
						errorMessage = 'Please enter valid password';
						result = false;
					}
					if (errorMessage) {
						validationMessage.removeClass('hide').text(errorMessage);
					}
					return result;
				});

				forgotPasswordDiv.find('button').on('click', function () {
					var username = jQuery('#forgotPasswordDiv #fusername').val();
					var email = jQuery('#email').val();

					var email1 = email.replace(/^\s+/, '').replace(/\s+$/, '');
					var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/;
					var illegalChars = /[\(\)\<\>\,\;\:\\\"\[\]]/;

					var result = true;
					var errorMessage = '';
					if (username === '') {
						errorMessage = 'Please enter valid username';
						result = false;
					} else if (!emailFilter.test(email1) || email == '') {
						errorMessage = 'Please enter valid email address';
						result = false;
					} else if (email.match(illegalChars)) {
						errorMessage = 'The email address contains illegal characters.';
						result = false;
					}
					if (errorMessage) {
						validationMessage.removeClass('hide').text(errorMessage);
					}
					return result;
				});
				jQuery('input').blur(function (e) {
					var currentElement = jQuery(e.currentTarget);
					if (currentElement.val()) {
						currentElement.addClass('used');
					} else {
						currentElement.removeClass('used');
					}
				});

				var ripples = jQuery('.ripples');
				ripples.on('click.Ripples', function (e) {
					jQuery(e.currentTarget).addClass('is-active');
				});

				ripples.on('animationend webkitAnimationEnd mozAnimationEnd oanimationend MSAnimationEnd', function (e) {
					jQuery(e.currentTarget).removeClass('is-active');
				});
				loginFormDiv.find('#username').focus();

				var slider = jQuery('.bxslider').bxSlider({
					auto: true,
					pause: 4000,
					nextText: "",
					prevText: "",
					autoHover: true
				});
				jQuery('.bx-prev, .bx-next, .bx-pager-item').live('click',function(){ slider.startAuto(); });
				jQuery('.bx-wrapper .bx-viewport').css('background-color', 'transparent');
				jQuery('.bx-wrapper .bxslider li').css('text-align', 'left');
				jQuery('.bx-wrapper .bx-pager').css('bottom', '-40px');

				var params = {
					theme		: 'dark-thick',
					setHeight	: '100%',
					advanced	:	{
										autoExpandHorizontalScroll:true,
										setTop: 0
									}
				};
				jQuery('.scrollContainer').mCustomScrollbar(params);
			});

			jQuery(document).ready(function () {
			var passwordInput = jQuery('#password');
			var toggleIcon = jQuery('#togglePassword');

			// Show Eye icon only when typing
			passwordInput.on('input', function() {
			if (passwordInput.val().length > 0) {
			toggleIcon.show();
			} else {
			toggleIcon.hide();
			}
			});

			// Press & Hold to show password
			toggleIcon
			.on('mousedown touchstart', function () {
			passwordInput.attr('type', 'text');
			toggleIcon.find('i').removeClass('fa-eye').addClass('fa-eye-slash');
			})
			.on('mouseup mouseleave touchend', function () {
			passwordInput.attr('type', 'password');
			toggleIcon.find('i').removeClass('fa-eye-slash').addClass('fa-eye');
			});
});
		</script>
		</div>
	{/strip}
