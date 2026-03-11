<footer class="site-footer">
    <div class="container">
        <div class="row text-center text-md-center">

            <div class="col-md-6 text-center  mt-4 mx-auto">

                <!-- Logo -->
                <div class="mb-3 text-center d-flex justify-content-center">
                    <a href="{{ route('home') }}">
                        @if ($siteSetting && $siteSetting->footer_logo)
                            <img src="{{ asset('storage/images/settings/' . $siteSetting->footer_logo) }}"
                                alt="{{ $siteSetting->site_title }}" width="250">
                        @else
                            <img src="{{ asset('assets/images/logo.png') }}" alt="{{ $siteSetting->site_title }}"
                                width="250">
                        @endif
                    </a>
                </div>

                <!-- Footer Content -->
                <div class="mb-3">
                    <p>{{ $siteSetting->footer_text_one ?? '' }}</p>
                </div>

                <!-- Contact Details -->
                <div>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2">
                            @php
                                $address = $siteSetting->address;
                                $mapLink = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($address);
                            @endphp
                            <a href="{{ $mapLink }}" target="_blank">
                                {{ $siteSetting->address }}
                            </a>
                        </li>

                        <li class="mb-2">
                            <a href="tel:{{ $siteSetting->contact_phone }}">
                                {{ $siteSetting->contact_phone }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div>
                    <ul
                        class="d-flex flex-column flex-md-row justify-content-center space-between list-unstyled footer-links text-center gx-4">
                        <li class="mx-2">
                            <a href="{{ route('home') }}" class="{{ request()->routeIs(['home']) ? 'active' : '' }}">
                                Home
                            </a>
                        </li>
                        <li class="mx-2">
                            <a href="{{ route('resources') }}"
                                class="{{ request()->routeIs(['resources']) ? 'active' : '' }}">
                                Resources
                            </a>
                        </li>
                        <li class="mx-2">
                            <a href="{{ route('gallery') }}"
                                class="{{ request()->routeIs(['gallery']) ? 'active' : '' }}">
                                Gallery
                            </a>
                        </li>
                        <li class="mx-2">
                            <a href="{{ route('contact') }}"
                                class="{{ request()->routeIs(['contact']) ? 'active' : '' }}">
                                Contact
                            </a>
                        </li>
                        <li class="mx-2">
                            <a href="{{ route('blogs') }}"
                                class="{{ request()->routeIs(['blogs']) ? 'active' : '' }}">
                                Blog
                            </a>
                        </li>
                    </ul>
                </div>

            </div>

        </div>

        {{-- <hr class="footer-divider"> --}}


    </div>
</footer>

<div>
    <button id="backToTop" title="Go to top">↑</button>
</div>

<div class="footer-bottom">
    <div class="container">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small py-3">

                <!-- Copyright -->
                <div class="mb-2 mb-md-0 text-center text-md-start">
                    @if ($siteSetting && $siteSetting->copyright)
                        {{ $siteSetting->copyright }}
                    @else
                        © {{ date('Y') }} Angler's Hideaway, LLC. All Rights Reserved.
                    @endif
                </div>

                <!-- Links -->
                <div class="text-center text-md-end">
                    <a href="{{ route('privacy') }}" class="text-decoration-none text-white me-2">Privacy Policy</a> /
                    <a href="{{ route('terms.business') }}" class="text-decoration-none text-white ms-2">Terms of
                        Business</a>
                </div>
            </div>
        </div>

    </div>
</div>
