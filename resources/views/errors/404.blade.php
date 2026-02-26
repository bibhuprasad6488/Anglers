@extends('layouts.app')
@section('title', '404 Not Found')

@section('content')

    <div class="services text-center">
        <!-- HERO -->
        <div class="services text-center">
            <img src="{{ asset('assets/images/404.jpg') }}" class="bg-video"
                alt="Sterling Wills & Estate Planning">

            <div class="mask">
                <div class="text-white">
                    {{-- <h1 class="mb-3 inner-page-title">404</h1> --}}
                </div>
            </div>
        </div>

        @include('layouts.mob_header')
    </div>

    <section class="py-5 mb-6 cm10">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">

                    <h2 class="fw-bold mb-3">We can’t find that page.</h2>

                    <p class=" mb-4">
                        The link may be outdated or the address may have been entered incorrectly.
                        Rest assured, nothing is broken — we’re here to help you get back on track.
                    </p>

                    <p class="mb-5">
                        Please choose one of the options below to continue.
                    </p>

                    <div class="d-flex flex-wrap justify-content-center gap-3">

                        <a href="{{ route('home') }}" class="btn btn-dark px-4 py-2 rounded-0">
                            Home
                        </a>

                        <a href="{{ route('service.lists') }}" class="btn btn-outline-dark px-4 py-2 rounded-0">
                            Services
                        </a>

                        <a href="{{ route('price-lists') }}" class="btn btn-outline-dark px-4 py-2 rounded-0">
                            Pricing
                        </a>

                        <a href="{{ route('contact') }}" class="btn btn-outline-dark px-4 py-2 rounded-0">
                            Contact Us
                        </a>

                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
