@extends('layouts.app')
@section('title', optional($property)->meta_title ?? 'Properties')
@section('meta_title', optional($property)->meta_title)
@section('meta_description', optional($property)->meta_desc)
@section('content')
    <link href="{{ asset('assets/css/calender.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/calender.js') }}"></script>
    <style>
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
                <div class="form-group col-lg-3 col-md-12">
                    <h4>
                        ▷ Browse Our <br><span> Cabin Selection </span> <span title="required">*</span>
                    </h4>
                </div>
                <div class="form-group col-lg-3 col-md-12">
                    <label class="text-white">Check In</label>
                    <input id="check_in_date" type="text" placeholder="Check-in Date" name="check_in_date"
                        class="form-control" required value="{{ request('check_in_date') ?? request('check_in') }}">
                    {{-- <input type="hidden" name="type_val" value="book_now"> --}}
                    <input type="hidden" name="property_id" value="{{ $property->id }}">
                    <input type="hidden" name="category_id" value="{{ $property->category_id }}">
                </div>
                @if (in_array($property->category_id, [1, 3]))
                    <div class="form-group col-lg-3 col-md-12">
                        <label class="text-white">Duration</label>

                        <select name="duration" id="duration" class="form-control" required>
                            <option value="" selected disabled>Select</option>
                            <option value="1">1 Month </option>
                            <option value="2">2 Month </option>
                            <option value="3">3 Month </option>
                        </select>

                        {{-- <div class="duration-group">
                            <label class="duration-option">
                                <input type="radio" name="duration" value="1"
                                    @if (request('duration') == 1) checked @endif>
                                <span>1 Month</span>
                            </label>

                            <label class="duration-option">
                                <input type="radio" name="duration" value="2"
                                    @if (request('duration') == 2) checked @endif>
                                <span>2 Months</span>
                            </label>

                            <label class="duration-option">
                                <input type="radio" name="duration" value="3"
                                    @if (request('duration') == 3) checked @endif>
                                <span>3 Months</span>
                            </label>
                        </div> --}}
                    </div>
                @else
                    <div class="form-group col-lg-3 col-md-12">
                        <label class="text-white">Check Out</label>
                        <input id="check_out_date" type="text" placeholder="Check-out Date" name="check_out_date"
                            class="form-control" required value="{{ request('check_out_date') ?? request('check_out') }}">
                    </div>
                @endif

                <div class="form-group col-lg-3 col-md-12">
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
                    <p><strong>Category:</strong> <span class="text-dark">{{ $property->category->title }}</span></p>
                    <small class="fw-semibold"> Price per pet ${{ $property->price_per_pet }}, Maximum
                        2 dogs less than 50
                        lb. No Cats </small>
                    <h2 class="mphb-calendar-title mt-3">Availability</h2>
                    <div class="availability-calendar mb-4">
                        <div class="calendar-navigation">
                            <button id="prevMonth" class="nav-btn">
                                &#10094;
                            </button>
                            <button id="todayBtn" class="today-btn">
                                Today
                            </button>
                            <button id="nextMonth" class="nav-btn">
                                &#10095;
                            </button>
                        </div>
                        <div class="calendar-wrapper">
                            <!-- LEFT MONTH -->
                            <div class="calendar-box">

                                <div class="calendar-title">
                                    <h3 id="calendarTitle1"></h3>
                                </div>

                                <div class="calendar-weekdays">
                                    <div>Mon</div>
                                    <div>Tue</div>
                                    <div>Wed</div>
                                    <div>Thu</div>
                                    <div>Fri</div>
                                    <div>Sat</div>
                                    <div>Sun</div>
                                </div>

                                <div id="calendarGrid1" class="calendar-grid"></div>

                            </div>

                            <!-- RIGHT MONTH -->
                            <div class="calendar-box">

                                <div class="calendar-title">
                                    <h3 id="calendarTitle2"></h3>
                                </div>

                                <div class="calendar-weekdays">
                                    <div>Mon</div>
                                    <div>Tue</div>
                                    <div>Wed</div>
                                    <div>Thu</div>
                                    <div>Fri</div>
                                    <div>Sat</div>
                                    <div>Sun</div>
                                </div>

                                <div id="calendarGrid2" class="calendar-grid"></div>

                            </div>

                        </div>

                        {{-- <div class="calendar-legend">

                            <span>
                                <span class="legend-box available-box"></span>
                                Available
                            </span>

                            <span>
                                <span class="legend-box booked-box"></span>
                                Booked
                            </span>

                        </div> --}}

                    </div>
                    <div class="card ">
                        <div class="card-header">
                            <h5 class="text-muted text-uppercase">Required fields are followed by *</h4>
                        </div>
                        <form action="{{ route('search.result') }}" method="GET" id="booking-form-{{ $property->id }}"
                            class="rounded-3  card-body">
                            @csrf
                            {{-- <input type="hidden" name="type_val" value="book_now"> --}}
                            <div class="form-group col-12 mb-3">
                                <label>Check-in Date *</label>
                                <input id="check_in" type="text" name="check_in_date" class="form-control" required
                                    value="{{ request('check_in_date') ?? request('check_in') }}" placeholder="Check-in Date">
                            </div>

                            @if (in_array($property->category_id, [1, 3]))
                                <div class="form-group col-12 mb-3">
                                    <label class="form-label">Duration *</label>

                                    <select name="duration" id="duration" class="form-control" required>
                                        <option value="" selected disabled>Select</option>
                                        <option value="1">1 Month </option>
                                        <option value="2">2 Month </option>
                                        <option value="3">3 Month </option>
                                    </select>
                                    {{-- <div class="duration-group">
                                        <label class="duration-option">
                                            <input type="radio" name="duration" value="1"
                                                @if (request('duration') == 1) checked @endif>
                                            <span>1 Month</span>
                                        </label>

                                        <label class="duration-option">
                                            <input type="radio" name="duration" value="2"
                                                @if (request('duration') == 2) checked @endif>
                                            <span>2 Months</span>
                                        </label>

                                        <label class="duration-option">
                                            <input type="radio" name="duration" value="3"
                                                @if (request('duration') == 3) checked @endif>
                                            <span>3 Months</span>
                                        </label>
                                    </div> --}}
                                </div>
                            @else
                                <div class="form-group col-12 mb-3">
                                    <label>Check-out Date *</label>
                                    <input id="check_out" type="text" name="check_out_date" class="form-control"
                                        required value="{{ request('check_out_date') ?? request('check_out') }}"
                                        placeholder="Check-out Date">
                                </div>
                            @endif
                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                            <input type="hidden" name="category_id" value="{{ $property->category_id }}">
                            <div class="form-group">
                                <input type="submit" class="btn book-cabin-btn" id="bookingBtn"
                                    value="Check Availability">
                            </div>
                        </form>
                    </div>
                    
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
            }, 10000); // change slide every 4 seconds

        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            initBookingForm(
                "bookingForm",
                "check_in_date",
                "check_out_date"
            );

            initBookingForm(
                "booking-form-{{ $property->id }}",
                "check_in",
                "check_out"
            );

            $.ajax({

                url: "{{ route('get-booked-date') }}",

                type: "POST",

                dataType: "json",

                data: {
                    _token: "{{ csrf_token() }}",
                    property_id: "{{ $property->id }}",

                },

                success: function(response) {

                    new AvailabilityCalendar({

                        bookedDates: response.dates

                    });

                }

            });
        });

        function initBookingForm(formId, checkInId, checkOutId) {

            const form = document.getElementById(formId);

            if (!form) return;

            const checkIn = document.getElementById(checkInId);
            const checkOut = document.getElementById(checkOutId);

            // Restore Local Storage
            const storedCheckIn = localStorage.getItem("check_in_date");
            const storedCheckOut = localStorage.getItem("check_out_date");

            if (checkIn && storedCheckIn) {
                checkIn.value = storedCheckIn;
            }

            if (checkOut && storedCheckOut) {
                checkOut.value = storedCheckOut;
            }

            // Duration Select
            const durationSelect = form.querySelector('select[name="duration"]');

            // Restore
            const storedDuration = localStorage.getItem("duration");

            if (durationSelect && storedDuration) {
                durationSelect.value = storedDuration;
            }

            // Save
            if (durationSelect) {

                durationSelect.addEventListener("change", function() {

                    localStorage.setItem("duration", this.value);
                    // Sync all duration selects
                    document.querySelectorAll('select[name="duration"]').forEach(function(select) {

                        select.value = durationSelect.value;

                    });
                });

            }

            // // Restore Duration for radio
            // const storedDuration = localStorage.getItem("duration");

            // if (storedDuration) {

            //     const durationRadio = form.querySelector(
            //         `input[name="duration"][value="${storedDuration}"]`
            //     );

            //     if (durationRadio) {
            //         durationRadio.checked = true;
            //     }

            // }


            // Save Duration
            // const durationRadios = form.querySelectorAll('input[name="duration"]');

            // durationRadios.forEach(function(radio) {

            //     radio.addEventListener("change", function() {
            //         localStorage.setItem("duration", this.value);
            //     });

            // });

            // Datepicker
            if (checkIn) {

                $(checkIn).datepicker({
                    dateFormat: "yy-mm-dd",
                    minDate: 1,

                    onSelect: function(dateText) {

                        localStorage.setItem("check_in_date", dateText);

                        // Sync both forms
                        $('input[name="check_in_date"]').val(dateText);

                        if (!checkOut) return;

                        let next = $.datepicker.parseDate("yy-mm-dd", dateText);
                        next.setDate(next.getDate() + 1);

                        $(checkOut).datepicker("option", "minDate", next);

                        if (
                            !checkOut.value ||
                            checkOut.value <= dateText
                        ) {

                            $(checkOut).datepicker("setDate", next);

                            const checkoutDate = $.datepicker.formatDate("yy-mm-dd", next);

                            localStorage.setItem(
                                "check_out_date",
                                checkoutDate
                            );

                            $('input[name="check_out_date"]').val(checkoutDate);

                        }

                    }

                });

            }

            if (checkOut) {

                $(checkOut).datepicker({

                    dateFormat: "yy-mm-dd",
                    minDate: 2,

                    onSelect: function(dateText) {

                        localStorage.setItem(
                            "check_out_date",
                            dateText
                        );

                        $('input[name="check_out_date"]').val(dateText);

                    }

                });

            }

            // Validation
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

                if (checkIn && checkOut && checkOut.value <= checkIn.value) {

                    e.preventDefault();

                    alert("Checkout date must be after Check-In date.");

                    checkOut.focus();

                    return false;
                }

                const durationRadios = form.querySelectorAll(
                    'input[name="duration"]'
                );

                if (durationRadios.length) {

                    const selected = form.querySelector(
                        'input[name="duration"]:checked'
                    );

                    if (!selected) {

                        e.preventDefault();

                        alert("Please select a duration.");

                        return false;
                    }

                }

            });

        }
    </script>
    {{-- <script>
        $("#bookingBtn").on('click', function() {
            $("#bookBtn").trigger('click');
        });
    </script> --}}
@endpush
