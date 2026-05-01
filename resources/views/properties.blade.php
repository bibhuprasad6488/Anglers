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
        <div class="container">

            <form action="{{ route('search.result') }}" method="GET" class="row rounded-3 shadow-sm search-form-one">
                @csrf
                <div class="form-group col-12 col-md-3">
                    <h4>
                        ▷ Browse Our <br><span> Cabin Selection </span> <span title="required">*</span>
                    </h4>
                </div>
                <div class="form-group col-12 col-md-3">
                    <label class="text-white">Check In</label>
                    <input id="check_in_date" type="date" name="check_in_date" class="form-control" autocomplete="off"
                        required value="{{ request('check_in_date') }}">

                    {{-- <input type="hidden" name="category_id" value="{{ $cat->id }}"> --}}
                </div>

                <div class="form-group col-12 col-md-3">
                    <label class="text-white">Check Out</label>
                    <input id="check_out_date" type="date" name="check_out_date" class="form-control" autocomplete="off"
                        required value="{{ request('check_out_date') }}">
                </div>

                <div class="form-group col-12 col-md-3">
                    <input type="submit" class="btn book-cabin-btn" value="Search">
                </div>
            </form>
        </div>



    </div>


    <section class="section ">
        <div class="container">
            @if ($properties->isNotEmpty())
                {{-- <h2 class="text-center mb-5 maastrix">Our Services</h2> --}}
                @foreach ($properties as $k => $p)
                    <div class="row g-4 py-5">
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
                        <div class="col-md-8">
                            <a href="{{ route('property.details', $p->slug) }}" class="text-decoration-none">
                                <div class="card service-card h-100 rounded-0 border-0">
                                    <div
                                        class="card-body d-flex flex-column justify-content-center align-items-start gap-3">
                                        <div>
                                            <h2 class="left-align">{{ $p->title }}</h2>
                                        </div>
                                        <div class="taj">
                                            <p>{{ Str::limit($p->short_desc, 430, '...') }}</p>
                                        </div>
                                        <div class="text-muted">
                                            <h5 class="fw-bold">Price $ {{ $p->price_per_night }} per night</h5>
                                        </div>
                                        <div>
                                            @if ($p->final_price)
                                                <a href="{{ route('property.details', $p->slug) }}#booking-form-{{ $p->id }}"
                                                    class="btn book-cabin-btn">Book
                                                    Now</a>
                                            @else
                                                <a href="{{ route('property.details', $p->slug) }}"
                                                    class="btn book-cabin-btn">View Details</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                @endforeach
            @else
                <h4 class="my-5 py-5">There is No Property Available</h4>
            @endif
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        let checkInDate = localStorage.getItem('check_in_date');
        let checkOutDate = localStorage.getItem('check_out_date');

        document.getElementById("check_in_date").value = checkInDate;
        document.getElementById("check_out_date").value = checkOutDate;
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
