@extends('admin.layouts.app')
@section('title', 'Blocked Properties')
@section('content')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <div class="container-fluid px-4">
        {{-- <h1 class="mt-4">CMS Home Page</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item ">CMS Home Page</li>
        </ol> --}}
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

                <div class="card shadow mb-4 border-0">
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
                    <div class="card-header primary-color">
                        <h4>Blocked Properties</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.block-new-property') }}" class="form-inline" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="">Property</label>
                                    <select name="property_id" id="property_id" class="form-control property-filter">
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($properties as $p)
                                            <option value="{{ $p->id }}">{{ $p->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">From</label>
                                    <input type="text" name="from_date" id="from_date" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label for="">To</label>
                                    <input type="text" name="to_date" id="to_date" class="form-control">
                                </div>
                                <div class="col-md-12 col-sm-9 col-xs-12 my-4 text-center">
                                    <button type="submit" class="btn primary-color">Block</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card border-0">
                    <div class="card-header primary-color">
                        <h4>Blocked Properties</h4>
                    </div>
                    <div class="card-body">

                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Property</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Created</th>
                                    <th>Status</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $booking->property->title }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->created_at)->format('d-m-Y') }}</td>
                                        <td class="fw-bold">{{ ucfirst($booking->status) }}</td>

                                        {{-- <td>
                                            <a href="{{ route('admin.bookings.show', $booking->id) }}" title="View Details"
                                                class="btn btn-sm btn-primary "><i class="fa fa-eye" aria-hidden="true"></i>
                                            </a>
                                            <form action="{{ route('admin.bookings.destroy', $booking->id) }}"
                                                method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger {{ $dbtnclas }}"
                                                    onclick="return confirm('Are you sure you want to delete this?');">Delete</button>
                                            </form>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        let blockedDates = [];


        // disable dates function
        function disableDates(date) {

            let d = $.datepicker.formatDate(
                'yy-mm-dd',
                date
            );


            let today = $.datepicker.formatDate(
                'yy-mm-dd',
                new Date()
            );


            // disable past dates
            if (d < today) {

                return [false];

            }

            // disable booked dates
            if (blockedDates.includes(d)) {

                return [false];

            }


            return [true];

        }

        // initialize from date
        $("#from_date").datepicker({
            dateFormat: 'yy-mm-dd',
            beforeShowDay: disableDates,
            onSelect: function(date) {
                let nextDate = new Date(date);
                nextDate.setDate(nextDate.getDate() + 1);
                $("#to_date").datepicker("option", "minDate", nextDate);
                // clear old invalid value
                $("#to_date").val('');

            }

        });

        // initialize to date
        $("#to_date").datepicker({
            dateFormat: 'yy-mm-dd',
            beforeShowDay: disableDates,
            onSelect: function(date) {
                let from = $("#from_date").val();
                if (from && date < from) {
                    alert('To date must be after from date');
                    $("#to_date").val('');
                }
            }
        });


        $("#property_id").change(function() {
            let propertyId = $(this).val();
            $("#from_date,#to_date").val('');
            $.ajax({
                url: "{{ route('admin.get-reserved-date') }}",
                data: {
                    property_id: propertyId
                },
                success: function(res) {
                    blockedDates = res.dates;
                    $("#from_date,#to_date").datepicker({
                        dateFormat: 'yy-mm-dd',
                        beforeShowDay: disableDates
                    });
                }
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const datatableElement = document.getElementById('datatablesSimple');
            if (datatableElement) {
                const table = new simpleDatatables.DataTable(datatableElement);
                document
                    .querySelector('.property-filter')
                    .addEventListener('change', function() {
                        let propertyName = this.options[this.selectedIndex].text;
                        if (propertyName == "Select") {
                            table.search('');
                        } else {
                            table.search(propertyName);
                        }
                    });
            }
        });
    </script>
@endpush
