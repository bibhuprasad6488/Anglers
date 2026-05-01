@extends('layouts.app')
@section('title', 'Privacy Policy')

@section('content')

    <div class="contact_page">
        <div class="container py-5">
            <div class="text-white text-center">
                <h2 class="inner-page-title text-white">Privacy Policy</h2>
            </div>
        </div>



    </div>
    <section class=" mb-6 cm10">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {!! $privacy->content ?? '' !!}
                </div>
            </div>
        </div>
    </section>
@endsection
