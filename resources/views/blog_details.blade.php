@extends('layouts.app')
@section('title', $blog->title)
@section('meta_title', $blog->meta_title ?? '')
@section('meta_description', $blog->meta_desc ?? '')

@section('content')

    <!-- HERO -->
    <section class="section page my-6">
        <div class="container">
            <div class="row g-4"></div>
        </div>

    </section>

    <!-- MOB HEADER -->
    @include('layouts.mob_header')

    <section class="section page mt-4 mb-4 cm10">
        <div class="container mt-4">
            <div class="row g-4">
                <!-- LEFT TEXT BOXES -->
                <div class="col-sm-6 col-xs-12">
                    <div class="d-flex flex-column h-100 gap-4 mt-4 mb-4 py-4 px-0">
                        <h1>{{ $blog->title }}</h1>
                        <div class="d-flex flex-row h-100 gap-4">
                            <div class=""><i class="fa fa-user" aria-hidden="true"></i> {{ $blog->user?->name }}
                            </div>
                            <div><i class="fa fa-calendar mx-1"></i>
                                {{ \Carbon\Carbon::parse($blog->created_at)->format('M Y') }}</div>
                            <div class="feature-box flex-fill">
                                {!! $blog->description !!}
                            </div>

                        </div>

                        <div class="feature-box flex-fill">

                        </div>

                    </div>
                </div>
                <!-- RIGHT TEXT BOXES -->
                <div class="col-sm-6 col-xs-12">
                    <img src="{{ $blog->image }}" alt="{{ $blog->title }}" class="img-fluid rounded" width="100%"
                        height="500">
                    <div class="d-flex flex-column h-100 gap-4">

                        <div class="feature-box flex-fill">
                            {!! $blog->description !!}
                        </div>

                    </div>
                </div>
                <div class="col-md-8">
                    <div class="py-2 px-1">
                        {!! $blog->long_desc !!}
                    </div>
                </div>
                <div class="col-md-4">

                    {{-- <div class="my-2">
                        <a href="{{ route('blogs') }}" class="text-dark">< Back to List</a>
                    </div> --}}
                    {{-- ( d-none d-md-block ) For hide on mobile --}}
                    <div class="mb-5 d-none">
                        <p class="fs-4">Category</p>
                        <hr>
                        @foreach ($topics as $t)
                            <a class="btn btn-outline-secondary rounded-0 px-4 border-0"
                                href="{{ route('blogs', array_merge(request()->query(), ['topic' => $t->slug])) }}">
                                {{ $t->name }}
                            </a>
                        @endforeach
                    </div>
                    <div class="mb-4">
                        <p class="fs-4 fw-thin">Featured Posts</p>
                        <hr>
                        @foreach ($relatedBlogs as $b)
                            <div class="d-flex align-items-start gap-3 mb-3 mt-4">

                                <!-- Image -->
                                <a href="{{ route('blog.details', $b->slug) }}" class="text-decoration-none">
                                    <!-- Image -->
                                    <div class="flex-shrink-0 featured-img">
                                        <img src="{{ $b->image }}" alt="{{ $b->title }}" class="img-fluid rounded">
                                    </div>
                                </a>
                                <!-- Content -->
                                <div class="flex-grow-1">
                                    <div class="text-muted small mb-1">
                                        <i class="fa fa-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($b->created_at)->format('d M Y') }}
                                    </div>

                                    <a href="{{ route('blog.details', $b->slug) }}" class="text-decoration-none">
                                        <div class="fw-bold fs-6 text-dark">
                                            {{ $b->title }}
                                        </div>
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>
                    <style>
                        .featured-img {
                            width: 120px;
                            height: 90px;
                            overflow: hidden;
                        }

                        .featured-img img {
                            width: 100%;
                            height: 100%;
                            object-fit: cover;
                        }
                    </style>
                </div>
            </div>
        </div>
    </section>


@endsection
