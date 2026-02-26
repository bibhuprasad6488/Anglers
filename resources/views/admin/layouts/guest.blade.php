<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
    $siteSetting = \App\Models\SiteSetting::find(1);
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

    <!-- Favicons -->
    <link
        href="@if ($siteSetting) {{ asset('storage/images/settings/' . $siteSetting->favicon) }} @endif"
        rel="icon" />

    <link
        href="@if ($siteSetting) {{ asset('storage/images/settings/' . $siteSetting->favicon) }} @endif"
        rel="apple-touch-icon" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    {{-- <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            /* font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif; */
            background: linear-gradient(30deg, #7c8070, #6D7743);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            background-color: #fff;
            padding: 80px;
            width: 100%;
            /* max-width: 420px; */
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* margin-top: 250px; */
        }

        h1 {
            color: #000;
            font-size: 32px;
            margin-bottom: 40px;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 25px;
            text-align: left;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            background-color: #fff;
            color: #000;
        }

        input[type="email"]::placeholder,
        input[type="password"]::placeholder {
            color: #666;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #000;
        }

        .login-button {
            width: 100%;
            padding: 15px;
            background-color: #6D7743;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        .login-button:hover {
            background-color: #333;
        }

        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            margin-top: 20px;
        }

        .remember-me input[type="checkbox"] {
            margin-right: 10px;
        }

        .remember-me label {
            color: #666;
            font-size: 14px;
        }

        .forgot-password {
            display: block;
            color: #000;
            text-decoration: none;
            margin-top: 20px;
            font-size: 14px;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .signup-link {
            margin-top: 30px;
            color: #666;
            font-size: 14px;
        }

        .signup-link a {
            color: #000;
            text-decoration: none;
            font-weight: 600;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .admin-login-logo {
            /* background: #000; */
            margin-bottom: 30px;
        }

        .admin-login-logo img {
            max-width: 100%;
            height: auto;
        }
    </style>

</head>

<body>
    <div id="app">
        {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav> --}}

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>

</html>
