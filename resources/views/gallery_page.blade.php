@extends('layouts.app')
@section('title', 'Gallery')
@section('meta_title', 'Gallery')
@section('meta_description',
    'Check out our beautiful gallery that includes pictures of our top cabin rentals on Lake
    Texoma.')
@section('meta_keyword', '')
@section('content')
    <style>
        .swiper-slide img {
            /* width: 600px; */
            height: 600px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
    <style>
        .slide2 .mini {
            height: 200px;
            width: 400px !important;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
    <div class="contact_page" class="text-center">
        <!-- HERO -->
        <div class="contact_page" class="text-center">
            <div class="mask">
                <div class="text-white">
                    <h2 class="mb-3 inner-page-title text-white">Gallery</h2>
                </div>
            </div>
        </div>

        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>
    <section class="section about_us py-5">
        <div class="container">
            <div class="row g-4 py-4">
                <div class="col-lg-6 col-md-12 mx-auto">
                    <div class="swiper gallerySwiper">
                        <div class="swiper-wrapper">

                            @foreach ($galleries as $gallery)
                                <div class="swiper-slide">
                                    <img src="{{ $gallery->img_path }}" class="img-fluid w-100">
                                </div>
                            @endforeach

                        </div>

                        <!-- Navigation -->
                        {{-- <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div> --}}

                        <!-- Pagination -->
                        {{-- <div class="swiper-pagination"></div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
        <div class="container-fluid">
            <div class="row g-4 py-4">
                <div class="col-md-12 mx-auto">
                    <div class="swiper gallerySwiper1">
                        <div class="swiper-wrapper">

                            @foreach ($galleries as $gallery)
                                <div class="swiper-slide slide2">
                                    <img src="{{ $gallery->img_path }}" class="img-fluid w-100 mini">
                                </div>
                            @endforeach

                        </div>

                        <!-- Navigation -->
                        {{-- <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div> --}}

                        <!-- Pagination -->
                        {{-- <div class="swiper-pagination"></div> --}}
                    </div>
                </div>
            </div>
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
    <script>
        var swiper = new Swiper(".gallerySwiper1", {
            loop: true,
            spaceBetween: 3,
            slidesPerView: 3,
            centeredSlides: true,

            autoplay: {
                delay: 2000,
                disableOnInteraction: false,
            },

            // navigation: {
            //     nextEl: ".swiper-button-next",
            //     prevEl: ".swiper-button-prev",
            // },

            // pagination: {
            //     el: ".swiper-pagination",
            //     clickable: true,
            // },

            breakpoints: {
                320: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 3
                },
                1024: {
                    slidesPerView: 9
                }
            }
        });
    </script>
@endpush
