<footer class="site-footer">
    <div class="container">
        <div class="row text-center text-md-center">

            <div class="col-md-6 text-center  col-12 mt-4 mx-auto">

                <!-- Logo -->
                <div class="mb-3 text-center text-md-start">
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
                    <ul class="list-unstyled">
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

                        <li>
                            <a href="mailto:{{ $siteSetting->contact_email }}">
                                {{ $siteSetting->contact_email }}
                            </a>
                        </li>
                    </ul>
                </div>

            </div>

        </div>

        {{-- <hr class="footer-divider"> --}}


    </div>
</footer>

<div class="footer-bottom">
    <div class="container">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small py-3">

                <!-- Copyright -->
                <div class="mb-2 mb-md-0 text-center text-md-start">
                    @if ($siteSetting && $siteSetting->copyright)
                        {{ $siteSetting->copyright }}
                    @else
                        © {{ date('Y') }} Sterling Wills &amp; Estate Planning
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
