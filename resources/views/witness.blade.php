@extends('layouts.app')
@section('title', 'Witnesses')
@section('meta_title', 'Will Witnesses Explained | Legal Witness Requirements UK | Sterling Wills')
@section('meta_description',
    'Learn who can legally witness a will in the UK, the rules to follow, and how to avoid
    common mistakes. Clear guidance from Sterling Wills & Estate Planning.')

@section('content')

    <div class="services text-center">
        <!-- HERO -->
        <div class="services text-center">
            {{-- <video class="bg-video" autoplay muted loop playsinline>
            <source src="{{ asset('assets/videos/intro.mp4') }}" type="video/mp4">
        </video> --}}
            <img src="{{ asset('assets/images/banner_bg.jpg') }}" class="bg-video" alt="Sterling Wills & Estate Planning">

            <div class="mask">
                <div class="text-white">
                    <h2 class="mb-3 inner-page-title">Witnesses</h2>
                </div>
            </div>
        </div>

        @include('layouts.mob_header')
    </div>

    <!-- INTRO -->
    <section class="py-2 cm10">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    {!! $witness->w_desc_one !!}
                </div>
            </div>
        </div>
    </section>

    <!-- WHY WITNESSES -->
    <section class="py-4 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    {!! $witness->w_desc_two !!}

                </div>
            </div>
        </div>
    </section>

    <!-- RULES -->
    <section class="py-5 mb-6 cmt10">
        <div class="container">
            <div class="row align-items-center g-5">

                <!-- Left -->
                <div class="col-md-6">
                    {!! $witness->w_desc_three !!}
                </div>

                <!-- Right -->
                <div class="col-md-6 text-center">
                    <img src="{{ $witness->w_img }}" alt="Will witnesses"
                        class="img-fluid rounded-0 shadow-sm d-none d-md-block"
                        style="max-height: 350px; object-fit: cover;">
                </div>

            </div>
        </div>
    </section>

@endsection
