@extends('layouts.app')
@section('title', 'Contact Us')
@section('meta_title', $contactPage->meta_title ?? '')
@section('meta_description', $contactPage->meta_desc ?? '')

@section('content')

    <div class="contact_page" class="text-center">
        <div class="mask">
            <div class="text-white">
                <h2 class="mb-3 inner-page-title text-white">{{ $contactPage->title }}</h2>
            </div>
        </div>

        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>

    @include('cta_common')

@endsection
