@extends('layouts.app')
@section('title', 'Our Story')
@section('meta_title', $story->meta_title)
@section('meta_description', $story->meta_desc)

@section('content')

    <!-- HERO -->
    <div class="services text-center position-relative">
        {{-- <video class="bg-video" autoplay muted loop playsinline>
            <source src="{{ asset('assets/videos/intro.mp4') }}" type="video/mp4">
        </video> --}}
        <img src="{{ asset('assets/images/banner_bg.jpg') }}" class="bg-video" alt="Sterling Wills & Estate Planning">

        <!-- Overlay -->
        <div class="mask d-flex align-items-center justify-content-center">
            <div class="text-white text-center">
                <h2 class="mb-3 inner-page-title">Our Story</h2>
            </div>
        </div>
    </div>

    <!-- MOBILE HEADER -->
    @include('layouts.mob_header')

    <!-- INTRO -->
    <section class="py-5 cmt10">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    {!! $story->story_desc_one !!}
                </div>
            </div>
        </div>
    </section>
    @if ($story->ap_title_one && $story->ap_desc_one)
        <section class="bg_grey page py-2 mt-3 cm10">
            <div class="container">
                <div class="row gx-5 justify-content-between">
                    <div class="col-md-12">
                        <h2 class="fw-bold text-center pb-4 mb-3 maastrix">Our Approach</h2>
                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <div class="card rounded-0 border-0">
                            <div class="card-body p-0">
                                <h3 class="fw-bold mb-3">{{ $story->ap_title_one ?? '' }}</h3>
                                <p class=" mb-0">{{ $story->ap_desc_one ?? '' }}</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <div class="card rounded-0 border-0">
                            <div class="card-body p-0">
                                <h3 class="fw-bold mb-3">{{ $story->ap_title_two ?? '' }}</h3>
                                <p class=" mb-0">{{ $story->ap_desc_two ?? '' }}</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-4 col-xs-12">
                        <div class="card rounded-0 border-0">
                            <div class="card-body p-0">
                                <h3 class="fw-bold mb-3">{{ $story->ap_title_three ?? '' }}</h3>
                                <p class=" mb-0">{{ $story->ap_desc_three ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- FULL WIDTH IMAGE -->
    {{-- <section class="cta">
        <div class="cta-image">
            <img src="{{ asset('assets/images/story.jpg') }}" alt="Our story" class="img-fluid w-100">
        </div>
    </section> --}}

    <!-- CONTENT -->
    <section class="py-5 mb-6 cm10">
        <div class="container">
            <div class="row gx-2 justify-content-between">
                <!-- Left -->
                <div class="col-md-12">
                    {!! $story->story_desc_two !!}
                </div>

                <!-- Full width -->
                <div class="col-12  d-none">
                    <p>
                        With thoughtful guidance and unwavering support, our focus at Sterling Wills has always been to
                        provide peace of mind for today and security for the future.
                    </p>
                </div>

                <!-- VALUES -->
                <div class="col-md-6 text-center  d-none">
                    <i class="fa fa-podcast fa-4x mb-3 text-secondary"></i>
                    <h2 class="fw-bold fs-3 mb-3">
                        Our Values
                    </h2>

                    <p>
                        We are committed to honesty, clarity, and care. Every client is treated with respect, and every
                        plan is created with attention to detail and long-term security in mind.
                    </p>
                </div>

                <!-- EXPERIENCE -->
                <div class="col-md-6 text-center d-none">
                    <i class="fa fa-user-secret fa-4x mb-3 text-secondary"></i>
                    <h2 class="fw-bold fs-3 mb-3">
                        Our Experience
                    </h2>

                    <p>
                        Years of industry experience allow us to provide reliable, compliant, and compassionate support,
                        ensuring our clients feel confident and protected at every stage.
                    </p>
                </div>

            </div>
        </div>
    </section>

@endsection
