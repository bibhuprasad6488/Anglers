@extends('layouts.app')
@section('title', trim($resourcePage->meta_title) ?? ($resourcePage->title ?? 'Resources'))
@section('meta_title', $resourcePage->meta_title ?? '')
@section('meta_description', $resourcePage->meta_desc ?? '')
@section('meta_keyword', $resourcePage->meta_key ?? '')
@section('content')

    <div class="contact_page" class="text-center">
        <div class="container py-5">
            <div class="text-white text-center">
                <h2 class="inner-page-title text-white">{{ $resourcePage->title }}</h2>
            </div>
        </div>



    </div>
    <section class="section about_us py-5">
        <div class="container">
            <div class="row ">

                <!-- LEFT IMAGE BOX -->
                <div class="col-md-7 ">
                    <div class="d-flex flex-column h-100 gap-4">
                        <div class="feature-box flex-fill">
                            <h2>{{ $resourcePage->setion_one_title }}</h2>
                            {!! $resourcePage->setion_one_desc !!}
                        </div>
                    </div>
                </div>

                <!-- RIGHT TEXT BOXES -->
                <div class="col-md-5 ">
                    <div class="feature-box h-100 text-lg-right">
                        <img src="{{ $resourcePage->setion_one_img }}" alt="{{ $resourcePage->setion_one_title }}"
                            class="img-fluid feature-image">
                    </div>
                </div>


            </div>
        </div>
    </section>

    <section class="section about_us">
        <div class="container">
            <div class="row">

                <!-- LEFT IMAGE BOX -->
                <div class="col-md-5 ">
                    <div class="feature-box h-100 text-lg-right">
                        <img src="{{ $resourcePage->setion_two_img }}" alt="{{ $resourcePage->setion_two_title }}"
                            class="img-fluid feature-image">
                    </div>
                </div>

                <!-- RIGHT TEXT BOXES -->
                <div class="col-md-7 ">
                    <div class="d-flex flex-column h-100 gap-4">
                        <div class="feature-box flex-fill">
                            <h2>{{ $resourcePage->setion_two_title }}</h2>
                            {!! $resourcePage->setion_two_desc !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section  pb-5">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-12">
                    <h2 class=" mb-3 center-align">
                        {{ $resourcePage->resource_title }}
                    </h2>

                    {!! $resourcePage->resource_desc !!}
                </div>
                <div class="col-lg-12">
                    <div class="d-flex flex-row h-100 gap-1 btn-box-wrap justify-content-center">
                        <div class="feature-box">
                            <a href="{{ $resourcePage->resource_btn_one_link }}"
                                class="btn book-cabin-btn">{{ $resourcePage->resource_btn_one_text }}</a>
                        </div>
                        <div class="feature-box">
                            <a href="{{ $resourcePage->resource_btn_one_link }}"
                                class="btn book-cabin-btn">{{ $resourcePage->resource_btn_one_text }}</a>
                        </div>
                        <div class="feature-box">
                            <a href="{{ $resourcePage->resource_btn_one_link }}"
                                class="btn book-cabin-btn">{{ $resourcePage->resource_btn_one_text }}</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
