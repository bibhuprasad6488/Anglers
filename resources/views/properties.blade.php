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
                class="d-flex flex-column flex-lg-row justify-content-center align-items-center gap-4 p-5 rounded-3 shadow-sm search-form-one">
                @csrf
                <div class="form-group">
                    <h4>
                        ▷ Browse Our <br><span> Cabin Selection </span> <span title="required">*</span>
                    </h4>
                </div>
                <div class="form-group">
                    <label class="text-white">Check In</label>
                    <input id="check_in_date" type="date" name="check_in_date" class="form-control" autocomplete="off"
                        required value="{{ request('check_in_date') }}">

                    <input type="hidden" name="category_id" value="{{ $cat->id }}">
                </div>

                <div class="form-group">
                    <label class="text-white">Check Out</label>
                    <input id="check_out_date" type="date" name="check_out_date" class="form-control" autocomplete="off"
                        required value="{{ request('check_out_date') }}">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn book-cabin-btn">Search</button>
                </div>
            </form>
        </div>

        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>

    <section class="section ">
        <div class="container">
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
                                    <div class="text-muted">
                                        <h5 class="fw-bold">Price $ {{ $p->price_per_night }} per night</h5>
                                    </div>
                                    <div>
                                        @if ($p->final_price)
                                            <a href="{{ route('property.details', $p->slug) }}#booking-form-{{ $p->id }}"
                                                class="btn book-cabin-btn">Book
                                                Now</a>
                                        @else
                                            <a href="{{ route('property.details', $p->slug) }}#booking-form-{{ $p->id }}"
                                                class="btn book-cabin-btn">Check
                                                Availability</a>
                                        @endif
                                    </div>
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

            const checkIn = document.getElementById("check_in_date");
            const checkOut = document.getElementById("check_out_date");

            const today = new Date();
            const todayFormatted = today.toISOString().split("T")[0];

            const tomorrow = new Date();
            tomorrow.setDate(today.getDate() + 1);
            const tomorrowFormatted = tomorrow.toISOString().split("T")[0];

            /* disable past dates */
            checkIn.min = todayFormatted;

            /* if no request value then set default */
            if (!checkIn.value) {
                checkIn.value = todayFormatted;
            }

            /* set checkout min based on checkin */
            let checkInDate = new Date(checkIn.value);
            let nextDay = new Date(checkInDate);
            nextDay.setDate(nextDay.getDate() + 1);
            let nextDayFormatted = nextDay.toISOString().split("T")[0];

            checkOut.min = nextDayFormatted;

            if (!checkOut.value) {
                checkOut.value = nextDayFormatted;
            }

            /* when checkin changes */
            checkIn.addEventListener("change", function() {

                let checkInDate = new Date(this.value);

                let nextDay = new Date(checkInDate);
                nextDay.setDate(nextDay.getDate() + 1);

                let nextDayFormatted = nextDay.toISOString().split("T")[0];

                checkOut.min = nextDayFormatted;
                checkOut.value = nextDayFormatted;

            });

            /* prevent invalid checkout */
            checkOut.addEventListener("change", function() {

                if (checkOut.value <= checkIn.value) {
                    alert("Checkout date must be after check-in date");
                    checkOut.value = "";
                }

            });

        });
    </script>
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
