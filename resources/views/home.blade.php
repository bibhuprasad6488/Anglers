@extends('layouts.app')
@section('title', trim($home_page_data->meta_title) ?? '')
@section('meta_title', $home_page_data->meta_title ?? '')
@section('meta_description', $home_page_data->meta_desc ?? '')
@section('meta_keyword', $home_page_data->meta_key ?? '')
@section('content')
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
                        <img src="{{ $home_page_data->setion_one_img }}" alt="{{ $home_page_data->setion_one_title }}" class="img-fluid feature-image">
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

    @include('cta_common')
@endsection
