<section class="section cnt_info pb-5 ">
    <div class="container">
        <h2 class="center-align text-center mb-5">CONTACT INFORMATION</h2>
        <div class="row">
            <div class="col-lg-6">
                <div class="card rounded-0 border-0">
                    <h6>{{ $siteSetting->site_title }}</h6>
                    <p>{!! $siteSetting->site_desc !!}</p>
                    <div class="d-flex flex-column cont-info-wrap gap-3 row">
                        <div class="me-4 col-xs-12">
                            @php
                                $address = $siteSetting->address;
                                $mapLink = 'https://www.google.com/maps/search/?api=1&query=' . urlencode($address);
                            @endphp
                            <a href="{{ $mapLink }}" target="_blank">
                                <p class="mb-0">
                                    <img src="{{ asset('assets/images/location-icon.svg') }}" alt="Image">
                                </p>
                                <p class="mb-0">

                                    {!! $siteSetting->address !!}
                                </p>
                            </a>
                        </div>
                        <div class="me-4 col-xs-12">
                            <a href="tel:{{ $siteSetting->contact_phone }}">
                                <img src="{{ asset('assets/images/call-icon.svg') }}"
                                    alt="Image">{{ $siteSetting->contact_phone }} </a>
                        </div>
                        <div class="me-4 col-xs-12">
                            <a href="mailto:{{ $siteSetting->contact_email }}">
                                <img src="{{ asset('assets/images/mail-icon.svg') }}"
                                    alt="Image">{{ $siteSetting->contact_email }} </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                @if (session('tab') == 'contact')
                    @if (session('success'))
                        <div class="alert alert-success mt-3 rounded-3 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger mt-3 rounded-3 shadow-sm">
                            {{ session('error') }}
                        </div>
                    @endif
                @endif
                <form action="{{ route('contact.submit') }}" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <input type="text" class="form-control border-secondary rounded-0"
                                placeholder="Full name*" name="ct_name" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <input type="email" class="form-control border-secondary rounded-0" placeholder="Email*"
                                name="ct_email" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <input type="text" class="form-control border-secondary rounded-0 numeric-only"
                                placeholder="Phone" name="ct_phone">
                        </div>
                        <div class="col-md-6 mb-4">
                            <input type="text" class="form-control border-secondary rounded-0" placeholder="Subject*"
                                name="ct_subject" required>
                        </div>
                        <div class="col-lg-12 mb-4">
                            <textarea name="ct_message" id="ct_message" rows="10" class="form-control border-secondary rounded-0"
                                placeholder="Message*" required></textarea>
                        </div>
                        <div class="col-lg-12 mb-4">
                            <button type="submit" class="btn book-cabin-btn">Send</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@push('scripts')
    <script>
        $(document).on('input', '.numeric-only', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    </script>
    {{-- <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {

            var response = grecaptcha.getResponse();
            var errorBox = document.getElementById('captcha-error');

            if (response.length === 0) {
                e.preventDefault(); // Stop form submission
                errorBox.classList.remove('d-none');
            } else {
                errorBox.classList.add('d-none');
            }
        });
    </script> --}}
@endpush
