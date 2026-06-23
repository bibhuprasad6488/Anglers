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
                            <a class="small stretched-link text-decoration-none"
                                href="{{ route('admin.view-properties', $cat->id) }}">View
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
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    @php
                                        if ($booking->payment_status == 'pending') {
                                            $pcolor = 'warning';
                                            $dbtnclas = '';
                                        } else {
                                            $pcolor = 'primary';
                                            $dbtnclas = 'd-none';
                                        }

                                        $bkngStatus = '';
                                        if ($booking->status == 'locked') {
                                            $clr = 'warning';
                                            $ds = 'd-none';
                                            $bkngStatus = 'pending';
                                        } elseif ($booking->status == 'confirmed') {
                                            $clr = 'success';
                                            $ds = '';
                                            $bkngStatus = 'approved';
                                        } elseif ($booking->status == 'reject') {
                                            $clr = 'danger';
                                            $ds = '';
                                            $bkngStatus = 'rejected';
                                        }
                                    @endphp
                                    <tr class="@if (empty($booking->user_name) || empty($booking->user_email)) d-none @endif">
                                        <td>
                                            <a
                                                href="{{ route('admin.bookings.show', $booking->id) }}">{{ $booking->booking_id }}</a>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d-m-Y') }}</td>
                                        <td>{{ $booking->user_name }}</td>
                                        <td>{{ $booking->number_of_child }}</td>
                                        <td>{{ $booking->number_of_adult }}</td>
                                        <td>{{ $booking->property->title }}</td>
                                        <td>
                                            <span class="badge bg-{{ $clr }}">{{ ucfirst($bkngStatus) }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <a class="small text-decoration-none" href="{{ route('admin.bookings.index') }}">View Details</a>
                        <span class="small"><i class="fas fa-angle-right"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
