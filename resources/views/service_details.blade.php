@extends('layouts.app')
@section('title', $service->name)
@section('meta_title', $service->meta_title ?? '')
@section('meta_description', $service->meta_desc ?? '')

@section('content')

    <div class="services" class="text-center">
        <!-- HERO -->
        <div class="services" class="text-center">
            {{-- <video class="bg-video" autoplay muted loop playsinline>
            <source src="{{ asset('assets/videos/intro.mp4') }}" type="video/mp4">
        </video> --}}
            <img src="{{ $service->banner_image }}" class="bg-video" alt="{{ $service->name }}">
            <!-- Overlay (optional dark mask) -->
            <div class="mask d-none">
                <div class="text-white">
                    <h2 class="mb-3 inner-page-title">We offer various services</h2>
                    <p><b>Entertainment law services in Sydney that protect your creative intellectual property to develop
                            and produce your creative projects.</b></p>
                </div>
            </div>
        </div>

        <!-- MOB HEADER -->
        @include('layouts.mob_header')
    </div>

    <section class="section page">
        <div class="container">
            <div class="row gx-5 justify-content-between">

                <div class="col-xs-12">
                    <h2 class="text-center text-uppercase">{{ $service->name }}</h2>
                </div>
                <!-- LEFT TEXT BOXES -->
                <div class="col-sm-3 col-xs-12 mb-5 pb-5">
                    <div class="d-flex flex-column h-100 p-2" style="border: 2px solid gray; height:max-content !important;">

                        <div class="feature-box flex-fill">
                            @foreach ($services as $s)
                                <p class="mb-3">
                                    <a href="{{ route('service.details', $s->slug) }}"
                                        class="d-block text-decoration-none text-secondary {{ $s->id == $service->id ? 'fw-bold ' : '' }}">
                                        {{ $s->name }}
                                    </a>
                                </p>
                            @endforeach

                        </div>

                    </div>
                </div>
                <!-- RIGHT TEXT BOXES -->
                <div class="col-sm-9 col-xs-12">
                    <div class="d-flex flex-column h-100">

                        <div class="feature-box flex-fill">
                            {!! $service->description !!}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <h2 class="text-center mb-5 maastrix">Our expert specialist services will take care of the rest:</h2>
            <div class="row g-4">
                @foreach ($services as $service)
                    <div class="col-md-4 px-5 py-4">
                        <div class="card service-card h-100 text-center rounded-0">
                            <img src="{{ $service->service_image }}" class="card-img-top">
                            <div class="card-body text-center">
                                <h5 class="service-title">
                                    {{ $service->name }}
                                </h5>

                                <div class="service-divider"></div>

                                <a href="{{ route('service.details', $service->slug) }}"
                                    class="btn btn-outline-dark rounded-0 mt-auto">
                                    FIND OUT MORE >
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('cta_common')
@endsection
