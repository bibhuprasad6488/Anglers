@extends('layouts.app')
@section('title', 'Blog')
@section('meta_title', '')
@section('meta_description', '')

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
                    <h2 class="mb-3 inner-page-title text-white">NEWS</h2>
                </div>
            </div>
        </div>

        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>

    <section class="section">
        <div class="container py-5">
            {{-- <h2 class="text-center mb-5 maastrix">Our Services</h2> --}}
            <div class="row g-4">
                @foreach ($blogs as $k => $blog)
                    <div class="col-md-8 mx-auto">
                        <a href="{{ route('blog.details', $blog->slug) }}" class="text-decoration-none">
                            <div class="card service-card h-100 rounded-0 border-0">
                                <img src="{{ asset('storage/images/blog_images/' . $blog->blog_img) }}" class="card-img-top"
                                    width="100%" alt="{{ $blog->title }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-start align-items-left mb-2 p-0 border-0">
                                        <h2>{{ $blog->title }}</h2>
                                    </div>
                                    <div
                                        class="d-flex justify-content-start align-items-center mb-3 p-0 border-0 text-muted">
                                        <p>{{ Str::limit($blog->short_desc, 250, '...') }}</p>
                                    </div>
                                    <div class="d-flex">
                                        <div><a href="{{ route('blog.details', $blog->slug) }}" class="btn-outline">Read
                                                more</a></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    {{ $blogs->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        <style>
            /* 1. Hide "Showing X to Y of Z results" text */
            .pagination+div,
            .pagination-info,
            .small.text-muted {
                display: none !important;
            }

            /* 2. Center align pagination */
            .pagination {
                justify-content: center;
            }

            /* 3. Space between pagination buttons */
            .pagination .page-item {
                margin: 0 6px;
            }


            /* 4. Base pagination button styling */
            .pagination .page-link {
                color: #555;
                border: 1px solid #ddd;
                border-radius: 4px;
                padding: 6px 12px;
                font-size: 16px;
                /* try 16–18px */
                font-weight: 500;
            }

            /* 5. Active page styling */
            .pagination .page-item.active .page-link {
                background-color: #e0e0e0;
                /* grey */
                border-color: #ccc;
                color: #000;
                font-size: 17px;
                font-weight: 600;
            }

            /* 6. Hover effect (optional but polished) */
            .pagination .page-link:hover {
                background-color: #f2f2f2;
                color: #000;
            }

            /* 7. Disabled state cleanup */
            .pagination .page-item.disabled .page-link {
                color: #aaa;
                background-color: #fafafa;
                border-color: #eee;
            }

            /* Optional: arrows a bit bolder */
            .pagination .page-link[aria-label="Next »"],
            .pagination .page-link[aria-label="« Previous"],
            .pagination .page-link[rel="next"] {
                font-size: 18px;
            }
        </style>
    </section>
@endsection
