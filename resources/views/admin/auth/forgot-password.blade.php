@extends('admin.layouts.guest')
@section('title', 'Login')
@section('content')
    <div class="container">
        @php
            $setting = \App\Models\SiteSetting::find(1);
        @endphp
        <div class="row justify-content-center">
            <div class="login-container">
                {{-- <h1>Login </h1> --}}
                <div class="admin-login-logo">
                    @if ($setting && $setting->site_logo)
                        <img src="{{ asset('storage/images/settings/' . $setting->site_logo) }}"
                            alt="{{ $setting->site_title }}">
                    @else
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Wills">
                    @endif
                </div>

                <div class="mb-4 fs-6">
                    Forgot your password? No problem. <br>
                    Just let us know your email address <br> and we will email you a password reset <br> link that will allow you to
                    choose a new one.
                </div>

                <!-- Session Status -->
                @if (session('success'))
                    <div class="alert alert-success  rounded-3 shadow-sm"
                        style="color: green;padding: 13px 13px;
                            background: cornsilk;
                            border-radius: 5px;"
                        id="success-alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger  rounded-3 shadow-sm "
                        style="color: red;padding: 13px 13px;
                            background: cornsilk;
                            border-radius: 5px;"
                        id="success-alert">
                        {{ session('error') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('admin.password.email') }}">
                    @csrf
                    <!-- Email Address -->
                    <div class="form-group">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="Enter email">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-dark" href="{{ route('admin.login') }}">
                            {{ __('Login') }}
                        </a>
                        <button class="ms-3 btn btn-dark">
                            {{ __('Email Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>


        <script>
            window.onload = function() {
                let alert = document.getElementById('success-alert');
                if (alert) {
                    setTimeout(function() {
                        alert.style.transition = 'opacity 0.5s ease';
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 500);
                    }, 3000);
                }
            };
        </script>

    @endsection
