@extends('layouts.app')
@section('title', $blog->title)
@section('meta_title', $blog->meta_title ?? '')
@section('meta_description', $blog->meta_desc ?? '')

@section('content')

    <div class="contact_page" class="text-center">
        <!-- HERO -->
        <div class="contact_page" class="text-center">
            {{-- <video class="bg-video" autoplay muted loop playsinline>
            <source src="{{ asset('assets/videos/intro.mp4') }}" type="video/mp4">
        </video> --}}
            {{-- <img src="{{ asset('assets/images/banner_bg.jpg') }}" class="bg-video" alt="Sterling Wills & Estate Planning"> --}}

            <!-- Overlay (optional dark mask) -->
            <div class="mask">
                <div class="text-white">
                    <h1 class="mb-3 inner-page-title text-white">{{ $blog->title }}</h1>
                </div>
            </div>
        </div>

        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>

    <section class="section page mt-4 mb-4 cm10">
        <div class="container mt-4">
            <div class="row ">
                <div class="col-md-8 mx-auto b-details">

                    <h2>{{ $blog->title }}</h2>
                    <h4 class="mb-3 text-center text-muted fs-2">
                        {{ \Carbon\Carbon::parse($blog->created_at)->format('M d, Y') }}</h4>
                    <img src="{{ $blog->blog_img }}" alt="{{ $blog->title }}" class="img-fluid rounded" width="100%"
                        height="500">
                    <p class="mt-3 text-muted">
                        {{ $blog->short_desc }}
                    </p>
                    <h2><span class="text-dark ltc">Lake Texoma Cabin Rentals - </span>{{ $siteSetting->site_title }}</h2>
                    <div>
                        {!! $blog->long_desc !!}
                    </div>
                </div>
                <div class="col-md-8 mx-auto">
                    <div class="d-flex  space-between align-items-center mt-4 mb-4">
                        @if ($previous)
                            <div class="flex-fill">
                                <a href="{{ route('blog.details', $previous->slug) }}" class="text-decoration-none">
                                    <h2 class="fs-6 m-0 p-0">
                                        Previous Post </h2>
                                    <h2 class="fs-5 p-0 m-0">
                                        {{ $previous->title }}
                                    </h2>
                                </a>
                            </div>
                        @endif
                        @if ($next)
                            <div class="flex-fill justify-content-end ">
                                <a href="{{ route('blog.details', $next->slug) }}" class="text-decoration-none">
                                    <h2 class="fs-6 m-0 p-0">
                                        Next Post </h2>
                                    <h2 class="fs-5 p-0 m-0">
                                        {{ $next->title }}
                                    </h2>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
