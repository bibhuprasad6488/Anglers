@extends('layouts.app')
@section('title', 'Terms of Use')

@section('content')

    <div class="contact_page">
        <div class="container py-5">
            <div class="text-white text-center">
                <h2 class="inner-page-title text-white">Terms of Use</h2>
            </div>
        </div>

        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>
    <section class=" mb-6 cm10">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {!! $term->content ?? '' !!}
                </div>
            </div>
        </div>
    </section>
@endsection
