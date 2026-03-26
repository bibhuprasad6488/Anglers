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

                    <div class="ms-auto d-none">
                        <div class="btn-group">
                            <a href="{{ route('admin.posts.create') }}" class="btn primary-color">Create</a>
                        </div>
                    </div>
                </div>

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
                        <h4>Bookings</h4>
                    </div>
                    <div class="card-body">

                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Bookng Id</th>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    <th>Amount</th>
                                    <th>Check In</th>
                                    <th>Check Out</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $booking)
                                    @php
                                        if ($booking->status == 'locked') {
                                            $clr = 'danger';
                                            $ds = 'd-none';
                                        } elseif ($booking->status == 'confirmed') {
                                            $clr = 'success';
                                            $ds = '';
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><b>{{ $booking->booking_id }}</b></td>
                                        <td><b>{{ $booking->user_name }}</b></td>
                                        <td><b>{{ $booking->user_email }}</b></td>
                                        <td><b>${{ $booking->booking_amount }}</b></td>
                                        <td>{{ \Carbon\Carbon::parse($booking->check_in)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->check_out)->format('d-m-Y') }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $clr }}">{{ ucfirst($booking->status) }}</span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($booking->created_at)->format('d-m-Y') }}</td>

                                        <td>
                                            <a href="{{ route('admin.bookings.show', $booking->id) }}" title="View Details"
                                                class="btn btn-sm btn-primary {{ $ds }}"><i class="fa fa-eye"
                                                    aria-hidden="true"></i>
                                            </a>
                                        </td>
                                        {{-- <td>
                                            <form action="{{ route('admin.posts.destroy', $booking->id) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
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
