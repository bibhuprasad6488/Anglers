@extends('layouts.app')
@section('title', 'Properties')
@section('meta_title', '')
@section('meta_description', '')

@section('content')
    <style>
        .swiper-button-next,
        .swiper-button-prev {
            color: #fff !important;
            font-weight: 600;
        }
    </style>
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
                    <h2 class="mb-3 inner-page-title text-white">Properties</h2>
                </div>
            </div>
        </div>

        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>

    <section class="section ">
        <div class="container py-5">
            {{-- <h2 class="text-center mb-5 maastrix">Our Services</h2> --}}
            @foreach ($properties as $k => $p)
                <div class="row g-4 py-5">
                    <div class="col-md-8">
                        <a href="{{ route('blog.details', $p->slug) }}" class="text-decoration-none">
                            <div class="card service-card h-100 rounded-0 border-0">
                                <div class="card-body d-flex flex-column justify-content-center align-items-start gap-3">
                                    <div>
                                        <h2>{{ $p->title }}</h2>
                                    </div>
                                    <div class="text-muted">
                                        <p>{{ Str::limit($p->short_desc, 350, '...') }}</p>
                                    </div>
                                    <div><a href="{{ route('blog.details', $p->slug) }}" class="btn book-cabin-btn">Check
                                            Availability</a></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">

                        <div class="swiper gallerySwiper">
                            <div class="swiper-wrapper">

                                @foreach ($p->images as $img)
                                    <div class="swiper-slide">
                                        <img src="{{ $img->img_path }}" class="img-fluid w-100">
                                    </div>
                                @endforeach

                            </div>

                            <!-- Navigation -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>

                            <!-- Pagination -->
                            {{-- <div class="swiper-pagination"></div> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        var swiper = new Swiper(".gallerySwiper", {
            loop: true,
            spaceBetween: 20,
            slidesPerView: 1,
            centeredSlides: true,

            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },

            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },

            breakpoints: {
                320: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 1
                },
                1024: {
                    slidesPerView: 1
                }
            }
        });
    </script>
@endpush
