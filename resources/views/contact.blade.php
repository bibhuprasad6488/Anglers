@extends('layouts.app')
@section('title', 'Contact Us')
@section('meta_title', $contactPage->meta_title??'')
@section('meta_description',$contactPage->meta_desc ?? '')

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
                    <h2 class="mb-3 inner-page-title text-white">{{ $contactPage->title }}</h2>
                </div>
            </div>
        </div>

        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>

    @include('cta_common')

@endsection
