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
            height: 325px;
            border: 1px solid #dddd;
            margin: 10px auto;
            overflow-x: scroll;
        }

        .litepicker {
            box-shadow: none;
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
            <div class="row ">
                <div class="col-md-7 px-0 px-lg-5 mb-5 ">
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

                    <h2 class="text-center mt-4 d-none d-sm-block">YOU'LL NEVER WANT TO LEAVE</h2>
                    <h5 class="d-none d-sm-block">{{ $property->short_desc }}</h5>
                </div>
                <div class="col-md-5">
                    <h2>{{ $property->title }}</h2>
                    <p class="tag-list">{{ $property->sub_title }}</p>
                    <p>{!! $property->long_desc !!}</p>
                    <p>Categories: <span class="text-dark">{{ $property->category->title }}</span></p>
                    <h2 class="mphb-calendar-title">Availability</h2>
                    <div id="booking-calendar"></div>

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
                    <form action="{{ route('search.result') }}" method="GET" id="booking-form-{{ $property->id }}"
                        class="rounded-3 shadow-sm ">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="check-in">Check in </label>
                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                            <input type="hidden" name="category_id" value="{{ $property->category_id }}">
                            <input type="text" readonly name="check_in" id="check_in" class="form-control"
                                placeholder="Check in Date" value="{{ request()->input('check_in') }}">
                        </div>
                        <br>
                        <div class="form-group mb-3">
                            <label for="check-out">Check out </label>
                            <input type="text" readonly name="check_out" id="check_out" class="form-control"
                                placeholder="Check out Date" value="{{ request()->input('check_out') }}">
                        </div>
                        <br>
                        <div class="form-group">
                            <input type="submit" class="btn book-cabin-btn" value="Search">
                        </div>
                    </form>
                    @if (isset($pricing) && !empty($pricing))
                        <div class="card mt-4 ">
                            <div class="card-header">
                                <h4>Booking Information</h4>
                            </div>
                            <div class="card-body">
                                <p><strong>Total Days:</strong> {{ $pricing['total_days'] }}@if ($pricing['total_days'] > 1)
                                        days
                                    @else
                                        day
                                    @endif
                                </p>
                                <p><strong>Final Price:</strong> $ {{ $pricing['final_price'] }}</p>
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

            const checkIn = document.getElementById("check_in");
            const checkOut = document.getElementById("check_out");

            /* today date */
            let today = new Date().toISOString().split("T")[0];

            /* disable past dates */
            checkIn.setAttribute("min", today);
            checkOut.setAttribute("min", today);

            /* when checkin changes */
            checkIn.addEventListener("change", function() {

                let checkInDate = new Date(this.value);

                /* next day */
                let nextDay = new Date(checkInDate);
                nextDay.setDate(nextDay.getDate() + 1);

                let nextDayFormatted = nextDay.toISOString().split("T")[0];

                /* set checkout min */
                checkOut.min = nextDayFormatted;

                /* auto set checkout */
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

            const checkInInput = document.getElementById("check_in");
            const checkOutInput = document.getElementById("check_out");

            const today = new Date();
            const tomorrow = new Date();
            tomorrow.setDate(today.getDate() + 1);

            const todayFormatted = today.toISOString().split('T')[0];
            const tomorrowFormatted = tomorrow.toISOString().split('T')[0];

            // /* ----------------------------------
            //    Set default values if empty
            // ---------------------------------- */

            if (!checkInInput.value) {
                checkInInput.value = todayFormatted;
            }

            if (!checkOutInput.value) {
                checkOutInput.value = tomorrowFormatted;
            }

            // /* ----------------------------------
            //    Initialize Litepicker
            // ---------------------------------- */

            const picker = new Litepicker({

                element: document.getElementById('booking-calendar'),

                inlineMode: true, // always visible calendar
                singleMode: false, // date range

                numberOfMonths: 2,
                numberOfColumns: 2,

                minDate: today,

                format: 'YYYY-MM-DD',

                setup: (picker) => {

                    picker.on('selected', (date1, date2) => {

                        if (date1) {
                            checkInInput.value = date1.format('YYYY-MM-DD');
                        }

                        if (date2) {
                            checkOutInput.value = date2.format('YYYY-MM-DD');
                        }

                    });

                }

            });

            /* ----------------------------------
               Sync calendar with input values
            ---------------------------------- */

            if (checkInInput.value && checkOutInput.value) {
                picker.setDateRange(checkInInput.value, checkOutInput.value);
            }

        });
    </script>
@endpush
