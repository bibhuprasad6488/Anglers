<nav class="navbar navbar-expand-lg navbar-dark tbb2 fixed-top">
    <div class="container">
        @php
            $propertyCats = \App\Models\PropertyCategory::where('status', 1)->orderByDesc('id')->get();
        @endphp
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

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle " href="javascript:;" id="aboutDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Book Now </a>
                    <ul class="dropdown-menu shadow-sm rounded-0" aria-labelledby="aboutDropdown"
                        style="background: rgb(252, 252, 252);">
                        @foreach ($propertyCats as $pc)
                            <li>
                                <a class="dropdown-item"
                                    href="{{ route('category.properties', $pc->slug) }}">{{ $pc->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs(['resources']) ? 'active' : '' }}"
                        href="{{ route('resources') }}">Resources</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs(['gallery']) ? 'active' : '' }}"
                        href="{{ route('gallery') }}">Gallery</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs(['contact']) ? 'active' : '' }}"
                        href="{{ route('contact') }}">Contact</a></li>

                <li class="nav-item"><a class="nav-link {{ request()->routeIs(['blogs']) ? 'active' : '' }}"
                        href="{{ route('blogs') }}">Blog</a></li>
                {{-- <li class="nav-item ms-lg-3">
                    <a href="{{ route('start.will') }}" class="btn btn-outline-light rounded-0 start_btn">
                        Start Your Will
                    </a>
                </li> --}}
            </ul>
        </div>
        <!-- Desktop menu -->
        <div class="collapse navbar-collapse d-none d-lg-flex">
            <ul class="navbar-nav ms-auto align-items-lg-center my_menu">
                <li class="nav-item"><a class="nav-link" href="tel:{{ $siteSetting->contact_phone }}">
                        <img src="{{ asset('assets/images/call-icon.svg') }}" alt="Image"
                            style="background: #6d7743; padding:5px; border-radius:50%; margin:0 5px" width="35px">
                        <span class="text-muted">{{ $siteSetting->contact_phone }}</span>
                    </a></li>
            </ul>
        </div>
    </div>
</nav>
