<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Secure Access</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
        }

        .login-container {
            width: 100%;
            max-width: 450px;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid #e1e8f0;
        }

        .login-header {
            background: linear-gradient(to right, #1a3a8f, #2d55b8);
            color: white;
            padding: 30px 25px;
            text-align: center;
        }

        .login-header h1 {
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .login-header p {
            opacity: 0.9;
            font-size: 15px;
        }

        .login-form {
            padding: 35px 30px;
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #2d3748;
            font-size: 15px;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #718096;
            font-size: 18px;
        }

        .form-control {
            width: 100%;
            padding: 15px 15px 15px 48px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
            background-color: #f8fafc;
        }

        .form-control:focus {
            outline: none;
            border-color: #2d55b8;
            background-color: white;
            box-shadow: 0 0 0 3px rgba(45, 85, 184, 0.1);
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            font-size: 14.5px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #4a5568;
        }

        .remember-me input {
            width: 16px;
            height: 16px;
            accent-color: #2d55b8;
        }

        .forgot-password {
            color: #2d55b8;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-password:hover {
            color: #1a3a8f;
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(to right, #1a3a8f, #2d55b8);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .login-btn:hover {
            background: linear-gradient(to right, #152a6e, #1a3a8f);
            box-shadow: 0 5px 15px rgba(45, 85, 184, 0.2);
        }

        .login-footer {
            text-align: center;
            padding: 20px 0 10px;
            color: #718096;
            font-size: 14px;
            border-top: 1px solid #e2e8f0;
            margin-top: 15px;
        }

        .login-footer a {
            color: #2d55b8;
            text-decoration: none;
            font-weight: 500;
        }

        /* Password Recovery Modal */
        .recovery-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 100;
            justify-content: center;
            align-items: center;
        }

        .recovery-content {
            background-color: white;
            width: 90%;
            max-width: 500px;
            border-radius: 12px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: modalFadeIn 0.3s;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .recovery-header {
            background: linear-gradient(to right, #1a3a8f, #2d55b8);
            color: white;
            padding: 22px 25px;
            position: relative;
        }

        .recovery-header h3 {
            font-size: 22px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .recovery-body {
            padding: 30px;
        }

        .recovery-step {
            display: none;
        }

        .recovery-step.active {
            display: block;
        }

        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }

        .step-indicator::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #e2e8f0;
            z-index: 1;
        }

        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            width: 33.33%;
        }

        .step-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #e2e8f0;
            color: #718096;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-bottom: 8px;
            transition: all 0.3s;
        }

        .step.active .step-circle {
            background-color: #2d55b8;
            color: white;
        }

        .step.completed .step-circle {
            background-color: #10b981;
            color: white;
        }

        .step.completed .step-circle::after {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
        }

        .step-label {
            font-size: 13px;
            font-weight: 500;
            color: #718096;
            text-align: center;
        }

        .step.active .step-label {
            color: #2d55b8;
        }

        .recovery-instructions {
            margin-bottom: 25px;
            color: #4a5568;
            line-height: 1.6;
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 20px;
            background: none;
            border: none;
            color: white;
            font-size: 24px;
            cursor: pointer;
        }

        /* OTP Input Styling */
        .otp-container {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 25px;
        }

        .otp-input {
            width: 50px;
            height: 60px;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            background-color: #f8fafc;
            transition: all 0.3s;
        }

        .otp-input:focus {
            border-color: #2d55b8;
            background-color: white;
            outline: none;
            box-shadow: 0 0 0 3px rgba(45, 85, 184, 0.1);
        }

        .otp-input.filled {
            border-color: #2d55b8;
            background-color: white;
        }

        .resend-otp {
            text-align: center;
            margin-top: 15px;
            font-size: 14.5px;
            color: #718096;
        }

        .resend-otp a {
            color: #2d55b8;
            text-decoration: none;
            font-weight: 500;
        }

        .resend-otp a:hover {
            text-decoration: underline;
        }

        /* Password Strength Indicator */
        .password-strength {
            margin-top: 8px;
            height: 6px;
            background-color: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0;
            border-radius: 3px;
            transition: width 0.3s, background-color 0.3s;
        }

        .strength-text {
            font-size: 13px;
            margin-top: 5px;
            display: block;
        }

        .password-requirements {
            margin-top: 15px;
            padding-left: 20px;
            font-size: 13.5px;
            color: #718096;
        }

        .password-requirements li {
            margin-bottom: 5px;
            position: relative;
        }

        .password-requirements li.valid {
            color: #10b981;
        }

        .password-requirements li.valid::before {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            left: -20px;
            color: #10b981;
        }

        /* Success message */
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            border: 1px solid #c3e6cb;
            display: none;
        }

        /* Error state */
        .error {
            border-color: #e53e3e !important;
        }

        .error-message {
            color: #e53e3e;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }

        .step-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .btn-secondary {
            padding: 12px 20px;
            background-color: #e2e8f0;
            color: #4a5568;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background-color: #cbd5e0;
        }

        .timer {
            font-weight: 600;
            color: #2d55b8;
        }

        @media (max-width: 480px) {
            .login-container {
                max-width: 100%;
            }

            .login-form {
                padding: 25px 20px;
            }

            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .otp-container {
                gap: 8px;
            }

            .otp-input {
                width: 45px;
                height: 55px;
                font-size: 22px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <h1><i class="fas fa-lock"></i> Admin Login</h1>
            <p>Secure access to administrative controls</p>
        </div>

        <form class="login-form" id="adminLoginForm">
            <div class="form-group">
                <label for="adminId">Admin Login ID</label>
                <div class="input-with-icon">
                    <i class="fas fa-user-shield"></i>
                    <input type="text" id="adminId" class="form-control" placeholder="Enter your admin ID" required>
                </div>
                <div class="error-message" id="idError">Please enter a valid admin ID</div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-with-icon">
                    <i class="fas fa-key"></i>
                    <input type="password" id="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <div class="error-message" id="passwordError">Please enter your password</div>
            </div>

            <div class="remember-forgot">
                <div class="remember-me">
                    <input type="checkbox" id="rememberMe">
                    <label for="rememberMe">Remember me</label>
                </div>
                <a href="#" class="forgot-password" id="forgotPasswordLink">Forgot Password?</a>
            </div>

            <button type="submit" class="login-btn">
                <i class="fas fa-sign-in-alt"></i> Login to Dashboard
            </button>

            <div class="success-message" id="loginSuccess">
                <i class="fas fa-check-circle"></i> Login successful! Redirecting to admin dashboard...
            </div>
        </form>

        <div class="login-footer">
            <p>Restricted access. Unauthorized attempts are prohibited.</p>
        </div>
    </div>

    <!-- Password Recovery Modal with Multi-Step Flow -->
    <div class="recovery-modal" id="recoveryModal">
        <div class="recovery-content">
            <div class="recovery-header">
                <h3><i class="fas fa-key"></i> Password Recovery</h3>
                <button class="close-modal" id="closeModal">&times;</button>
            </div>
            <div class="recovery-body">
                <!-- Step Indicator -->
                <div class="step-indicator">
                    <div class="step active" id="step1">
                        <div class="step-circle">1</div>
                        <div class="step-label">Enter Email</div>
                    </div>
                    <div class="step" id="step2">
                        <div class="step-circle">2</div>
                        <div class="step-label">Verify OTP</div>
                    </div>
                    <div class="step" id="step3">
                        <div class="step-circle">3</div>
                        <div class="step-label">New Password</div>
                    </div>
                </div>

                <!-- Step 1: Email Entry -->
                <div class="recovery-step active" id="step1Content">
                    <p class="recovery-instructions">
                        Enter your registered email address to receive a One-Time Password (OTP) for password reset.
                    </p>

                    <div class="form-group">
                        <label for="recoveryEmail">Email Address</label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="recoveryEmail" class="form-control" placeholder="Enter your email address">
                        </div>
                        <div class="error-message" id="emailError">Please enter a valid email address</div>
                    </div>

                    <button class="login-btn" id="sendOTPBtn">
                        <i class="fas fa-paper-plane"></i> Send OTP
                    </button>
                </div>

                <!-- Step 2: OTP Verification -->
                <div class="recovery-step" id="step2Content">
                    <p class="recovery-instructions">
                        We've sent a 6-digit OTP to <span id="userEmail" class="timer">your email</span>.
                        Enter it below to verify your identity.
                    </p>

                    <div class="otp-container" id="otpContainer">
                        <input type="text" maxlength="1" class="otp-input" data-index="0">
                        <input type="text" maxlength="1" class="otp-input" data-index="1">
                        <input type="text" maxlength="1" class="otp-input" data-index="2">
                        <input type="text" maxlength="1" class="otp-input" data-index="3">
                        <input type="text" maxlength="1" class="otp-input" data-index="4">
                        <input type="text" maxlength="1" class="otp-input" data-index="5">
                    </div>

                    <div class="error-message" id="otpError">Please enter a valid 6-digit OTP</div>

                    <div class="resend-otp">
                        Didn't receive the OTP?
                        <a href="#" id="resendOTPLink">Resend OTP</a>
                        <span id="resendTimer">(<span id="timerCount">60</span>s)</span>
                    </div>

                    <div class="step-actions">
                        <button class="btn-secondary" id="backToEmailBtn">
                            <i class="fas fa-arrow-left"></i> Back
                        </button>
                        <button class="login-btn" id="verifyOTPBtn">
                            <i class="fas fa-check-circle"></i> Verify OTP
                        </button>
                    </div>
                </div>

                <!-- Step 3: New Password -->
                <div class="recovery-step" id="step3Content">
                    <p class="recovery-instructions">
                        Create a new secure password for your admin account.
                    </p>

                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="newPassword" class="form-control" placeholder="Enter new password">
                        </div>
                        <div class="password-strength">
                            <div class="strength-bar" id="strengthBar"></div>
                        </div>
                        <span class="strength-text" id="strengthText"></span>

                        <div class="password-requirements">
                            <p>Password must contain:</p>
                            <ul>
                                <li id="reqLength">At least 8 characters</li>
                                <li id="reqUppercase">One uppercase letter</li>
                                <li id="reqLowercase">One lowercase letter</li>
                                <li id="reqNumber">One number</li>
                                <li id="reqSpecial">One special character</li>
                            </ul>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Confirm New Password</label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm new password">
                        </div>
                        <div class="error-message" id="confirmPasswordError">Passwords do not match</div>
                    </div>

                    <div class="step-actions">
                        <button class="btn-secondary" id="backToOTPBtn">
                            <i class="fas fa-arrow-left"></i> Back
                        </button>
                        <button class="login-btn" id="resetPasswordBtn">
                            <i class="fas fa-key"></i> Reset Password
                        </button>
                    </div>
                </div>

                <!-- Success Message -->
                <div class="success-message" id="recoverySuccess">
                    <i class="fas fa-check-circle"></i> Password reset successful! You can now login with your new password.
                </div>
            </div>
        </div>
    </div>

    <script>
        // DOM Elements
        const loginForm = document.getElementById('adminLoginForm');
        const adminIdInput = document.getElementById('adminId');
        const passwordInput = document.getElementById('password');
        const idError = document.getElementById('idError');
        const passwordError = document.getElementById('passwordError');
        const loginSuccess = document.getElementById('loginSuccess');
        const forgotPasswordLink = document.getElementById('forgotPasswordLink');
        const recoveryModal = document.getElementById('recoveryModal');
        const closeModal = document.getElementById('closeModal');

        // Recovery Step Elements
        const step1 = document.getElementById('step1');
        const step2 = document.getElementById('step2');
        const step3 = document.getElementById('step3');
        const step1Content = document.getElementById('step1Content');
        const step2Content = document.getElementById('step2Content');
        const step3Content = document.getElementById('step3Content');

        // Step 1 Elements
        const recoveryEmail = document.getElementById('recoveryEmail');
        const emailError = document.getElementById('emailError');
        const sendOTPBtn = document.getElementById('sendOTPBtn');
        const userEmail = document.getElementById('userEmail');

        // Step 2 Elements
        const otpInputs = document.querySelectorAll('.otp-input');
        const otpError = document.getElementById('otpError');
        const verifyOTPBtn = document.getElementById('verifyOTPBtn');
        const resendOTPLink = document.getElementById('resendOTPLink');
        const resendTimer = document.getElementById('resendTimer');
        const timerCount = document.getElementById('timerCount');
        const backToEmailBtn = document.getElementById('backToEmailBtn');

        // Step 3 Elements
        const newPassword = document.getElementById('newPassword');
        const confirmPassword = document.getElementById('confirmPassword');
        const confirmPasswordError = document.getElementById('confirmPasswordError');
        const resetPasswordBtn = document.getElementById('resetPasswordBtn');
        const backToOTPBtn = document.getElementById('backToOTPBtn');
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');

        // Password requirement elements
        const reqLength = document.getElementById('reqLength');
        const reqUppercase = document.getElementById('reqUppercase');
        const reqLowercase = document.getElementById('reqLowercase');
        const reqNumber = document.getElementById('reqNumber');
        const reqSpecial = document.getElementById('reqSpecial');

        // Success message
        const recoverySuccess = document.getElementById('recoverySuccess');

        // State variables
        let currentStep = 1;
        let otpSent = '';
        let timerInterval;
        let canResendOTP = false;
        let passwordValid = false;
        let passwordsMatch = false;

        // Login form validation and submission
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            let isValid = true;

            // Reset error states
            adminIdInput.classList.remove('error');
            passwordInput.classList.remove('error');
            idError.style.display = 'none';
            passwordError.style.display = 'none';
            loginSuccess.style.display = 'none';

            // Validate Admin ID
            if (!adminIdInput.value.trim()) {
                adminIdInput.classList.add('error');
                idError.style.display = 'block';
                isValid = false;
            }

            // Validate Password
            if (!passwordInput.value.trim()) {
                passwordInput.classList.add('error');
                passwordError.style.display = 'block';
                isValid = false;
            }

            // If form is valid, simulate login
            if (isValid) {
                // Show success message
                loginSuccess.style.display = 'block';

                // In a real application, you would send the data to a server here
                console.log('Login attempt with:', {
                    adminId: adminIdInput.value,
                    password: passwordInput.value,
                    rememberMe: document.getElementById('rememberMe').checked
                });

                // Simulate redirect to admin dashboard after 2 seconds
                setTimeout(() => {
                    alert('Redirecting to admin dashboard... (This is a demo)');
                    // In a real application: window.location.href = '/admin-dashboard';
                }, 2000);
            }
        });

        // Forgot password functionality
        forgotPasswordLink.addEventListener('click', function(e) {
            e.preventDefault();
            resetRecoveryForm();
            recoveryModal.style.display = 'flex';
        });

        // Close modal
        closeModal.addEventListener('click', function() {
            recoveryModal.style.display = 'none';
        });

        // Close modal when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target === recoveryModal) {
                recoveryModal.style.display = 'none';
            }
        });

        // Send OTP
        sendOTPBtn.addEventListener('click', function() {
            // Reset error
            recoveryEmail.classList.remove('error');
            emailError.style.display = 'none';

            // Validate email
            const email = recoveryEmail.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!email || !emailRegex.test(email)) {
                recoveryEmail.classList.add('error');
                emailError.style.display = 'block';
                return;
            }

            // Store email for display
            userEmail.textContent = email;

            // Generate a 6-digit OTP (in a real app, this would come from your backend)
            otpSent = generateOTP();
            console.log(`OTP for ${email}: ${otpSent}`); // For demo purposes

            // Move to step 2
            goToStep(2);

            // Start resend timer
            startOTPTimer();
        });

        // Verify OTP
        verifyOTPBtn.addEventListener('click', function() {
            // Get OTP from inputs
            let enteredOTP = '';
            otpInputs.forEach(input => {
                enteredOTP += input.value;
            });

            // Validate OTP
            if (enteredOTP.length !== 6 || enteredOTP !== otpSent) {
                otpError.style.display = 'block';
                otpInputs.forEach(input => {
                    input.classList.add('error');
                });
                return;
            }

            // Clear error
            otpError.style.display = 'none';
            otpInputs.forEach(input => {
                input.classList.remove('error');
            });

            // Move to step 3
            goToStep(3);
        });

        // Reset Password
        resetPasswordBtn.addEventListener('click', function() {
            // Validate passwords
            if (!passwordValid) {
                newPassword.classList.add('error');
                return;
            }

            if (newPassword.value !== confirmPassword.value) {
                confirmPasswordError.style.display = 'block';
                confirmPassword.classList.add('error');
                return;
            }

            // Show success message
            recoverySuccess.style.display = 'block';

            // In a real application, you would send the new password to the server here
            console.log('Password reset for:', recoveryEmail.value);
            console.log('New password:', newPassword.value);

            // After 3 seconds, close modal and reset form
            setTimeout(() => {
                recoveryModal.style.display = 'none';
                resetRecoveryForm();

                // Show success message on login form
                loginSuccess.textContent = 'Password reset successful! You can now login with your new password.';
                loginSuccess.style.display = 'block';
                setTimeout(() => {
                    loginSuccess.style.display = 'none';
                }, 5000);
            }, 3000);
        });

        // OTP Input handling
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', function() {
                // Remove error styling
                this.classList.remove('error');
                otpError.style.display = 'none';

                // Auto-focus next input
                if (this.value.length === 1 && index < 5) {
                    otpInputs[index + 1].focus();
                }

                // Add filled class
                if (this.value.length === 1) {
                    this.classList.add('filled');
                } else {
                    this.classList.remove('filled');
                }
            });

            // Handle paste
            input.addEventListener('paste', function(e) {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').trim();

                if (/^\d{6}$/.test(pastedData)) {
                    // Fill all inputs with pasted OTP
                    for (let i = 0; i < 6; i++) {
                        otpInputs[i].value = pastedData[i];
                        otpInputs[i].classList.add('filled');
                    }
                    otpInputs[5].focus();
                }
            });

            // Handle backspace
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });

        // Resend OTP
        resendOTPLink.addEventListener('click', function(e) {
            e.preventDefault();

            if (!canResendOTP) return;

            // Generate new OTP
            otpSent = generateOTP();
            console.log(`New OTP: ${otpSent}`); // For demo purposes

            // Clear OTP inputs
            otpInputs.forEach(input => {
                input.value = '';
                input.classList.remove('filled', 'error');
            });

            // Focus first input
            otpInputs[0].focus();

            // Reset timer
            startOTPTimer();
        });

        // Navigation between steps
        backToEmailBtn.addEventListener('click', function() {
            goToStep(1);
        });

        backToOTPBtn.addEventListener('click', function() {
            goToStep(2);
        });

        // Password validation
        newPassword.addEventListener('input', validatePassword);
        confirmPassword.addEventListener('input', validatePasswordMatch);

        // Functions
        function resetRecoveryForm() {
            // Reset all steps
            currentStep = 1;
            goToStep(1);

            // Clear inputs
            recoveryEmail.value = '';
            otpInputs.forEach(input => {
                input.value = '';
                input.classList.remove('filled', 'error');
            });
            newPassword.value = '';
            confirmPassword.value = '';

            // Clear errors
            recoveryEmail.classList.remove('error');
            emailError.style.display = 'none';
            otpError.style.display = 'none';
            newPassword.classList.remove('error');
            confirmPassword.classList.remove('error');
            confirmPasswordError.style.display = 'none';
            recoverySuccess.style.display = 'none';

            // Reset password requirements
            resetPasswordRequirements();

            // Clear timer
            if (timerInterval) clearInterval(timerInterval);
            resendTimer.style.display = 'inline';
            canResendOTP = false;
        }

        function goToStep(step) {
            // Update current step
            currentStep = step;

            // Update step indicator
            step1.classList.remove('active', 'completed');
            step2.classList.remove('active', 'completed');
            step3.classList.remove('active', 'completed');

            // Hide all step content
            step1Content.classList.remove('active');
            step2Content.classList.remove('active');
            step3Content.classList.remove('active');

            // Show current step and mark previous steps as completed
            if (step === 1) {
                step1.classList.add('active');
                step1Content.classList.add('active');
            } else if (step === 2) {
                step1.classList.add('completed');
                step2.classList.add('active');
                step2Content.classList.add('active');
                otpInputs[0].focus();
            } else if (step === 3) {
                step1.classList.add('completed');
                step2.classList.add('completed');
                step3.classList.add('active');
                step3Content.classList.add('active');
                newPassword.focus();
            }
        }

        function generateOTP() {
            // Generate a 6-digit random OTP
            return Math.floor(100000 + Math.random() * 900000).toString();
        }

        function startOTPTimer() {
            let timeLeft = 60;
            timerCount.textContent = timeLeft;
            resendTimer.style.display = 'inline';
            canResendOTP = false;
            resendOTPLink.style.pointerEvents = 'none';
            resendOTPLink.style.opacity = '0.5';

            if (timerInterval) clearInterval(timerInterval);

            timerInterval = setInterval(() => {
                timeLeft--;
                timerCount.textContent = timeLeft;

                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    resendTimer.style.display = 'none';
                    canResendOTP = true;
                    resendOTPLink.style.pointerEvents = 'auto';
                    resendOTPLink.style.opacity = '1';
                }
            }, 1000);
        }

        function validatePassword() {
            const password = newPassword.value;

            // Reset all requirement indicators
            resetPasswordRequirements();

            // Check each requirement
            const hasLength = password.length >= 8;
            const hasUppercase = /[A-Z]/.test(password);
            const hasLowercase = /[a-z]/.test(password);
            const hasNumber = /\d/.test(password);
            const hasSpecial = /[!@#$%^&*(),.?":{}|<>]/.test(password);

            // Update requirement indicators
            if (hasLength) reqLength.classList.add('valid');
            if (hasUppercase) reqUppercase.classList.add('valid');
            if (hasLowercase) reqLowercase.classList.add('valid');
            if (hasNumber) reqNumber.classList.add('valid');
            if (hasSpecial) reqSpecial.classList.add('valid');

            // Calculate password strength
            let strength = 0;
            let strengthColor = '#e53e3e'; // Red
            let strengthLabel = 'Weak';

            if (hasLength) strength += 20;
            if (hasUppercase) strength += 20;
            if (hasLowercase) strength += 20;
            if (hasNumber) strength += 20;
            if (hasSpecial) strength += 20;

            // Update strength bar and text
            strengthBar.style.width = strength + '%';

            if (strength <= 40) {
                strengthColor = '#e53e3e'; // Red
                strengthLabel = 'Weak';
            } else if (strength <= 80) {
                strengthColor = '#d69e2e'; // Yellow
                strengthLabel = 'Moderate';
            } else {
                strengthColor = '#38a169'; // Green
                strengthLabel = 'Strong';
            }

            strengthBar.style.backgroundColor = strengthColor;
            strengthText.textContent = `Strength: ${strengthLabel}`;
            strengthText.style.color = strengthColor;

            // Check if all requirements are met
            passwordValid = hasLength && hasUppercase && hasLowercase && hasNumber && hasSpecial;

            // Update input styling
            if (password && !passwordValid) {
                newPassword.classList.add('error');
            } else {
                newPassword.classList.remove('error');
            }

            // Also validate password match
            validatePasswordMatch();
        }

        function validatePasswordMatch() {
            const password = newPassword.value;
            const confirm = confirmPassword.value;

            if (confirm && password !== confirm) {
                confirmPasswordError.style.display = 'block';
                confirmPassword.classList.add('error');
                passwordsMatch = false;
            } else {
                confirmPasswordError.style.display = 'none';
                confirmPassword.classList.remove('error');
                passwordsMatch = true;
            }
        }

        function resetPasswordRequirements() {
            reqLength.classList.remove('valid');
            reqUppercase.classList.remove('valid');
            reqLowercase.classList.remove('valid');
            reqNumber.classList.remove('valid');
            reqSpecial.classList.remove('valid');

            strengthBar.style.width = '0';
            strengthText.textContent = '';
        }

        // Demo credentials suggestion
        window.addEventListener('load', function() {
            // In a real application, you wouldn't pre-fill credentials
            // This is just for demo purposes
            if (window.location.href.includes('demo=true')) {
                adminIdInput.value = 'admin@example.com';
                passwordInput.value = 'Admin@123';
                document.getElementById('rememberMe').checked = true;
            }
        });
    </script>
</body>

</html>