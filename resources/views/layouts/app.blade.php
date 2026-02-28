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

    <title>@yield('title') @if ($siteSetting)
            | {{ $siteSetting->site_title }}
        @endif
    </title>
    <meta name="title" content="@yield('meta_title', '')">
    <meta name="keywords" content="@yield('meta_keyword', '')">
    <meta name="description" content="@yield('meta_description', '')">
    <link rel="canonical" href="{{ url()->current() }}" />
    <meta property="og:title"
        content="@yield('meta_title', '') @if ($siteSetting) | {{ $siteSetting->site_title }} @endif" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="@yield('meta_description', '')" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="@if ($siteSetting) {{ $siteSetting->site_title }} @endif" />
    <meta property="og:image"
        content="@if ($siteSetting) {{ asset('storage/images/settings/' . $siteSetting->favicon) }} @else '' @endif" />


    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "{{ $siteSetting->site_title }}",
        "url": "{{ url('/') }}",
        "image": "{{ asset('storage/images/settings/' . $siteSetting->site_logo) }}",
        "telephone": "{{ $siteSetting->contact_phone }}",
        "address": {
        "@type": "PostalAddress",
        "addressCountry": "USA"
        }
        }
</script>

    <!-- Favicons -->
    <link
        href="@if ($siteSetting) {{ asset('storage/images/settings/' . $siteSetting->favicon) }} @else '' @endif"
        rel="icon" />

    <link
        href="@if ($siteSetting) {{ asset('storage/images/settings/' . $siteSetting->favicon) }} @else '' @endif"
        rel="apple-touch-icon" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    {{-- <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/testimonial.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/timeline.css') }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
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

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav> --}}

        <main>
            @include('layouts.header')
            @yield('content')
        </main>
    </div>

    <div class="sticky-icons d-flex flex-column gap-1">
        <div>
            <a href="tel:{{ $siteSetting->call_wp_number ?? '+447555170449' }}" title="Call Us">
                <img src="{{ asset('assets/images/call.png') }}" width="70" alt="Call" class="mb-0">
            </a>
        </div>
        <div>
            <a href="https://api.whatsapp.com/send?phone={{ $siteSetting->call_wp_number ?? '+447555170449' }}&text={{ $siteSetting->wp_message ?? 'Hi' }}"
                target="_blank" title="WhatsApp Us">
                <img src="{{ asset('assets/images/wp.png') }}" width="70" alt="WP">
            </a>

        </div>
    </div>
    @include('layouts.footer')

    <!-- jQuery FIRST -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/scroll.js') }}"></script>
    <script src="{{ asset('assets/js/testimonial.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/timeline.js') }}"></script> --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


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

        function redirectTo(url) {
            window.location.href = url;
        }
    </script>
    @stack('scripts')
</body>

</html>
