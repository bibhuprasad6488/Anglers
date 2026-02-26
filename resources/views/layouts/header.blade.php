<nav class="navbar navbar-expand-lg navbar-dark tbb2 fixed-top">
    <div class="container">
        @php
            $services = \App\Models\Service::where('status', 1)->get();
        @endphp
        <a class="navbar-brand" href="{{ route('home') }}">
            @if ($siteSetting && $siteSetting->site_logo)
                <img src="{{ asset('storage/images/settings/' . $siteSetting->site_logo) }}"
                    alt="{{ $siteSetting->site_title }}">
            @else
                <img src="{{ asset('assets/images/logo.png') }}" alt="Sterling Wills & Estate Planning">
            @endif
        </a>

        <!-- Mobile toggler -->
        <button class="navbar-toggler d-lg-none mobile_menu" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#mobileMenu" aria-controls="mobileMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Desktop menu -->
        <div class="collapse navbar-collapse d-none d-lg-flex">
            <ul class="navbar-nav ms-auto align-items-lg-center my_menu">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs(['home']) ? 'active' : '' }}"
                        href="{{ route('home') }}">Home</a></li>
                {{-- <li class="nav-item"><a class="nav-link" href="#">About Us</a></li> --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs(['journey', 'protection']) ? 'active' : '' }}"
                        href="javascript:;" id="aboutDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        About Us
                    </a>
                    <ul class="dropdown-menu shadow-sm rounded-0" aria-labelledby="aboutDropdown"
                        style="background: rgba(0, 0, 0, 0.5);">
                        <li>
                            <a class="dropdown-item" href="{{ route('story') }}">Our Story</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('journey') }}">Guided Journey</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('protection') }}">Protection</a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown" onclick="redirectTo('{{ route('service.lists') }}')">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs(['service.lists', 'service.details.*']) ? 'active' : '' }}"
                        href="{{ route('service.lists') }}" id="serviceDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Services
                    </a>
                    <ul class="dropdown-menu shadow-sm rounded-0" aria-labelledby="serviceDropdown"
                        style="background: rgba(0, 0, 0, 0.5);">
                        @foreach ($services as $s)
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('service.details', $s->slug) }}">{{ strtolower($s->name) }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                {{-- <li class="nav-item"><a class="nav-link {{ request()->routeIs(['service.lists']) ? 'active' : '' }}"
                        href="{{ route('service.lists') }}">Services</a></li> --}}
                <li class="nav-item"><a class="nav-link {{ request()->routeIs(['price-lists']) ? 'active' : '' }}"
                        href="{{ route('price-lists') }}">Pricing</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs(['blogs']) ? 'active' : '' }}"
                        href="{{ route('blogs') }}">Case Studies</a></li>
                {{-- <li class="nav-item"><a class="nav-link" href="#">Protection</a></li> --}}
                <li class="nav-item"><a class="nav-link {{ request()->routeIs(['contact']) ? 'active' : '' }}"
                        href="{{ route('contact') }}">Contact</a></li>
                <li class="nav-item ms-lg-3">
                    <a href="{{ route('start.will') }}" class="btn btn-outline-light rounded-0 start_btn">
                        Start Your Will
                    </a>
                </li>
            </ul>
        </div>

    </div>
</nav>
