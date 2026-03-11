<div class="offcanvas offcanvas-end text-bg-white" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel"
    style="z-index: 9999">

    @php
        $siteSetting = \App\Models\SiteSetting::find(1);
    @endphp
    <div class="offcanvas-header">
        <a class="navbar-brand" href="{{ route('home') }}">
            @if ($siteSetting && $siteSetting->site_logo)
                <img src="{{ asset('storage/images/settings/' . $siteSetting->site_logo) }}"
                    alt="{{ $siteSetting->site_title }}">
            @else
                <img src="{{ asset('assets/images/logo.png') }}" alt="{{ $siteSetting->site_title }}">
            @endif
        </a>

        <button type="button" class="btn-close btn-close-success" data-bs-dismiss="offcanvas"
            aria-label="Close"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column justify-content-center">

        <ul class="navbar-nav text-center fs-4 my_menu">
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('resources') }}">Resources</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('gallery') }}">Gallery</a></li>
            {{-- <li class="nav-item"><a class="nav-link" href="#">About Us</a></li> --}}
            {{-- <li class="nav-item">
                <a class="nav-link d-flex justify-content-between align-items-center {{ request()->routeIs(['journey', 'protection']) ? 'active' : '' }}"
                    data-bs-toggle="collapse" href="#aboutSubMenu" role="button" aria-expanded="false"
                    aria-controls="aboutSubMenu">
                    About Us
                    <i class="bi bi-chevron-down small"></i>
                </a>

                <ul class="collapse list-unstyled mt-2" id="aboutSubMenu">
                    <li class="py-1">
                        <a class="nav-link fs-6" href="{{ route('story') }}">Our Story</a>
                    </li>
                    <li class="py-1">
                        <a class="nav-link fs-6" href="{{ route('journey') }}">Guided Journey</a>
                    </li>
                    <li class="py-1">
                        <a class="nav-link fs-6" href="{{ route('protection') }}">Protection</a>
                    </li>
                </ul>
            </li> --}}
            <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('blogs') }}">Blog</a></li>
        </ul>

        {{-- <div class="text-center mt-4">
            <a href="{{ route('start.will') }}" class="btn btn-outline-light rounded-0 px-4 py-2">
                Start Your Will
            </a>
        </div> --}}

    </div>
</div>
