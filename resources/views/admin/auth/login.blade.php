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

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #4a5568;
            margin-bottom: 25px;
            font-size: 14.5px;
        }

        .remember-me input {
            width: 16px;
            height: 16px;
            accent-color: #2d55b8;
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

        /* Toaster Styles */
        .toaster-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            max-width: 350px;
        }

        .toaster {
            background: white;
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            transform: translateX(400px);
            opacity: 0;
            transition: all 0.3s ease;
            border-left: 4px solid;
        }

        .toaster.show {
            transform: translateX(0);
            opacity: 1;
        }

        .toaster.success {
            border-left-color: #10b981;
            background-color: #f0fdf4;
        }

        .toaster.error {
            border-left-color: #ef4444;
            background-color: #fef2f2;
        }

        .toaster-icon {
            font-size: 20px;
        }

        .toaster.success .toaster-icon {
            color: #10b981;
        }

        .toaster.error .toaster-icon {
            color: #ef4444;
        }

        .toaster-content {
            flex: 1;
        }

        .toaster-title {
            font-weight: 600;
            margin-bottom: 4px;
            color: #1f2937;
        }

        .toaster-message {
            font-size: 14px;
            color: #6b7280;
        }

        .toaster-close {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            font-size: 18px;
            padding: 0;
            line-height: 1;
        }

        .toaster-close:hover {
            color: #6b7280;
        }

        /* Error state */
        .error {
            border-color: #ef4444 !important;
        }

        .error-message {
            color: #ef4444;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }

        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .loading .login-btn::after {
            content: '';
            width: 16px;
            height: 16px;
            border: 2px solid white;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.8s linear infinite;
            margin-left: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 480px) {
            .login-container {
                max-width: 100%;
            }

            .login-form {
                padding: 25px 20px;
            }

            .toaster-container {
                left: 20px;
                right: 20px;
                max-width: none;
            }
        }
    </style>
</head>
<body>
    <!-- Toaster Container -->
    <div class="toaster-container" id="toasterContainer"></div>

    <!-- Login Form -->
    <div class="login-container">
        <div class="login-header">
            <h1><i class="fas fa-lock"></i> Admin Login</h1>
            <p>Secure access to administrative controls</p>
        </div>

        <form class="login-form" id="adminLoginForm" method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="form-group">
                <label for="admin_login_id">Admin Login ID</label>
                <div class="input-with-icon">
                    <i class="fas fa-user-shield"></i>
                    <input type="text" id="admin_login_id" name="admin_login_id" class="form-control" 
                           placeholder="Enter your admin ID" required value="{{ old('admin_login_id') }}">
                </div>
                @error('admin_login_id')
                    <div class="error-message" style="display: block;">{{ $message }}</div>
                @enderror
                <div class="error-message" id="idError">Please enter a valid admin ID</div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-with-icon">
                    <i class="fas fa-key"></i>
                    <input type="password" id="password" name="password" class="form-control" 
                           placeholder="Enter your password" required>
                </div>
                @error('password')
                    <div class="error-message" style="display: block;">{{ $message }}</div>
                @enderror
                <div class="error-message" id="passwordError">Please enter your password</div>
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>

            <button type="submit" class="login-btn" id="loginBtn">
                <i class="fas fa-sign-in-alt"></i> Login to Dashboard
            </button>
        </form>

        <div class="login-footer">
            <p>Restricted access. Unauthorized attempts are prohibited.</p>
        </div>
    </div>

    <script>
        // DOM Elements
        const loginForm = document.getElementById('adminLoginForm');
        const adminIdInput = document.getElementById('admin_login_id');
        const passwordInput = document.getElementById('password');
        const idError = document.getElementById('idError');
        const passwordError = document.getElementById('passwordError');
        const loginBtn = document.getElementById('loginBtn');
        const toasterContainer = document.getElementById('toasterContainer');

        // Show toaster notification
        function showToaster(type, title, message, duration = 5000) {
            const toaster = document.createElement('div');
            toaster.className = `toaster ${type}`;
            
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            
            toaster.innerHTML = `
                <i class="fas ${icon} toaster-icon"></i>
                <div class="toaster-content">
                    <div class="toaster-title">${title}</div>
                    <div class="toaster-message">${message}</div>
                </div>
                <button class="toaster-close" onclick="this.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            toasterContainer.appendChild(toaster);
            
            // Trigger animation
            setTimeout(() => toaster.classList.add('show'), 10);
            
            // Auto remove after duration
            setTimeout(() => {
                if (toaster.parentElement) {
                    toaster.classList.remove('show');
                    setTimeout(() => {
                        if (toaster.parentElement) {
                            toasterContainer.removeChild(toaster);
                        }
                    }, 300);
                }
            }, duration);
        }

        // Show validation error
        function showValidationError(input, errorElement, message) {
            input.classList.add('error');
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }

        // Clear validation error
        function clearValidationError(input, errorElement) {
            input.classList.remove('error');
            errorElement.style.display = 'none';
        }

        // Show loading state
        function showLoading() {
            loginForm.classList.add('loading');
            loginBtn.disabled = true;
        }

        // Hide loading state
        function hideLoading() {
            loginForm.classList.remove('loading');
            loginBtn.disabled = false;
        }

        // Validate form
        function validateForm() {
            let isValid = true;

            // Clear previous errors
            clearValidationError(adminIdInput, idError);
            clearValidationError(passwordInput, passwordError);

            // Validate Admin ID
            if (!adminIdInput.value.trim()) {
                showValidationError(adminIdInput, idError, 'Please enter admin login ID');
                isValid = false;
            }

            // Validate Password
            if (!passwordInput.value.trim()) {
                showValidationError(passwordInput, passwordError, 'Please enter password');
                isValid = false;
            }

            return isValid;
        }

        // Handle form submission
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!validateForm()) {
                return;
            }

            showLoading();

            try {
                const formData = new FormData(this);
                
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    // Success - redirect to dashboard
                    showToaster('success', 'Success', 'Login successful! Redirecting...', 2000);
                    
                    setTimeout(() => {
                        window.location.href = data.redirect || '/admin/dashboard';
                    }, 2000);
                } else {
                    // Error from server
                    hideLoading();
                    
                    if (data.errors) {
                        // Handle validation errors
                        if (data.errors.admin_login_id) {
                            showValidationError(adminIdInput, idError, data.errors.admin_login_id[0]);
                        }
                        if (data.errors.password) {
                            showValidationError(passwordInput, passwordError, data.errors.password[0]);
                        }
                        if (data.errors.error) {
                            showToaster('error', 'Error', data.errors.error[0]);
                        }
                    } else if (data.message) {
                        showToaster('error', 'Error', data.message);
                    } else {
                        showToaster('error', 'Error', 'Invalid credentials');
                    }
                }
            } catch (error) {
                hideLoading();
                console.error('Login error:', error);
                showToaster('error', 'Error', 'Something went wrong. Please try again.');
            }
        });

        // Clear validation errors on input
        adminIdInput.addEventListener('input', () => clearValidationError(adminIdInput, idError));
        passwordInput.addEventListener('input', () => clearValidationError(passwordInput, passwordError));

        // Check if there are any session errors from Laravel
        document.addEventListener('DOMContentLoaded', function() {
            // Check for Laravel validation errors
            const errorElements = document.querySelectorAll('.error-message[style*="display: block"]');
            if (errorElements.length > 0) {
                // Find the first error message
                const firstError = errorElements[0];
                const errorText = firstError.textContent;
                
                // Show as toaster
                showToaster('error', 'Error', errorText);
                
                // Add error class to corresponding input
                const inputId = firstError.previousElementSibling.querySelector('input').id;
                const input = document.getElementById(inputId);
                if (input) {
                    input.classList.add('error');
                }
            }

            // Check for success message in session (if any)
            @if(session('success'))
                showToaster('success', 'Success', '{{ session('success') }}');
            @endif
        });
    </script>
</body>
</html>