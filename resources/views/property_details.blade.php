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

        .litepicker {
            font-family: inherit;
        }

        .is-today {
            background: #dbdada !important;
            color: #fff !important;
        }

        .litepicker .day-item.is-start-date,
        .litepicker .day-item.is-end-date {
            background: #ff6b6b !important;
            color: #fff;
        }

        .litepicker .day-item.is-in-range {
            background: #ffe2e2;
        }

        #booking-calendar {
            width: 100%;
            max-width: max-content;
            height: max-content;
            border: 1px solid #dddd;
            margin: 10px auto;
            overflow-x: scroll;
        }

        .litepicker {
            box-shadow: none;
        }

        .search-input {
            height: 55px;
            border-radius: 12px;
            border: 1px solid #ddd;
            padding: 10px 15px;
        }

        .duration-group {
            display: flex;
            gap: 3px;
            flex-wrap: wrap;
        }

        .duration-option {
            margin: 0;
        }

        .duration-option input {
            display: none;
        }

        .duration-option span {
            display: inline-block;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            color: #000;
            transition: all .3s ease;
            font-weight: 500;
            background: #fff;
        }

        .duration-option input:checked+span {
            background: #c4511c;
            color: #fff;
            border-color: #c59d5f;
        }

        .search-btn {
            height: 55px;
            border-radius: 12px;
            background: #c59d5f;
            border: none;
            color: #fff;
            font-weight: 600;
            transition: all .3s ease;
        }

        .search-btn:hover {
            background: #b48b4e;
            transform: translateY(-2px);
        }
    </style>
    <div class="contact_page" class="text-center">
        <!-- Overlay (optional dark mask) -->
        <div class="container">

            @if (session('success'))
                <div class="alert alert-success mx-1 mt-3 rounded-3 shadow-sm" id="success-alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger mx-1 mt-3 rounded-3 shadow-sm" id="success-alert">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('search.result') }}" method="GET" class="row  rounded-3 shadow-sm search-form-one"
                id="bookingForm">
                @csrf
                <div class="form-group col-12 col-md-3">
                    <h4>
                        ▷ Browse Our <br><span> Cabin Selection </span> <span title="required">*</span>
                    </h4>
                </div>
                <div class="form-group col-12 col-md-3">
                    <label class="text-white">Check In</label>
                    <input id="check_in_date" type="date" name="check_in_date" class="form-control" required
                        value="{{ request('check_in_date') ?? request('check_in') }}">
                    {{-- <input type="hidden" name="type_val" value="book_now"> --}}
                    <input type="hidden" name="property_id" value="{{ $property->id }}">
                    <input type="hidden" name="category_id" value="{{ $property->category_id }}">
                </div>
                @if (in_array($property->category_id, [1, 3]))
                    <div class="form-group col-12 col-md-3">
                        <label class="form-label">Duration</label>

                        <div class="duration-group">
                            <label class="duration-option">
                                <input type="radio" name="duration" value="1">
                                <span>1 Month</span>
                            </label>

                            <label class="duration-option">
                                <input type="radio" name="duration" value="2">
                                <span>2 Months</span>
                            </label>

                            <label class="duration-option">
                                <input type="radio" name="duration" value="3">
                                <span>3 Months</span>
                            </label>
                        </div>
                    </div>
                @else
                    <div class="form-group col-12 col-md-3">
                        <label class="text-white">Check Out</label>
                        <input id="check_out_date" type="date" name="check_out_date" class="form-control" required
                            value="{{ request('check_out_date') ?? request('check_out') }}">
                    </div>
                @endif

                <div class="form-group col-12 col-md-3">
                    <input type="submit" class="btn book-cabin-btn" value="Book Now" id="bookBtn">
                </div>
            </form>
        </div>



    </div>
    <section class="section ">
        <div class="container py-5">
            {{-- <h2 class="text-center mb-5 maastrix">Our Services</h2> --}}
            <div class="row ">
                <div class="col-12 col-md-12 col-lg-7 px-0 px-lg-5 mb-5">
                    <div class="slider">
                        <div class="slides">
                            @foreach ($property->images as $image)
                                <img src="{{ $image->img_path }}" class="slide {{ $loop->first ? 'active' : '' }}">
                            @endforeach
                        </div>

                        <button class="prev" onclick="prevSlide()">❮</button>
                        <button class="next" onclick="nextSlide()">❯</button>

                        <!-- Thumbnail Images -->
                        <div class="thumbnails">
                            @foreach ($property->images as $image)
                                <img src="{{ $image->img_path }}" class="thumb {{ $loop->first ? 'active' : '' }}"
                                    onclick="goToSlide({{ $loop->index }})">
                            @endforeach
                        </div>

                    </div>

                    <h2 class="text-center mt-4 d-none d-lg-block">
                        YOU'LL NEVER WANT TO LEAVE
                    </h2>
                    <p class="taj d-none d-lg-block">{{ $property->short_desc }}</p>
                </div>
                <div class="col-12 col-md-12 col-lg-5">
                    <h2 class="left-align">{{ $property->title }}</h2>
                    <p class="tag-list">{{ $property->sub_title }}</p>
                    <h2 class="mphb-details-title">Details</h2>
                    <p>{!! $property->long_desc !!}</p>
                    <p><strong>Categorie:</strong> <span class="text-dark">{{ $property->category->title }}</span></p>
                    <small class="fw-semibold"> Price per pet ${{ $property->price_per_pet }}, Maximum
                        2 dogs less than 50
                        lb. No Cats </small>
                    {{-- <h2 class="mphb-calendar-title">Availability</h2> --}}
                    {{-- <form action="{{ route('search.result') }}" method="GET"
                        class="row  rounded-3 shadow-sm search-form-one">
                        @csrf
                        <div class="form-group col-12 ">
                            <label class="text-white">Check In</label>
                            <input id="check_in" type="date" name="check_in_date" class="form-control" required
                                value="{{ request('check_in_date') ?? request('check_in') }}">
                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                            <input type="hidden" name="category_id" value="{{ $property->category_id }}">
                        </div>
                        <div class="form-group col-12 ">
                            <label class="text-white">Check Out</label>
                            <input id="check_out" type="date" name="check_out_date" class="form-control" required
                                value="{{ request('check_out_date') ?? request('check_out') }}">
                        </div>

                        <div class="form-group col-12 ">
                            <input type="submit" class="btn book-cabin-btn" value="Check Availability">
                        </div>
                    </form> --}}


                    <div id="booking-calendar" class="d-none"></div>
                    <form action="{{ route('search.result') }}" method="GET" id="booking-form-{{ $property->id }}"
                        class="rounded-3 ">
                        @csrf
                        {{-- <input type="hidden" name="type_val" value="book_now"> --}}
                        <div class="form-group col-12 ">
                            <label class="text-white">Check In</label>
                            <input id="check_in" type="date" name="check_in_date" class="form-control" required
                                value="{{ request('check_in_date') ?? request('check_in') }}" hidden>
                            <input id="check_out" type="date" name="check_out_date" class="form-control" required
                                value="{{ request('check_out_date') ?? request('check_out') }}" hidden>
                            {{-- <input type="hidden" name="property_id" value="{{ $property->id }}">
                            <input type="hidden" name="category_id" value="{{ $property->category_id }}"> --}}
                        </div>
                        <div class="form-group">
                            <input type="button" class="btn book-cabin-btn" id="bookingBtn" value="Book Now">
                        </div>
                    </form>
                    @if (isset($pricing) && !empty($pricing))
                        <div class="card mt-4 ">
                            <div class="card-header">
                                <h4>Booking Information</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-column flex-md-row justify-content-between  gap-3">
                                    <div class="flex-box">
                                        <p><small>Total Days:</small><br> {{ $pricing['total_days'] }}@if ($pricing['total_days'] > 1)
                                                days
                                            @else
                                                day
                                            @endif
                                        </p>
                                    </div>
                                    <div class="flex-box">
                                        <p><strong>Final Price:</strong><br> $ {{ $pricing['final_price'] }}</p>

                                    </div>
                                    <div class="flex-box">
                                        <a href="#" class="btn book-cabin-btn">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="ctttt py-5 cm10" style="background-image:url('{{ $home_page_data->setion_two_img }}') ">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-12">
                    <h2 class=" text-white mb-3">
                        {{ $home_page_data->setion_two_title }}
                    </h2>

                    {!! $home_page_data->setion_two_desc !!}
                </div>

            </div>
        </div>
    </section>

    @include('cta_common')
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let currentSlide = 0;

            const slides = document.querySelectorAll(".slide");
            const thumbs = document.querySelectorAll(".thumb");

            function showSlide(index) {

                if (index >= slides.length) {
                    currentSlide = 0;
                } else if (index < 0) {
                    currentSlide = slides.length - 1;
                } else {
                    currentSlide = index;
                }

                slides.forEach(slide => slide.classList.remove("active"));
                thumbs.forEach(thumb => thumb.classList.remove("active"));

                slides[currentSlide].classList.add("active");
                thumbs[currentSlide].classList.add("active");
            }

            window.nextSlide = function() {
                showSlide(currentSlide + 1);
            }

            window.prevSlide = function() {
                showSlide(currentSlide - 1);
            }

            window.goToSlide = function(index) {
                showSlide(index);
            }

            /* AUTO SLIDE */
            setInterval(function() {
                nextSlide();
            }, 3000); // change slide every 4 seconds

        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const form = document.getElementById("bookingForm");

            const checkIn = document.getElementById("check_in_date");
            const checkOut = document.getElementById("check_out_date");

            // /* -----------------------------
            //    Set default minimum dates
            // ----------------------------- */

            const today = new Date();

            const tomorrow = new Date();
            tomorrow.setDate(today.getDate() + 1);

            const tomorrowFormatted = tomorrow.toISOString().split('T')[0];

            if (checkIn) {
                checkIn.setAttribute("min", tomorrowFormatted);
            }

            if (checkOut) {
                checkOut.setAttribute("min", tomorrowFormatted);
            }

            // /* -----------------------------
            //    Load Local Storage Values
            // ----------------------------- */

            const storedCheckIn = localStorage.getItem('check_in_date');
            const storedCheckOut = localStorage.getItem('check_out_date');

            if (checkIn && storedCheckIn) {
                checkIn.value = storedCheckIn;
            }

            if (checkOut && storedCheckOut) {
                checkOut.value = storedCheckOut;
            }

            // /* -----------------------------
            //    Check-In Change
            // ----------------------------- */

            if (checkIn && checkOut) {

                checkIn.addEventListener("change", function() {

                    const selectedDate = new Date(this.value);

                    const nextDay = new Date(selectedDate);
                    nextDay.setDate(nextDay.getDate() + 1);

                    const nextDayFormatted = nextDay.toISOString().split('T')[0];

                    checkOut.min = nextDayFormatted;

                    if (
                        !checkOut.value ||
                        checkOut.value <= this.value
                    ) {
                        checkOut.value = nextDayFormatted;
                    }

                });

                checkOut.addEventListener("change", function() {

                    if (checkOut.value <= checkIn.value) {

                        alert("Checkout date must be after Check-in date");

                        checkOut.value = '';

                        checkOut.focus();
                    }

                });

            }

            // /* -----------------------------
            //    Save Dates To Local Storage
            // ----------------------------- */

            if (checkIn) {

                checkIn.addEventListener("change", function() {
                    localStorage.setItem(
                        "check_in_date",
                        this.value
                    );
                });

            }

            if (checkOut) {

                checkOut.addEventListener("change", function() {
                    localStorage.setItem(
                        "check_out_date",
                        this.value
                    );
                });

            }

            // /* -----------------------------
            //    Form Validation
            // ----------------------------- */

            if (form) {

                form.addEventListener("submit", function(e) {

                    if (checkIn && !checkIn.value) {
                        e.preventDefault();
                        alert("Please select Check-In Date.");
                        checkIn.focus();
                        return false;
                    }

                    if (checkOut && !checkOut.value) {
                        e.preventDefault();
                        alert("Please select Check-Out Date.");
                        checkOut.focus();
                        return false;
                    }

                    if (checkIn && checkOut) {

                        const checkInDate = new Date(checkIn.value);
                        const checkOutDate = new Date(checkOut.value);

                        if (checkOutDate <= checkInDate) {

                            e.preventDefault();

                            alert("Checkout date must be after Check-in date.");

                            checkOut.focus();

                            return false;
                        }
                    }

                    // /* Duration Validation */

                    const durationRadios = document.querySelectorAll(
                        'input[name="duration"]'
                    );

                    if (durationRadios.length > 0) {

                        const selectedDuration = document.querySelector(
                            'input[name="duration"]:checked'
                        );

                        if (!selectedDuration) {

                            e.preventDefault();

                            alert("Please select a duration.");

                            return false;
                        }
                    }

                });

            }

        });
    </script>
    <script>
        $("#bookingBtn").on('click', function() {
            $("#bookBtn").trigger('click');
        });
    </script>
@endpush
