<footer class="site-footer">
    <div class="container">
        <div class="row align-items-start text-center text-md-start">

            <!-- Column 1: Company -->
            <div class="col-md-3 col-xs-12 mb-4 mb-md-0">
                <div class="footer_1st">
                    <p><a href="{{ route('home') }}">
                            @if ($siteSetting && $siteSetting->footer_logo)
                                <img src="{{ asset('storage/images/settings/' . $siteSetting->footer_logo) }}"
                                    alt="{{ $siteSetting->site_title }}">
                            @else
                                <img src="{{ asset('assets/images/logo.png') }}" alt="Sterling Wills & Estate Planning">
                            @endif
                        </a>
                    </p>
                    <p>{{ $siteSetting->footer_text_one ??''}}</p>
                </div>
            </div>

            <!-- Column 2: Services -->
            <div class="col-md-3 col-xs-12 mb-4 mb-md-0 ">
                <div class="footer_2nd">
                    <h6 class="footer-title">Quick Links</h6>
                    <ul class="footer-links">
                        <li>
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li>
                            <a href="{{ route('story') }}">Our Story</a>
                        </li>
                        <li>
                            <a href="{{ route('journey') }}">Guided Journey</a>
                        </li>
                        <li>
                            <a href="{{ route('blogs') }}">Case Studies</a>
                        </li>
                        <li>
                            <a href="{{ route('witness') }}">Witnesses</a>
                        </li>
                        <li>
                            <a href="{{ route('price-lists') }}">Pricing</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Column 2: Services -->
            <div class="col-md-3 col-xs-12 mb-4 mb-md-0">
                <h6 class="footer-title">Services</h6>
                <ul class="footer-links">
                    @foreach ($services as $s)
                        <li>
                            <a href="{{ route('service.details', $s->slug) }}">
                                {{ strtolower($s->name) }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-3 col-xs-12 mb-4 mb-md-0">

                <h6 class="footer-title">Accreditations</h6>
                <!-- Row 1: Compliance logos -->
                <div class="footer-logos mb-4">
                    <div class="logo-box">
                        @if ($siteSetting && $siteSetting->footer_logo_one)
                            <img src="{{ asset('storage/images/settings/' . $siteSetting->footer_logo_one) }}"
                                alt="{{ $siteSetting->site_title }}">
                        @else
                            <img src="{{ asset('assets/images/sww.png') }}" alt="Sterling Wills & Estate Planning">
                        @endif
                    </div>
                    <div class="logo-box">
                        @if ($siteSetting && $siteSetting->footer_logo_two)
                            <img src="{{ asset('storage/images/settings/' . $siteSetting->footer_logo_two) }}"
                                alt="{{ $siteSetting->site_title }}">
                        @else
                            <img src="{{ asset('assets/images/f2.jpg') }}" alt="Sterling Wills & Estate Planning">
                        @endif
                    </div>
                </div>

                <!-- Row 2: Social icons -->
                <div class="footer-socials mb-3">
                    <div class="social-box">
                        <img src="{{ asset('assets/images/fb.png') }}" alt="Facebook">
                    </div>
                    <div class="social-box">
                        <img src="{{ asset('assets/images/gplus.png') }}" alt="Google Plus">
                    </div>
                    <div class="social-box">
                        <img src="{{ asset('assets/images/twitter.png') }}" alt="Twitter">
                    </div>
                    <div class="social-box">
                        <img src="{{ asset('assets/images/whatsapp.png') }}" alt="WhatsApp">
                    </div>
                </div>

                <div class="d-flex flex-column gap-3 mt-3">

                    <!-- Phone -->
                    <div class="d-flex align-items-center">
                        <i class="fa fa-phone-alt me-2 text-secondary"></i>
                        <span>
                            @if ($siteSetting && $siteSetting->contact_phone)
                                {{ $siteSetting->contact_phone }}
                            @elseif ($siteSetting && $siteSetting->alt_phone)
                                {{ $siteSetting->alt_phone }}
                            @else
                                +44 (0) 203 957 7000
                            @endif
                        </span>
                    </div>

                    <!-- Email -->
                    <div class="d-flex align-items-center">
                        <i class="fa fa-envelope me-2 text-secondary"></i>
                        <span>
                            Email:
                            <a href="mailto:{{ $siteSetting->contact_email ??'' }}"
                                class="text-decoration-none">
                                Click here
                            </a>
                        </span>
                    </div>

                    <!-- Address -->
                    <div class="d-flex align-items-start">
                        <i class="fa fa-map-marker me-2 text-secondary mt-1"></i>
                        <span>
                            Address:
                            {{ $siteSetting->address ??'' }}
                        </span>
                    </div>

                </div>

            </div>
            <div class="col-md-12 col-xs-12 mb-4 mb-md-0 mt-4 text-center">
                {!! $siteSetting->footer_text_two??'' !!}
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
