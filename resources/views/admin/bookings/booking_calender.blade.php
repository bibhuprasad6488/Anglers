@extends('admin.layouts.app')
@section('title', 'Calender')
@section('content')
    <div class="container-fluid px-4">
        {{-- <h1 class="mt-4">CMS Home Page</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item ">CMS Home Page</li>
        </ol> --}}
        <style>
            .table-wrapper {
                height: 700px;
                overflow: auto;
                position: relative;
            }


            #calendarTable {
                white-space: nowrap;
                border-collapse: separate;
                border-spacing: 0;
            }


            /* Sticky Property Column */
            .sticky-col {
                position: sticky !important;
                left: 0;
                min-width: 180px;
                background: #fff;
                z-index: 20 !important;
            }


            /* Sticky Date Header */
            #calendarTable thead th {
                position: sticky !important;
                top: 0;
                background: #fff;
                z-index: 10;
            }


            /* Top-left corner */
            #calendarTable thead th.sticky-col {
                z-index: 30 !important;
            }


            /* Table borders */
            #calendarTable th,
            #calendarTable td {
                border: 1px solid rgba(104, 102, 102, 0.226);
            }


            /* Body sticky column */
            #calendarTable tbody td.sticky-col {
                z-index: 15;
            }


            /* Booking status colors */
            .pending {
                background: #FFF100 !important;
            }

            .booked {
                background: #E81224 !important;
            }

            .available {
                background: #16C60C !important;
            }

            .past {
                background: #7a7b7c3d !important;
            }

            .blocked {
                background-color: #383838 !important;
                text-align: center;
                cursor: not-allowed;
            }

            .legend-item .block {
                background-color: #383838 !important;
            }

            .blocked::before {
                content: '\1F6C7';
                color: #cccc;
                font-size: 20px;
            }

            /* Date width */
            .date-col {
                min-width: 90px;
            }

            .booked {
                cursor: pointer;
            }


            .booking-cell.selected {
                outline: 3px solid #000;
            }

            /* Base container styling */
            .legend-container {
                display: flex;
                gap: 20px;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                align-items: center;
                justify-content: flex-end;
                margin: 13px auto;
            }

            /* Individual item layouts */
            .legend-item {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 6px;
            }

            /* Color block structures */
            .color-box {
                width: 16px;
                height: 16px;
                border-radius: 2px;
                /* Slight rounding matching the image */
            }

            /* Label typography */
            .legend-label {
                font-size: 13px;
                color: #4a4a4a;
            }

            /* Color variations matching the image palette */
        </style>
        <div class="row">
            <div class="col-lg-12">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="py-2 d-none">
                        <h1 class="mt-4">Contact Forms</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Contact Forms</li>
                        </ol>
                    </div>

                    <div class="ms-auto d-none">
                        <div class="btn-group">
                            <a href="{{ route('admin.posts.create') }}" class="btn primary-color">Create</a>
                        </div>
                    </div>
                </div>

                <div class="card border-0">
                    <div class="card-header primary-color">
                        <h4>Calender</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="legend-container">
                            <div class="legend-item">
                                <span class="color-box booked"></span>
                                <span class="legend-label">Booked</span>
                            </div>
                            <div class="legend-item">
                                <span class="color-box pending"></span>
                                <span class="legend-label">Pending</span>
                            </div>
                            <div class="legend-item">
                                <span class="color-box available"></span>
                                <span class="legend-label">Available</span>
                            </div>
                            <div class="legend-item">
                                <span class="color-box block"></span>
                                <span class="legend-label">Blocked</span>
                            </div>
                        </div>
                        <div class="table-wrapper" id="calendarScroll">
                            <table class="table " id="calendarTable">
                                <thead>
                                    <tr class="text-center">
                                        <th class="sticky-col">
                                            Property
                                        </th>
                                        @foreach ($dates as $index => $date)
                                            <td class="date-col {{ $date->isToday() ? 'today-column' : '' }}"
                                                data-index="{{ $index }}">

                                                <small>{{ $date->format('D') }}</small>
                                                <p class="m-0">{{ $date->format('d M Y') }}</p>

                                            </td>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($properties as $p)
                                        @php
                                            $booking;
                                        @endphp
                                        <tr>
                                            <td class="sticky-col">
                                                {{ $p->title }}
                                            </td>
                                            @foreach ($dates as $date)
                                                @php

                                                    $dateString = $date->format('Y-m-d');

                                                    $booking = $p->bookings->first(function ($booking) use (
                                                        $dateString,
                                                    ) {
                                                        return $dateString >= $booking->check_in &&
                                                            $dateString < $booking->check_out;
                                                    });

                                                    if ($booking) {
                                                        if ($booking->status == 'confirmed') {
                                                            $class = 'booked';
                                                        } elseif ($booking->status == 'locked') {
                                                            $class = 'pending';
                                                        } elseif ($booking->status == 'blocked') {
                                                            $class = 'blocked';
                                                        }
                                                    } elseif ($date->isBefore(today())) {
                                                        $class = 'past';
                                                    } else {
                                                        $class = 'available';
                                                    }

                                                @endphp


                                                <td class="{{ $class }} booking-cell"
                                                    @if ($booking) data-booking='@json($booking)' @endif>

                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="text-center">
                                        <th class="sticky-col">
                                            Property
                                        </th>
                                        @foreach ($dates as $index => $date)
                                            <td class="date-col {{ $date->isToday() ? 'today-column' : '' }}"
                                                data-index="{{ $index }}">

                                                <small>{{ $date->format('D') }}</small>
                                                <p class="m-0">{{ $date->format('d M Y') }}</p>

                                            </td>
                                        @endforeach
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="bookingModal" tabindex="-1">

        <div class="modal-dialog">

            <div class="modal-content">


                <div class="modal-header">

                    <h5 class="modal-title">
                        Booking Details
                    </h5>

                    <button class="btn-close" data-bs-dismiss="modal"></button>

                </div>


                <div class="modal-body">

                    <p>
                        Customer:
                        <strong id="customerName"></strong>
                    </p>


                    <p>
                        Email:
                        <strong id="customerEmail"></strong>
                    </p>


                    <p>
                        Phone:
                        <strong id="customerPhone"></strong>
                    </p>


                    <p>
                        Check In:
                        <strong id="checkIn"></strong>
                    </p>


                    <p>
                        Check Out:
                        <strong id="checkOut"></strong>
                    </p>


                    <p>
                        Status:
                        <strong id="bookingStatus"></strong>
                    </p>


                </div>


            </div>

        </div>

    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const wrapper = document.getElementById('calendarScroll');
            const todayColumn = document.querySelector('.today-column');
            const propertyColumn = document.querySelector('.sticky-col');


            if (todayColumn && propertyColumn) {

                wrapper.scrollLeft =
                    todayColumn.offsetLeft - propertyColumn.offsetWidth;

            }

        });
    </script>
    <script>
        $(document).on('click', '.booked', function() {


            let booking = $(this).data('booking');


            if (!booking) {
                return;
            }


            $("#customerName").text(booking.user_name);

            $("#customerEmail").text(booking.user_email);

            $("#customerPhone").text(booking.user_phone);

            $("#checkIn").text(booking.check_in);

            $("#checkOut").text(booking.check_out);

            $("#bookingStatus").text(booking.status);



            $("#bookingModal").modal('show');


        });
    </script>
@endpush
