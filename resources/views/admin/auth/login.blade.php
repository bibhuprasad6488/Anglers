@extends('admin.layouts.guest')
@section('title', 'Login')
@section('content')
    <style>
        :root {
            --primary-color: #000;
            --secondary-color: #6c757d;
            --primary-hover: #3f505f;
            --bg-color: linear-gradient(30deg, #00060d, #3f505f);
            --card-bg: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --error-color: #dc2626;
            --border-color: #cbd5e1;
            --input-focus: #2563eb;
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            /* font-family: 'Roboto', sans-serif; */
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: var(--card-bg);
            padding: 40px;
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            transition: transform 0.3s ease;
        }

        /*
            .bg-secondar {
                background: var(--secondary-color);
            } */

        header {
            text-align: center;
            margin-bottom: 32px;
        }

        header h1 {
            font-size: 24px;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        header p {
            font-size: 14px;
            color: var(--text-muted);
        }

        /* Floating Labels Logic */
        .form-group {
            position: relative;
            margin-bottom: 24px;
        }

        .input-control {
            width: 100%;
            height: 56px;
            padding: 20px 16px 6px;
            font-size: 16px;
            border: 1px solid var(--border-color);
            border-radius: 0 !important;
            outline: none;
            background: transparent;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .input-control:focus {
            border-color: var(--input-focus);
            border-width: 2px;
        }

        .floating-label {
            position: absolute;
            left: 16px;
            top: 18px;
            color: var(--text-muted);
            pointer-events: none;
            transition: 0.2s ease all;
            font-size: 16px;
        }

        /* Label floating state */
        .input-control:focus~.floating-label,
        .input-control:not(:placeholder-shown)~.floating-label {
            top: 8px;
            font-size: 12px;
            color: var(--primary-color);
            font-weight: 500;
        }

        .input-control:not(:focus)~.floating-label {
            color: var(--text-muted);
        }

        /* Password Toggle */
        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 15px;
            cursor: pointer;
            color: var(--text-muted);
            font-size: 20px;
            background: none;
            border: none;
            z-index: 2;
        }

        /* Error Messages */
        .error-message {
            color: var(--error-color);
            font-size: 12px;
            margin-top: 4px;
            display: none;
            /* Hidden by default */
            animation: fadeIn 0.2s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .input-control.invalid {
            border-color: var(--error-color) !important;
        }

        /* Options Row */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: var(--text-muted);
        }

        .remember-me input {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .forgot-password {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        /* Button */
        .btn-login {
            width: 100%;
            height: 48px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            /* border-radius: 8px; */
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.1s;
            margin-bottom: 24px;
        }

        .btn-login:hover {
            background-color: var(--primary-hover);
        }

        .btn-login:active {
            transform: scale(0.98);
        }

        /* Footer */
        .form-footer {
            text-align: center;
            font-size: 14px;
            color: var(--text-muted);
        }

        .form-footer a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .login-container {
                padding: 32px 24px;
                box-shadow: none;
                background: var(--card-bg);
            }

            body {
                background-color: var(--card-bg);
                align-items: flex-start;
                padding-top: 60px;
            }
        }
    </style>

    <main class="login-container">
        @php
            $siteSetting = \App\Models\SiteSetting::find(1);
        @endphp
        <header>
            {{-- <h1>Welcome Back</h1>
                <p>Please enter your details to sign in.</p> --}}

            @if ($siteSetting && $siteSetting->site_logo)
                <img src="{{ asset('storage/images/settings/' . $siteSetting->site_logo) }}"
                    alt="{{ $siteSetting->site_title }}" width="280px" class="bg-secondar px-3">
            @else
                <img src="{{ asset('assets/images/logo.png') }}" alt="Sterling Wills & Estate Planning" width="280px"
                    class="bg-secondar px-3">
            @endif
        </header>

        <form id="loginForm" method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <!-- Email Field -->
            <div class="form-group">
                <div class="password-wrapper">
                    <input type="email" id="email" name="email"
                        class="input-control @error('email') is-invalid @enderror" placeholder=""
                        value="{{ old('email') }}" required autocomplete="email" autofocus>
                    <label for="email" class="floating-label">Email Address</label>
                </div>
                <div id="emailError" class="error-message">Please enter a valid email address.</div>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="form-group">
                <div class="password-wrapper">
                    <input type="password" id="password" name="password"
                        class="input-control @error('password') is-invalid @enderror" placeholder=" " required>
                    <label for="password" class="floating-label">Password</label>
                    <button type="button" class="toggle-password" id="togglePassword">
                        👁️
                    </button>
                </div>
                <div id="passwordError" class="error-message">Password must be at least 6 characters.</div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            {{-- <div class="mb-1 input-group">
                <div class="g-recaptcha" data-sitekey="{{ config('app.recaptcha_site_key') }}"></div>
            </div>
            <small id="captcha-error" class="text-danger d-none">
                Please verify that you are not a robot.
            </small> --}}
            <!-- Options -->
            <div class="form-options">
                <label class="remember-me">
                    <input type="checkbox" id="rememberMe" name="remember" {{ old('remember') ? 'checked' : '' }}>
                    Remember me
                </label>
                @if (Route::has('admin.password.request'))
                    <a href="{{ route('admin.password.request') }}" class="forgot-password">Forgot Your
                        password?</a>
                @endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-login">Login</button>

            <!-- Footer Links -->
            {{-- <div class="form-footer">
                    Don't have an account? <a href="#">Create an account</a>
                </div> --}}
        </form>
    </main>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const loginForm = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const togglePasswordBtn = document.getElementById('togglePassword');

            // Password Visibility Toggle
            togglePasswordBtn.addEventListener('click', () => {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                const toggleIcon = document.querySelector('.toggle-password');
                if (type === 'text') {
                    toggleIcon.textContent = '🙈'; // Eye closed icon
                } else {
                    toggleIcon.textContent = '👁️'; // Eye open icon
                }
            });

            // Dummy Validation Logic
            const validateEmail = (email) => {
                return String(email)
                    .toLowerCase()
                    .match(
                        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                    );
            };

            const showError = (input, errorId, show) => {
                const errorElement = document.getElementById(errorId);
                if (show) {
                    input.classList.add('invalid');
                    errorElement.style.display = 'block';
                } else {
                    input.classList.remove('invalid');
                    errorElement.style.display = 'none';
                }
            };

            // Real-time validation cleanup on typing
            emailInput.addEventListener('input', () => {
                if (emailInput.classList.contains('invalid')) {
                    showError(emailInput, 'emailError', false);
                }
            });

            passwordInput.addEventListener('input', () => {
                if (passwordInput.classList.contains('invalid')) {
                    showError(passwordInput, 'passwordError', false);
                }
            });

            // Form Submit
            loginForm.addEventListener('submit', (e) => {
                e.preventDefault();
                let isValid = true;

                // Email check
                if (!validateEmail(emailInput.value)) {
                    showError(emailInput, 'emailError', true);
                    isValid = false;
                }

                // Password check
                if (passwordInput.value.length < 6) {
                    showError(passwordInput, 'passwordError', true);
                    isValid = false;
                }

                if (isValid) {
                    // Simulating successful login
                    const btn = loginForm.querySelector('.btn-login');
                    const originalText = btn.innerText;
                    btn.disabled = true;
                    btn.innerText = 'Loging in...';
                    loginForm.submit();
                    // setTimeout(() => {
                    //     console.log('Login attempt successful with:', {
                    //         email: emailInput.value,
                    //         password: passwordInput.value
                    //     });
                    //     btn.innerText = 'Success!';
                    //     btn.style.backgroundColor = '#10b981'; // Success Green

                    //     setTimeout(() => {
                    //         btn.disabled = false;
                    //         btn.innerText = originalText;
                    //         btn.style.backgroundColor = '';
                    //     }, 2000);
                    // }, 1500);
                }
            });
        });
    </script>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {

            var response = grecaptcha.getResponse();
            var errorBox = document.getElementById('captcha-error');

            if (response.length === 0) {
                e.preventDefault(); // Stop form submission
                errorBox.classList.remove('d-none');
            } else {
                errorBox.classList.add('d-none');
            }
        });
    </script>
@endsection
