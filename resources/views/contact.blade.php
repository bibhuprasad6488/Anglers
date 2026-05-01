@extends('layouts.app')
@section('title', 'Contact Us')
@section('meta_title', $contactPage->meta_title ?? '')
@section('meta_description', $contactPage->meta_desc ?? '')

@section('content')

    <div class="contact_page">
        <div class="container py-5">
            <div class="text-white text-center">
                <h2 class="inner-page-title text-white">{{ $contactPage->title }}</h2>
            </div>
        </div>



    </div>

    @include('cta_common')

@endsection
