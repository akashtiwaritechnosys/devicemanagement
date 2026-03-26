<!DOCTYPE html>
<html>
<head>
    <title>vTiger CRM - Login</title>
    <link rel="stylesheet" type="text/css" href="themes/softed/style.css">
    <script src="include/js/jquery.js"></script>
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #f9f9f9;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-primary {
            background-color: #007cba;
            color: white;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .error-message {
            color: red;
            margin-top: 10px;
        }
        .success-message {
            color: green;
            margin-top: 10px;
        }
        .hidden {
            display: none;
        }
        .otp-section {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="login-container">
	<h2 style= "color:#509bd4;"><center><u><b>EPSILON CRM LOGIN</center></b></u></h2></br></br>
		<div style="text-align: center;">
    		<img src="test/logo/logo_epsilion.png" alt="Company Logo" style="max-width: 200px; height: 50px;">
			</br></br></br>
		</div>
        
        <form id="loginForm">
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <button type="button" id="sendOtpBtn" class="btn btn-primary">Send OTP</button>
            </div>
            
            <div id="otpSection" class="otp-section hidden">
                <div class="form-group">
                    <label for="otp">Enter OTP:</label>
                    <input type="text" id="otp" name="otp" maxlength="6" placeholder="6-digit OTP">
                </div>
                
                <div class="form-group">
                    <button type="button" id="verifyOtpBtn" class="btn btn-primary">Verify OTP & Login</button>
                    <button type="button" id="resendOtpBtn" class="btn btn-secondary">Resend OTP</button>
                </div>
            </div>
            
            <div id="messageDiv"></div>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            $('#sendOtpBtn, #resendOtpBtn').click(function() {
                var email = $('#email').val();
                
                if (!email) {
                    showMessage('Please enter your email address', 'error');
                    return;
                }
                
                var buttonText = $(this).text();
                $(this).prop('disabled', true).text($(this).is('#sendOtpBtn') ? 'Sending...' : 'Resending...');
                
                $.ajax({
                    url: 'ajax_otp_handler.php',
                    type: 'POST',
                    data: {
                        action: 'send_otp',
                        email: email
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('OTP Response:', response);
                        if (response.success) {
                            showMessage(response.message, 'success');
                            $('#otpSection').removeClass('hidden');
                            $('#email').prop('readonly', true);
                        } else {
                            showMessage(response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', xhr.responseText);
                        console.log('Status:', status);
                        console.log('Error:', error);
                        
                        var errorMessage = 'An error occurred. Please try again.';
                        
                        // Try to parse error response
                        try {
                            var errorResponse = JSON.parse(xhr.responseText);
                            if (errorResponse.message) {
                                errorMessage = errorResponse.message;
                            }
                        } catch (e) {
                            // If response is not JSON, show the raw response for debugging
                            if (xhr.responseText) {
                                errorMessage = 'Server Error: ' + xhr.responseText.substring(0, 200);
                            }
                        }
                        
                        showMessage(errorMessage, 'error');
                    },
                    complete: function() {
                        $('#sendOtpBtn').prop('disabled', false).text('Send OTP');
                        $('#resendOtpBtn').prop('disabled', false).text('Resend OTP');
                    }
                });
            });
            
            $('#verifyOtpBtn').click(function() {
                var email = $('#email').val();
                var otp = $('#otp').val();
                
                if (!otp) {
                    showMessage('Please enter the OTP', 'error');
                    return;
                }
                
                $(this).prop('disabled', true).text('Verifying...');
                
                $.ajax({
                    url: 'ajax_otp_handler.php',
                    type: 'POST',
                    data: {
                        action: 'verify_otp',
                        email: email,
                        otp: otp
                    },
                    dataType: 'json',
                    success: function(response) {
                        //console.log('Verify Response:', response);
                        if (response.success) {
                            showMessage(response.message, 'success');
                            setTimeout(function() {
                                window.location.href = response.redirect;
                            }, 1000);
                        } else {
                            showMessage(response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', xhr.responseText);
                        var errorMessage = 'An error occurred. Please try again.';
                        
                        try {
                            var errorResponse = JSON.parse(xhr.responseText);
                            if (errorResponse.message) {
                                errorMessage = errorResponse.message;
                            }
                        } catch (e) {
                            if (xhr.responseText) {
                                errorMessage = 'Server Error: ' + xhr.responseText.substring(0, 200);
                            }
                        }
                        
                        showMessage(errorMessage, 'error');
                    },
                    complete: function() {
                        $('#verifyOtpBtn').prop('disabled', false).text('Verify OTP & Login');
                    }
                });
            });
            
            function showMessage(message, type) {
                var messageClass = type === 'error' ? 'error-message' : 'success-message';
                $('#messageDiv').html('<div class="' + messageClass + '">' + message + '</div>');
                
                setTimeout(function() {
                    $('#messageDiv').html('');
                }, 10000); // Show message for 10 seconds
            }
        });
    </script>
</body>
</html>