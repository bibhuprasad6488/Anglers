@extends('admin.layouts.guest')
@section('title', 'Login')
@section('content')
    <div class="container">
        @php
            $siteSetting = \App\Models\SiteSetting::find(1);
        @endphp
        <div class="row justify-content-center">
            <div class="login-container">
                {{-- <h1>Login </h1> --}}
                <div class="admin-login-logo">
                    @if ($siteSetting && $siteSetting->site_logo)
                        <img src="{{ asset('storage/images/settings/' . $siteSetting->site_logo) }}"
                            alt="{{ $siteSetting->site_title }}" width="280px" class=" px-3">
                    @else
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Sterling Wills & Estate Planning" width="280px"
                            class=" px-3">
                    @endif
                    {{-- <img src="{{ asset('assets/images/Logo_d.png') }}" alt="Wills"> --}}
                </div>
                <form id="loginForm" method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf
                    <div class="form-group">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">
                        <div class="input-group-append py-4 px-3" style="border: 1px solid rgb(206, 202, 202)">
                            <span class="toggle-password" style="cursor: pointer;"
                                onclick="togglePasswordVisibility()">👁️</span>
                        </div>
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
                    <div class="remember-me">
                        <input type="checkbox" id="rememberMe" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="rememberMe">Remember Me</label>
                    </div>
                    <button type="submit" class="login-button">LOGIN</button>
                </form>

                @if (Route::has('admin.password.request'))
                    <a href="{{ route('admin.password.request') }}" class="forgot-password">Forgot Your password?</a>
                @endif
            </div>
        </div>

        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script>
            function togglePasswordVisibility() {
                const passwordInput = document.getElementById('password');
                const toggleIcon = document.querySelector('.toggle-password');
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.textContent = '🙈'; // Eye closed icon
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.textContent = '👁️'; // Eye open icon
                }
            }
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
