<!--/* +********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * ******************************************************************************* */-->

<!DOCTYPE html>
<html>
  <head>
  <title>Change Password</title>
  <link rel="icon" type="image/x-icon" href="layouts/v7/resources/Images/favicon.png">
    <link
      rel="stylesheet"
      type="text/css"
      href="layouts/v7/resources/commoncrm.css"
    />
    <link
      rel="stylesheet"
      type="text/css"
      href="layouts/v7/resources/root.css"
    />
    <link
      rel="stylesheet"
      type="text/css"
      href="layouts/v7/resources/customcrm.css"
    />

    <style type="text/css">
    body{
        margin:0;
    }
      #page {
        background: url(layouts/v7/resources/Images/login-body.jpg);
        background-position: center;
        background-size: cover;
        width: 100%;
        background-repeat: no-repeat;
        position: relative;
      }
      #page::before {
        content: "";
        background-color: rgb(229 229 229 / 60%);
        width: 100%;
        // height: 100%;
        position: absolute;
        top: 0;
      }

      .main-dashboard-container {
        width: 70%;
        padding: 50px 1px;
        margin: auto;
        border-radius: 10px;
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
        margin: 5px 1px;
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
        width: 93%;
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
        color: var(--text-dark-color);
        transition: all 0.2s ease;
        pointer-events: none;
        background: var(--white-color);
        padding: 2px 7px;
        border-radius: 3px;
        background: transparent;
        font-size: 13px;
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
        background: linear-gradient(
          135deg,
          var(--primary-color) 48%,
          #4e4e4e 45%
        );
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
      #footer {
        float: right;
      }
      #footer p {
        text-align: right;
        margin-right: 20px;
      }
    </style>
  </head>
  <body>
    <div id="page">
      <div class="main-dashboard-container">
        <div class="login-container">
          <div class="login-hero hidden-xs hidden-sm hidden-md">
            <h3 class="hero-title">CRM Doctor</h3>
            <p class="hero-subtitle">
              Streamline your customer relationships and boost your business
              productivity with our powerful CRM solution.
            </p>
            <img
              src="layouts/v7/resources/Images/change-password.svg"
              alt="change password"
              class="hero-image"
            />
          </div>
          <div
            id="container"
            class="login-form-container"
            style="text-align: center"
          >
            <div class="">
              <img
                class="img-responsive user-logo"
                src="{$LOGOURL}"
                alt="{$TITLE}"
              />
            </div>

            {if $LINK_EXPIRED neq 'true'}
            <div id="content">
              <h4 class="form-title">
                {vtranslate('LBL_CHANGE_PASSWORD',$MODULE)}
              </h4>
              <div id="changePasswordBlock">
                <form
                  name="changePassword"
                  id="changePassword"
                  action="{$TRACKURL}"
                  method="post"
                  accept-charset="utf-8"
                >
                  <input type="hidden" name="username" value="{$USERNAME}" />
                  <input
                    type="hidden"
                    name="shorturl_id"
                    value="{$SHORTURL_ID}"
                  />
                  <input
                    type="hidden"
                    name="secret_hash"
                    value="{$SECRET_HASH}"
                  />
                  <div class="group">
                    <input
                      class="form-input"
                      type="password"
                      id="password"
                      name="password"
                      placeholder=""
                    />
                    <label class="input-label" for="password"
                      >{vtranslate('LBL_NEW_PASSWORD',$MODULE)}</label
                    >
                  </div>
                  <div class="group">
                    <input
                      class="form-input"
                      type="password"
                      id="confirmPassword"
                      name="confirmPassword"
                      placeholder=""
                    />
                    <label class="input-label" for="confirmPassword">
                      {vtranslate('LBL_CONFIRM_PASSWORD',$MODULE)}
                    </label>
                  </div>
                  <div class="">
                    <input
                      class="btn button"
                      type="submit"
                      id="btn"
                      value="Change Password"
                      onclick="return checkPassword();"
                    />
                  </div>
                </form>
              </div>
              <div id="footer">
                <p></p>
              </div>
              <div style="clear: both"></div>
            </div>
            {else}
            <div id="content">
              <p>{vtranslate('LBL_PASSWORD_LINK_EXPIRED_OR_INVALID_PASSWORD',
              $MODULE)}</p>
            </div>
            {/if}
          </div>
        </div>
      </div>
    </div>

    <script language="JavaScript">
      function checkPassword() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirmPassword").value;
        if (password == "" && confirmPassword == "") {
          alert("Please enter new Password");
          return false;
        } else if (password != confirmPassword) {
          alert("Password and Confirm Password should be same");
          return false;
        } else {
          return true;
        }
      }
    </script>
  </body>
</html>
