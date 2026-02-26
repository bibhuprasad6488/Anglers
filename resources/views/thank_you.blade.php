@extends('layouts.app')
@section('title', 'Thank You')

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
                    <h2 class="mb-3 inner-page-title">Thank You</h2>
                    <p></p>
                </div>
            </div>
        </div>

        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>
    <section class="py-5 bg-light d-flex align-items-center">
        <div class="container text-center">

            <!-- Success Icon -->
            <div class="mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#000"
                    class="bi bi-check-circle" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 11.03a.75.75 0 0 0 1.07 0l3.992-3.992a.75.75 0 1 0-1.06-1.06L7.5 9.439 5.323 7.262a.75.75 0 0 0-1.06 1.06l2.707 2.708z" />
                </svg>
            </div>

            <!-- Heading -->
            <h2 class="fw-bold mb-3">Thank You!</h2>

            <!-- Message -->
            <p class="mb-4 fs-5 text-muted">
                Your submission has been received successfully.<br>
                One of our advisors will contact you shortly.
            </p>

            <!-- Optional Call-to-Action -->
            <a href="{{ route('home') }}" class="btn btn-dark rounded-pill px-4">Back to Home</a>
            <a href="{{ route('start.will') }}" class="btn btn-outline-dark rounded-pill px-4 ms-2">Start Another Will</a>

        </div>
    </section>
@endsection
