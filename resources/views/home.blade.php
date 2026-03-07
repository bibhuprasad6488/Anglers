@extends('layouts.app')
@section('title', trim($home_page_data->meta_title) ?? '')
@section('meta_title', $home_page_data->meta_title ?? '')
@section('meta_description', $home_page_data->meta_desc ?? '')
@section('meta_keyword', $home_page_data->meta_key ?? '')
@section('content')
    <style>
        .slide2 .mini {
            height: 200px;
            width: 400px !important;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
    <!-- HERO -->
    <div id="intro-example" class="text-center">
        {{-- <video class="bg-video" autoplay muted loop playsinline>
            <source src="{{ asset('assets/videos/intro.mp4') }}" type="video/mp4">
        </video> --}}
        <img src="{{ $home_page_data->banner_img }}" class="bg-video" alt="{{ $home_page_data->meta_title }}">

        <div class="mask">
            <div class="text-white">
                <h1 class="mt-5 banner-title">{{ $home_page_data->banner_title }}</h1>
                <h4 class="my-4 banner-subtitle">{{ $home_page_data->banner_sub_title }}</h4>

                {{-- <a class="btn btn-light btn-lg m-2 rounded-0" href="{{ route('journey') }}" role="button">View
                    Details..</a>
                <a class="btn btn-light btn-lg m-2 rounded-0" href="{{ route('contact') }}" role="button">Contact
                    us today !</a> --}}
            </div>
        </div>
    </div>

    <!-- MOB HEADER -->
    @include('layouts.mob_header')

    <section class="section about_us">
        <div class="container">
            <div class="row g-4 py-4">

                <!-- LEFT IMAGE BOX -->
                <div class="col-md-7 ">
                    <div class="d-flex flex-column h-100 gap-4">
                        <div class="feature-box flex-fill">
                            <h2>{{ $home_page_data->setion_one_title }}</h2>
                            {!! $home_page_data->setion_one_desc !!}
                        </div>
                        <div class="feature-box flex-fill">
                            <a href="{{ $home_page_data->setion_one_btn_link }}"
                                class="btn book-cabin-btn">{{ $home_page_data->setion_one_btn_text }}</a>
                        </div>
                    </div>
                </div>

                <!-- RIGHT TEXT BOXES -->
                <div class="col-md-5 ">
                    <div class="feature-box h-100 text-lg-right">
                        <img src="{{ $home_page_data->setion_one_img }}" alt="{{ $home_page_data->setion_one_title }}"
                            class="img-fluid feature-image">
                    </div>
                </div>


            </div>
        </div>
    </section>

    <section class="ctttt py-5 cm10" style="background-image:url('{{ $home_page_data->setion_two_img }}') ">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-12">
                    <h2 class=" text-white mb-3">
                        {{ $home_page_data->setion_two_title }}
                    </h2>

                    {!! $home_page_data->setion_two_desc !!}
                </div>

            </div>
        </div>
    </section>

    <section class="section ">
        <div class="container">
            <div class="row g-4 py-2">

                <!-- LEFT IMAGE BOX -->
                <div class="col-md-10 mx-auto text-center">
                    <div class="d-flex flex-column h-100 gap-4">
                        <div class="feature-box flex-fill">
                            <h2>BROWSE OUR GALLERY</h2>
                            <h4>“Find the best place to stay!”</h4>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="section">
        <div class="container-fluid">
            <div class="row g-4 py-4">
                <div class="col-md-12 mx-auto mb-4">
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
                <div class="col-md-12 text-center py-4">
                    <a href="{{ route('gallery') }}" class=" btn-outline">View All Photos</a>
                </div>
            </div>
        </div>
    </section>
    @include('cta_common')
@endsection
@push('scripts')
    <script>
        var swiper = new Swiper(".gallerySwiper1", {
            loop: true,
            spaceBetween: 1,
            slidesPerView: 1,
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
                    slidesPerView: 5
                }
            }
        });
    </script>
@endpush
