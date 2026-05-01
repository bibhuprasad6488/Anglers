@extends('layouts.app')
@section('title', 'Thank You')

@section('content')
    @php
        $siteSetting = \App\Models\SiteSetting::find(1);
    @endphp

    <div class="contact_page" class="text-center">
        <div class="container">
            <div class=" text-center my-5">
                <h2 class="mb-3 inner-page-title text-white">Thank You</h2>
            </div>
        </div>


    </div>

    <section class="py-5 bg-light d-flex align-items-center cm10">
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
            <h3 class="fw-bold mb-3">Thank You!</h3>

            <!-- Message -->
            <p class="mb-4 fs-5 text-muted">
                {{ $siteSetting->footer_text_one }}
            </p>

            <!-- Optional Call-to-Action -->
            <a href="{{ route('home') }}" class="btn book-cabin-btn">Back to Home</a>

        </div>
    </section>
@endsection
