@extends('layouts.app')
@section('title', 'Properties')
@section('meta_title', '')
@section('meta_description', '')

@section('content')

    <div class="contact_page" class="text-center">
        <div class="mask">
            <div class="text-white">
                <h2 class="mb-3 inner-page-title text-white">Search Result</h2>
            </div>
        </div>
        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>


    <section class="section ">
        <div class="container py-5">
            <h5 class="mb-5">
                No accommodations found from
                {{ \Carbon\Carbon::parse($formDate)->format('F d, Y') }}
                till
                {{ \Carbon\Carbon::parse($toDate)->format('F d, Y') }}
            </h5>
        </div>
    </section>
@endsection
