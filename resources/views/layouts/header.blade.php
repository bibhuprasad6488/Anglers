<nav class="navbar navbar-expand-lg navbar-dark tbb2 fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            @if ($siteSetting && $siteSetting->site_logo)
                <img src="{{ asset('storage/images/settings/' . $siteSetting->site_logo) }}"
                    alt="{{ $siteSetting->site_title }}">
            @else
                <img src="{{ asset('assets/images/logo.png') }}" alt="{{ $siteSetting->site_title }}">
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

                {{-- <li class="nav-item"><a class="nav-link {{ request()->routeIs(['service.lists']) ? 'active' : '' }}"
                        href="{{ route('service.lists') }}">Services</a></li> --}}
                {{-- <li class="nav-item"><a class="nav-link" href="#">Protection</a></li> --}}
                <li class="nav-item"><a class="nav-link {{ request()->routeIs(['contact']) ? 'active' : '' }}"
                        href="{{ route('contact') }}">Contact Us</a></li>
                {{-- <li class="nav-item ms-lg-3">
                    <a href="{{ route('start.will') }}" class="btn btn-outline-light rounded-0 start_btn">
                        Start Your Will
                    </a>
                </li> --}}
            </ul>
        </div>

    </div>
</nav>
