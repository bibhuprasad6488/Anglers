@extends('layouts.app')
@section('title', 'Gallery')
@section('meta_title', 'Gallery')
@section('meta_description',
    'Check out our beautiful gallery that includes pictures of our top cabin rentals on Lake
    Texoma.')
@section('meta_keyword', '')
@section('content')

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
            color: #666;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 6px 12px;
            font-size: 16px;
            /* try 16–18px */
            font-weight: 500;
        }

        /* 5. Active page styling */
        .pagination .page-item.active .page-link {
            background-color: #6d7743;
            /* grey */
            border-color: #ccc;
            color: #fff;
            font-size: 17px;
            font-weight: 500;
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
    <div class="contact_page" class="text-center">
        <div class="container py-5">
            <div class=" text-center">
                <h2 class="inner-page-title text-white">Gallery</h2>
            </div>
        </div>
        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>
    <section class="section about_us py-5">
        <div class="container">
            <div class="row g-2 py-4">
                @foreach ($galleries as $gallery)
                    <div class="col-lg-2 col-md-4 col-sm-6 mx-auto">
                        <a href="{{ asset('storage/images/cmspage/' . $gallery->img_path) }}" class="slide2"
                            data-fancybox="gallery">
                            <img src="{{ asset('storage/images/cmspage/' . $gallery->img_path) }}"
                                class="img-fluid w-100 mini shadow-sm">
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="row mt-4">
                <div class="col-12 d-flex justify-content-center">
                    {{ $galleries->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </section>
@endsection
