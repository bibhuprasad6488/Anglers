@extends('layouts.app')
@section('title', 'Services')
@section('meta_title', 'Expert Services | Will Writing & Estate Planning – Sterling Wills')
@section('meta_description',
    'Professional will writing & estate planning services from Sterling Wills. Personal
    guidance, legal compliance, and lasting peace of mind.')

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
                    <h2 class="mb-3 inner-page-title">We offer various services</h2>
                    <h3 class="inner-page-subtitle">Entertainment law services in Sydney that protect your creative intellectual property to develop
                            and produce your creative projects.</h3>
                </div>
            </div>
        </div>

        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>
    <section class="section page">
        <div class="container">
            <div class="row g-4">

                <!-- RIGHT TEXT BOXES -->
                <div class="col-xs-12">
                    <div class="d-flex flex-column h-100 gap-4">

                        <div class="feature-box flex-fill">
                            <h2 class="text-center">Our law services in Sydney</h2>
                            <p>At <b>Sterling Wills & Estate Planning</b>, we offer a comprehensive range of expert services
                                designed to protect your family, preserve your assets, and give you lasting peace of mind.
                                Our team specialises in <b>will writing, estate planning, trusts</b>, and <b>lasting powers
                                    of attorney</b>, guiding you through every step with clarity, care, and professionalism.
                            </p>
                            <p>Whether you’re getting started with your first will or looking to update existing plans, we
                                tailor our approach to your unique circumstances. Our <b>will writing services</b> ensure
                                your wishes are clearly documented and legally enforceable, while our <b>estate planning
                                    solutions</b> help you organise complex assets, minimise tax exposure, and secure a
                                smooth transition of wealth.</p>
                            <p>We also provide specialist support with <b>trust planning</b>, helping you structure assets
                                to benefit loved ones in the way you intend. For individuals who want peace of mind through
                                all stages of life, our <b>lasting powers of attorney (LPA)</b> services allow you to
                                appoint trusted people to make decisions on your behalf if you’re unable to do so.</p>
                            <p>

                                At Sterling Wills, we combine legal expertise with a personal touch, making estate planning
                                straightforward, stress-free, and accessible. Whatever your needs, our friendly experts are
                                here to support you with reliable guidance and solutions you can trust.
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="bg_grey page py-5 mt-3">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-xs-12 px-5 ">
                    <h3 class="fw-bold">Our Expertise</h3>
                    <p>At <b>Sterling Wills & Estate Planning</b>, we provide professional <b>will writing and estate planning services</b> designed to protect what matters most. Our expertise covers wills, trusts, lasting powers of attorney, and wider estate planning solutions, all delivered with clarity and care. We take the time to understand your circumstances, ensuring every document reflects your wishes accurately and remains legally compliant. Our goal is to make estate planning simple, structured, and accessible for everyone.</p>
                </div>

                <div class="col-sm-6 col-xs-12 px-5 ">
                    <h3 class="fw-bold">A Personal, Guided Approach</h3>
                    <p>We believe estate planning should never feel overwhelming. That’s why our approach is personal, supportive, and fully guided from start to finish. From your first consultation through to document completion and secure storage, we’re with you at every stage. As life changes, we remain on hand to offer ongoing support and updates, giving you long-term peace of mind and confidence that your plans are always up to date.</p>
                </div>
            </div>
        </div>
    </section>


    <section class="section">
        <div class="container">
            <h2 class="text-center mb-5 maastrix">Our Services</h2>
            <div class="row g-4">
                @foreach ($services as $service)
                    <div class="col-md-4 px-5 py-4">
                        <div class="card service-card h-100 text-center rounded-0">
                            <img src="{{ $service->service_image }}" class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="service-title">
                                    {{ $service->name }}
                                </h5>

                                <div class="service-divider"></div>

                                <a href="{{ route('service.details', $service->slug) }}"
                                    class="btn btn-outline-dark rounded-0 mt-auto">
                                    FIND OUT MORE >
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('cta_common')

    <section class="section page">
        <div class="container">
            <div class="row g-4">

                <!-- RIGHT TEXT BOXES -->
                <div class="col-xs-12">
                    <div class="d-flex flex-column h-100 gap-4">

                        <div class="feature-box flex-fill">
                            <h2 class="text-center">Why Wills & Sterling</h2>
                            <p class="text-center">Wills & Sterling is dedicated to providing clear, dependable, and
                                personalised estate planning services tailored to your individual needs. We understand
                                that planning for the future can be complex, which is why we take a straightforward and
                                supportive approach, ensuring every step is explained clearly and with care.</p>
                            <p class="text-center">Our experienced team focuses on accuracy, compliance, and long-term
                                protection for you and your loved ones. Beyond will writing, we offer thoughtful
                                guidance on trusts and ongoing estate planning, helping you achieve confidence and
                                lasting peace of mind knowing your wishes are properly safeguarded.</p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
