<footer class="site-footer">
    <div class="container">
        <div class="row text-center text-md-start">
            <!-- Column 1: Logo -->
            <div class="col-md-3 mb-4">
                <h5></h5>
                <div class="">
                    <p class="text-center">

                        <a href="{{ route('home') }}">
                            @if ($siteSetting && $siteSetting->footer_logo)
                                <img src="{{ asset('storage/images/settings/' . $siteSetting->footer_logo) }}"
                                    alt="{{ $siteSetting->site_title }}" width="">
                            @else
                                <img src="{{ asset('assets/images/logo.png') }}" alt="{{ $siteSetting->site_title }}"
                                    width="">
                            @endif
                        </a>
                    </p>
                    <p class="text-center">
                        @php
                            $address = $siteSetting->address;
                            $mapLink = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($address);
                        @endphp
                        <a href="{{ $mapLink }}" target="_blank" class="text-decoration-none text-white">
                            {!! $siteSetting->address !!}
                        </a>
                    </p>
                </div>
            </div>

            <!-- Column 3: Navigation -->
            <div class="col-md-3 mb-4  ">
                <h4 class="">Important Links</h4>
                <ul class="list-unstyled footer-links  ">
                    <li>
                        <a href="{{ route('home') }}">
                            <i class="fas fa-arrow-right"></i> Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('category.properties', $cat->slug) }}">
                            <i class="fas fa-arrow-right"></i> Cabins
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('resources') }}">
                            <i class="fas fa-arrow-right"></i> Resources
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Column 3: Navigation -->
            <div class="col-md-3 mb-4 ">
                <h4>Quick Links</h4>

                <ul class="list-unstyled footer-links">
                    <li>
                        <a href="{{ route('gallery') }}">
                            <i class="fas fa-arrow-right"></i> Gallery
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('contact') }}">
                            <i class="fas fa-arrow-right"></i> Contact
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('blogs') }}">
                            <i class="fas fa-arrow-right"></i> Blog
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Column 2: Contact -->
            <div class="col-md-3 mb-4  ">
                <h4>Contact </h4>
                <ul class="list-unstyled footer-links">
                    <p>
                        <img src="{{ asset('assets/images/footer-call.png') }}" alt="" height="60px">
                    </p>

                    <li class="mb-2 fw-bold">
                        <a href="tel:{{ $siteSetting->contact_phone }}">
                            <i class="fa fa-phone-square-alt" aria-hidden="true"></i>

                            {{ $siteSetting->contact_phone }}
                        </a>
                    </li>
                </ul>
            </div>


        </div>
    </div>
</footer>
<div>
    <button id="backToTop" title="Go to top"><i class="fas fa-angle-up"></i></button>
</div>

<div class="footer-bottom">
    <div class="container">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small py-3">

                <!-- Copyright -->
                <div class="mb-2 mb-md-0 text-center text-md-start">
                    @if ($siteSetting && $siteSetting->copyright)
                        © {{ date('Y') }} {{ $siteSetting->copyright }}
                    @endif
                </div>

                <!-- Links -->
                <div class="text-center text-md-end">
                    <a href="{{ route('privacy') }}" class="text-decoration-none text-white me-2">Privacy Policy</a> |
                    <a href="{{ route('terms.business') }}" class="text-decoration-none text-white ms-2">Terms of
                        Use</a>
                </div>
            </div>
        </div>

    </div>
</div>
