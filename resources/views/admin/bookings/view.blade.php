@extends('admin.layouts.app')
@section('title', 'Bookings')
@section('content')
    <div class="container-fluid px-4">
        {{-- <h1 class="mt-4">CMS Home Page</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item ">CMS Home Page</li>
        </ol> --}}
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="py-2 d-none">
                        <h1 class="mt-4">Contact Forms</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Contact Forms</li>
                        </ol>
                    </div>

                    <div class="ms-auto ">
                        <div class="btn-group">
                            <a href="{{ route('admin.bookings.index') }}" class="btn primary-color">Back</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0">
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
                                <h4>Booking Details</h4>
                            </div>
                            <div class="card-body">

                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Bookng Id</th>
                                            <td>{{ $booking->booking_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Bookng Amount</th>
                                            <td>${{ $booking->booking_amount }}</td>
                                        </tr>
                                        <tr>
                                            <th>Check In Date</th>
                                            <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d-m-Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Check Out Date</th>
                                            <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d-m-Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Nights</th>
                                            <td>{{ $booking->total_nights }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td><span
                                                    class="badge @if ($booking->status == 'confirmed') bg-success @else bg-danger @endif">{{ ucfirst($booking->status) }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0">
                            <div class="card-header primary-color">
                                <h4>User Details</h4>
                            </div>
                            <div class="card-body">

                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>User Name</th>
                                            <td>{{ $booking->user_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>User Email</th>
                                            <td>{{ $booking->user_email }}</td>
                                        </tr>
                                        <tr>
                                            <th>User Phone</th>
                                            <td>{{ $booking->user_phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Number of Child</th>
                                            <td>{{ $booking->number_of_child }}</td>
                                        </tr>
                                        <tr>
                                            <th>Number of Adult</th>
                                            <td>{{ $booking->number_of_adult }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0">
                            <div class="card-header primary-color">
                                <h4>Cabin Details</h4>
                            </div>
                            <div class="card-body">

                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Title</th>
                                            <td>{{ $booking->property->title }}</td>
                                        </tr>
                                        <tr>
                                            <th>Category</th>
                                            <td>{{ $booking->property->category->title }}</td>
                                        </tr>
                                        <tr>
                                            <th>Image</th>
                                            <td>
                                                <img src="{{ asset('storage/images/property/' . $booking->property->images->first()->img_path) }}"
                                                    alt="{{ $booking->property->title }}" width="150">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
