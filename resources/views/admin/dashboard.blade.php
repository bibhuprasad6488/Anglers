@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="container">
        <h1 class="mt-4">Dashboard</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        <div class="row">
            @foreach ($categories as $cat)
                <div class="col-xl-3 col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h5>{{ $cat->title }}</h5>
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-between">
                            <h3>{{ count($cat->properties) }}</h3>
                            <a class="small stretched-link text-decoration-none" href="{{ route('admin.view-properties', $cat->id) }}">View
                                Details <i class="fas fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-md-12">
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <h5>Recent Bookings</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Check In</th>
                                    <th>User Name</th>
                                    <th>No. of Child</th>
                                    <th>No. of Adult</th>
                                    <th>Property Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td>#{{ $booking->booking_id }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d-m-Y') }}</td>
                                        <td>{{ $booking->user_name }}</td>
                                        <td>{{ $booking->number_of_child }}</td>
                                        <td>{{ $booking->number_of_adult }}</td>
                                        <td>{{ $booking->property->title }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small stretched-link text-decoration-none" href="{{ route('admin.bookings.index') }}">View Details</a>
                        <div class="small"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
