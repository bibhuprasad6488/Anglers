@extends('layouts.app')
@section('title', 'Insights')
@section('meta_title', 'Insights | Will Writing & Estate Planning | Sterling Wills')
@section('meta_description',
    'Read expert insights on will writing & estate planning from Sterling Wills. Guidance on
    wills, trusts, LPAs, and protecting your legacy.')

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
                    <h2 class="mb-3 inner-page-title">Case Study</h2>
                    <p></p>
                </div>
            </div>
        </div>

        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>

    <section class="section page cmt10 text-center">
        <div class="container">
            <div class="row g-4">

                <!-- RIGHT TEXT BOXES -->
                <div class="col-xs-12">
                    <div class="d-flex flex-column h-100 gap-4">

                        <div class="feature-box flex-fill">
                            <h2 class="text-center ">Overview...</h2>
                            <p>Welcome to the <b>Sterling Wills Insights</b> hub — your source for expert guidance,
                                practical advice, and up-to-date information on <b>will writing, estate planning, trusts,
                                    and lasting powers of attorney.</b> Whether you’re just beginning your planning journey
                                or reviewing existing arrangements, our insights are designed to help you make informed
                                decisions with confidence.</p>
                            <p>
                                Here you’ll find easy-to-understand articles, guides, and explanations covering key topics
                                such as preparing a will, understanding estate taxes, choosing the right trust structure,
                                and knowing when to set up lasting powers of attorney. Our content delivers clarity on
                                complex legal topics, helping you stay informed about best practices and changes in
                                legislation that may affect your plans.
                            </p>
                            <p>We believe that good estate planning begins with the right knowledge, so our insights are
                                written with you in mind — practical, relevant, and focused on real-life needs. Each piece
                                is created to empower you to take the next step with confidence and peace of mind.</p>
                            <p>
                                Bookmark this page and check back regularly for fresh updates and expert commentary. At
                                Sterling Wills, we’re committed not only to providing professional services but also to
                                equipping you with the understanding you need to protect what matters most.
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="section page">
        <div class="container">
            <div class="row g-4">

                <!-- RIGHT TEXT BOXES -->
                <div class="col-xs-12">
                    <div class="d-flex flex-column h-100 gap-4">

                        <div class="feature-box flex-fill border-bottom border-secondary p-3">
                            <div class="fw-bold fs-5 mb-2">Filter:</div>

                            <form action="{{ route('blogs') }}" method="get">
                                {{-- Search bar --}}
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control border border-secondary rounded-0"
                                        name="search" placeholder="Search..." value="{{ $search }}">
                                    <button class="btn btn-secondary mx-1" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <a href="{{ route('blogs') }}" class="btn btn-secondary rounded-0">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>

                                {{-- Topic buttons --}}
                                <div class="d-flex flex-wrap gap-2">
                                    {{-- All topics --}}
                                    <a class="btn btn-outline-secondary text-dark rounded-0
                                            @if (!isset($topic)) active text-white @endif"
                                        href="{{ route('blogs') }}">
                                        All
                                    </a>

                                    {{-- Individual topics --}}
                                    @foreach ($topics as $t)
                                        <a class="btn btn-outline-secondary rounded-0
                                            @if (isset($topic) && $topic->id === $t->id) active text-white @endif"
                                            href="{{ route('blogs', array_merge(request()->query(), ['topic' => $t->slug])) }}">
                                            {{ $t->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            {{-- <h2 class="text-center mb-5 maastrix">Our Services</h2> --}}
            <div class="row g-4">
                @foreach ($blogs as $k => $blog)
                    <div class="col-md-4 px-5 py-4">
                        <a href="{{ route('blog.details', $blog->slug) }}" class="text-decoration-none">
                            <div class="card service-card h-100 rounded-0 border-0 ">
                                <img src="{{ asset('storage/images/case_studies/' . $blog->image) }}" class="card-img-top"
                                    width="100" height="200" alt="{{ $blog->title }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-start align-items-left mb-2 p-0 border-0">
                                        <div
                                            class="text-dark fw-bold @if ($k == 0) fs-5 @else fs-5 @endif  text-decoration-none">
                                            {{ $blog->title }}</div>
                                    </div>
                                    <div class="d-flex justify-content-start align-items-center mb-3 p-0 border-0">
                                        <p>{{ Str::limit($blog->short_desc, 20, '...') }}</p>
                                    </div>
                                    <div class="d-flex">
                                        <div><i class="fa fa-calendar mx-1"></i>
                                            {{ \Carbon\Carbon::parse($blog->created_at)->format('d-m-Y') }}</div>
                                        <div class="ms-auto"><i class="fa fa-arrow-right" aria-hidden="true"></i>
                                        </div>
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


    @include('cta_common')

@endsection
