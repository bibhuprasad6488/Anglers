@extends('layouts.app')
@section('title', trim($home_page_data->meta_title) ?? '')
@section('meta_title', $home_page_data->meta_title ?? '')
@section('meta_description', $home_page_data->meta_desc ?? '')
@section('meta_keyword', $home_page_data->meta_key ?? '')
@section('content')
    <!-- HERO -->
    <div id="intro-example" class="text-center">
        {{-- <video class="bg-video" autoplay muted loop playsinline>
            <source src="{{ asset('assets/videos/intro.mp4') }}" type="video/mp4">
        </video> --}}
        <img src="{{ asset('assets/images/banner_bg.jpg') }}" class="bg-video" alt="Sterling Wills & Estate Planning">

        <div class="mask">
            <div class="text-white">
                <h1 class="mt-5 banner-title">Professional Will Writing Services You Can Trust</h1>
                <h4 class="my-4 banner-subtitle">Protect your family’s future with a professionally written Will.</h4>

                <a class="btn btn-light btn-lg m-2 rounded-0" href="{{ route('journey') }}" role="button">View
                    Details..</a>
                <a class="btn btn-light btn-lg m-2 rounded-0" href="{{ route('contact') }}" role="button">Contact
                    us today !</a>
            </div>
        </div>
    </div>

    <!-- MOB HEADER -->
    @include('layouts.mob_header')

    <section class="section about_us">
        <div class="container">
            <div class="row g-4 py-6">

                <!-- LEFT IMAGE BOX -->
                <div class="col-md-6 px-5">
                    <div class="feature-box h-100">
                        <img src="{{ asset('assets/images/about_us.png') }}" alt="Will Writing"
                            class="img-fluid feature-image">
                    </div>
                </div>

                <!-- RIGHT TEXT BOXES -->
                <div class="col-md-6 px-5">
                    <div class="d-flex flex-column h-100 gap-4">

                        <div class="feature-box flex-fill">
                            <h3>Who are we?</h3>
                            <p>At Sterling Wills & Estate Planning, we provide clear, reliable will writing and estate
                                planning services to give you peace of mind. We take a personal, straightforward
                                approach, ensuring your wishes are clearly explained and legally recorded. Every client
                                is unique, and our focus is on creating well-structured wills that protect loved ones,
                                reduce uncertainty, and help prevent future disputes.</p>
                            <p>Our experienced team upholds the highest standards of professionalism, confidentiality,
                                and compliance. We also offer guidance on broader estate planning needs, including
                                updating wills and planning for life changes. By choosing Sterling Wills & Estate
                                Planning, you gain clarity, trust, and long-term reassurance—protecting what matters
                                most, now and in the future.</p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
    {{--

    <section>
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

                <div class="start_will"><a class="btn btn-secondary mt-3 rounded-0 fs-4 px-4 py-2"
                        href="{{ url('/services') }}">View
                        all</a></div>
            </div>
        </div>
    </section> --}}

    @include('cta_common')


    {{-- <section class="section guided_journey pb-5">
        <div class="container">
            <h2 class="text-center mb-5 maastrix">Guided Journey</h2>
            <div class="row g-4">
                <div class="col-md-4 ">
                    <div class="card text-center rounded-0"><img src="{{ asset('assets/images/step1.jpg') }}">
                        <p>Step1 : Getting Started</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center rounded-0"><img src="{{ asset('assets/images/step2.jpg') }}">
                        <p>Step2 : Provide Your Information</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center rounded-0"><img src="{{ asset('assets/images/step3.jpg') }}">
                        <p>Step3 : We Prepare Your Will</p>
                    </div>
                </div>
            </div>
            <div class="start_will"><a class="btn btn-dark mt-3 rounded-0 fs-4 px-4 py-2" href="{{ route('journey') }}">View
                    all</a></div>
            <div class="start_will"><a class="btn btn-dark mt-3 rounded-0 fs-4 px-4 py-2">Make your will today</a></div>
        </div>
    </section> --}}
@endsection
