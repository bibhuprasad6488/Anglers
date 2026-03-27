@extends('layouts.app')
@section('title', 'Blog')
@section('meta_title', '')
@section('meta_description', '')

@section('content')

    <div class="contact_page">
        <div class="container py-5">
            <div class="text-white text-center">
                <h2 class="inner-page-title text-white">NEWS</h2>
            </div>
        </div>
        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>

    <section class="section">
        <div class="container py-5">


            @foreach ($blogs as $k => $blog)
                <div class="row g-4 py-5">
                    <div class="col-md-4">

                        <div class="slider">
                            <div class="slides">
                                <img src="{{ asset('storage/images/blog_images/' . $blog->blog_img) }}" class="card-img-top"
                                    width="100%" alt="{{ $blog->title }}">
                            </div>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <div class="card service-card h-100 rounded-0 border-0">
                            <div class="d-flex flex-column justify-content-center align-items-start gap-3">
                                <a href="{{ route('blog.details', $blog->slug) }}" class="text-decoration-none">
                                    <div>
                                        <h2 class="left-align">{{ $blog->title }}</h2>
                                    </div>
                                    <div class="taj">
                                        <p>{{ Str::limit($blog->short_desc, 320, '...') }}</p>
                                    </div>
                                </a>
                                <div>
                                    <a href="{{ route('blog.details', $blog->slug) }}" class="btn book-cabin-btn">View
                                        Details</a>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            @endforeach


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
