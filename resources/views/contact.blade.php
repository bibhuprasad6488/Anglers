@extends('layouts.app')
@section('title', 'Contact Us')
@section('meta_title', 'Contact Sterling Wills | Will Writing & Estate Planning')
@section('meta_description',
    'Contact Sterling Wills for expert will writing & estate planning advice. Our friendly team
    is here to help with wills, trusts, and LPAs.')

@section('content')

    <div class="services" class="text-center">
        <!-- HERO -->
        <div class="services" class="text-center">
            {{-- <video class="bg-video" autoplay muted loop playsinline>
            <source src="{{ asset('assets/videos/intro.mp4') }}" type="video/mp4">
        </video> --}}
            <img src="{{ asset('assets/images/banner_bg.jpg') }}" class="bg-video" alt="Sterling Wills & Estate Planning">

            <!-- Overlay (optional dark mask) -->
            <div class="mask">
                <div class="text-white">
                    <h2 class="mb-3 inner-page-title">Contact Us</h2>
                    <p></p>
                </div>
            </div>
        </div>

        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>

    <section class=" py-4 cm10">
        <div class="container">
            <div class="row justify-content-center  rounded-0">
                <div class="col-lg-12">
                    <h2 class="mb-3">
                        Wills Sterling is your trusted Will Lawyer
                    </h2>

                    <p class="mb-4 fs-5">
                        Thank you for considering <b>Sterling Wills & Estate Planning.</b> We’re here to make connecting
                        with us as
                        simple and stress-free as possible. Whether you have questions about <b>will writing, estate
                            planning,
                            trusts</b>, or <b>lasting powers of attorney</b>, or you’re ready to start your planning
                        journey, our friendly
                        team is ready to help.
                    </p>
                </div>

            </div>
        </div>
    </section>
    <section class="cta py-5">

        <div class="container ">
            <div class="row  text-center rounded-0">
                <div class="col-lg-6 px-5">
                    <div class="cta-title ">
                        <i class="fa fa-map-marker fa-1x" aria-hidden="true"></i>
                    </div>
                    <h2 class="cta-title mb-3">
                        Office Address
                    </h2>

                    <p class="cta-subtitle mb-4">
                        {{ $siteSetting->address ?? '' }}
                    </p>
                </div>

                <div class="col-lg-6 px-5">
                    <div class="cta-title ">
                        <i class="fa fa-phone-alt fa-1x" aria-hidden="true"></i>
                    </div>
                    <h2 class="cta-title mb-3">
                        Phone Number
                    </h2>
                    <p class="cta-subtitle mb-4">
                        {{ $siteSetting->contact_phone ?? '' }}
                    </p>
                </div>

            </div>

        </div>
    </section>

    <section class="py-5 mb-6 cmt10">
        <div class="container">
            <div class="row align-items-center g-5">

                <!-- Left: Content + Form -->
                <div class="col-md-6">
                    <h2 class="fw-bold fs-3 mb-3">
                        Get in Touch Today for a Free Consultation
                    </h2>

                    <p class="mb-4 text-muted">
                        Get in touch with our team to discuss your estate planning needs. We’re here to answer your
                        questions, provide clear guidance, and help you take the next step with confidence.
                    </p>

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

                    <form action="{{ route('contact.submit') }}" method="post" class="mt-4" id="contactForm">
                        @csrf

                        <div class="mb-3">
                            <input type="text" class="form-control border-secondary rounded-0" name="ct_name"
                                placeholder="Your name" required>
                        </div>

                        <div class="mb-3">
                            <input type="email" class="form-control border-secondary rounded-0" name="ct_email"
                                placeholder="Your email" required>
                        </div>

                        <div class="mb-3">
                            <input type="text" class="form-control border-secondary rounded-0 numeric-only"
                                name="ct_phone" placeholder="Your phone" required>
                        </div>

                        <div class="mb-4">
                            <textarea name="ct_message" rows="5" class="form-control border-secondary rounded-0" placeholder="Your message"
                                required></textarea>
                        </div>

                        <div class="mb-3">
                            <div class="g-recaptcha" data-sitekey="{{ config('app.recaptcha_site_key') }}"></div>
                            <small id="captcha-error" class="text-danger d-none">
                                Please verify that you are not a robot.
                            </small>
                        </div>

                        <button type="submit" class="btn btn-secondary fw-bold px-5 py-2 rounded-0">
                            Submit
                        </button>
                    </form>
                </div>

                <!-- Right: Image -->
                <div class="col-md-6 text-center">
                    <img src="{{ asset('assets/images/consultation.png') }}" alt="Consultation"
                        class="img-fluid rounded-3 shadow-sm d-none d-md-block">
                </div>

            </div>
        </div>
    </section>


@endsection
@push('scripts')
    <script>
        $(document).on('input', '.numeric-only', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    </script>

    <script>
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
    </script>
@endpush
