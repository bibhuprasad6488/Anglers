@extends('layouts.app')
@section('title', 'Properties')
@section('meta_title', '')
@section('meta_description', '')

@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />

    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/litepicker.js"></script>
    <style>
        .swiper-button-next,
        .swiper-button-prev {
            color: #fff !important;
            font-weight: 600;
        }
    </style>
    <div class="contact_page" class="text-center">
        <!-- Overlay (optional dark mask) -->
        <div class="mask">

            <form action="{{ route('search.result') }}" method="GET"
                class="form-inline d-flex justify-content-center align-items-center gap-4 flex-wrap p-5 rounded-3 shadow-sm search-form-one">
                @csrf
                <div class="form-group">
                    <h4>
                        ▷ Browse Our <br><span> Cabin Selection </span> <span title="required">*</span>
                    </h4>
                </div>
                <div class="form-group">
                    <label class="text-white">Check In</label>
                    <input id="check_in_date" value="" placeholder="Check-in Date" required="required" type="date"
                        name="check_in_date" class="form-control" autocomplete="off">
                    <input type="hidden" name="category" value="{{ $cat->slug }}">
                </div>
                <div class="form-group">
                    <label class="text-white">Check Out</label>
                    <input id="check_out_date" value="" placeholder="Check-out Date" required="required"
                        type="date" name="check_out_date" class="form-control" autocomplete="off">
                </div>

                <div class="form-group">
                    <input type="submit" class="btn book-cabin-btn" value="Search">
                </div>
            </form>
        </div>

        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>

    <section class="section ">
        <div class="container py-5">
            {{-- <h2 class="text-center mb-5 maastrix">Our Services</h2> --}}
            @foreach ($properties as $k => $p)
                <div class="row g-4 py-5">
                    <div class="col-md-8">
                        <a href="{{ route('property.details', $p->slug) }}" class="text-decoration-none">
                            <div class="card service-card h-100 rounded-0 border-0">
                                <div class="card-body d-flex flex-column justify-content-center align-items-start gap-3">
                                    <div>
                                        <h2>{{ $p->title }}</h2>
                                    </div>
                                    <div class="text-muted">
                                        <p>{{ Str::limit($p->short_desc, 350, '...') }}</p>
                                    </div>
                                    <div><a href="{{ route('property.details', $p->slug) }}#booking-form-{{ $p->id }}"
                                            class="btn book-cabin-btn">Check
                                            Availability</a></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">

                        <div class="slider">
                            <div class="slides">
                                @foreach ($p->images as $image)
                                    <img src="{{ $image->img_path }}" class="slide {{ $loop->first ? 'active' : '' }}"
                                        alt="Property Image">
                                @endforeach
                            </div>

                            <button class="prev">❮</button>
                            <button class="next">❯</button>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            document.querySelectorAll(".slider").forEach(function(slider) {

                let currentSlide = 0;
                const slides = slider.querySelectorAll(".slide");

                function showSlide(index) {
                    if (index >= slides.length) {
                        currentSlide = 0;
                    } else if (index < 0) {
                        currentSlide = slides.length - 1;
                    } else {
                        currentSlide = index;
                    }

                    slides.forEach(slide => slide.classList.remove("active"));
                    slides[currentSlide].classList.add("active");
                }

                slider.querySelector(".next").addEventListener("click", function() {
                    showSlide(currentSlide + 1);
                });

                slider.querySelector(".prev").addEventListener("click", function() {
                    showSlide(currentSlide - 1);
                });

                setInterval(function() {
                    showSlide(currentSlide + 1);
                }, 3000);

            });

        });
    </script>
@endpush
