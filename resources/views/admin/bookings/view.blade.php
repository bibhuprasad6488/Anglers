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
                        <div class="card shadow @if (empty($booking->user_name) || empty($booking->user_email)) disabled @endif mb-4 border-0">
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
                                <h4 class="mb-0">Booking Details</h4>
                            </div>
                            <div class="card-body">

                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th width="250">Bookng Id</th>
                                            <td>{{ $booking->booking_id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Bookng Amount</th>
                                            <td>${{ number_format($booking->booking_amount, 2) }}</td>
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
                                            <th>Admin Status</th>
                                            <td><span
                                                    class="badge @if ($booking->status == 'confirmed') bg-success @elseif ($booking->status == 'locked') bg-warning @else bg-danger @endif">
                                                    @if ($booking->status == 'confirmed')
                                                        Approved
                                                    @elseif ($booking->status == 'locked')
                                                        Pending
                                                    @else
                                                        Rejected
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        @if ($booking->status == 'locked')
                                            <tr>
                                                <th>Change Status</th>
                                                <td>
                                                    <form action="{{ route('admin.bookings.update', $booking->id) }}"
                                                        class="form-horizontal form-label-left" method="POST"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="form-group row  mb-2">
                                                            <div class="col-md-7 col-sm-9 col-xs-12">
                                                                <select name="status" id="status" class="form-control"
                                                                    required>
                                                                    <option disabled selected>Select</option>
                                                                    <option value="confirmed">Approve</option>
                                                                    <option value="reject">Reject</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2 col-sm-9 col-xs-12">
                                                                <button type="submit"
                                                                    class="btn primary-color {{ \Carbon\Carbon::parse($booking->check_in)->isPast() ? 'd-none' : '' }}">Update</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow mb-4 border-0">
                            <div class="card-header primary-color">
                                <h4 class="mb-0">User Details</h4>
                            </div>
                            <div class="card-body">

                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th width="250">User Name</th>
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
                                        <tr>
                                            <th>Number of Pet</th>
                                            <td>{{ $booking->number_of_pet }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card shadow mb-4 border-0">
                            <div class="card-header primary-color">
                                <h4 class="mb-0">Cabin Details</h4>
                            </div>
                            <div class="card-body">

                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th width="250">Title</th>
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
                    <div class="col-md-6">
                        {{-- <div class="card shadow mb-4">
                            <div class="card-header">
                                <h4 class="mb-0">Stripe Payment Details</h4>
                            </div>

                            <div class="card-body">

                                <table class="table table-bordered">
                                    <tr>
                                        <th width="250">Payment Intent ID</th>
                                        <td>{{ optional($paymentIntent)->id }}</td>
                                    </tr>

                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if (optional($paymentIntent)->status == 'succeeded')
                                                <span class="badge bg-success">Succeeded</span>
                                            @elseif(optional($paymentIntent)->status == 'processing')
                                                <span class="badge bg-warning">Processing</span>
                                            @else
                                                <span class="badge bg-danger">
                                                    {{ ucfirst(optional($paymentIntent)->status) }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Amount</th>
                                        <td>
                                            {{ strtoupper(optional($paymentIntent)->currency) }}
                                            {{ number_format(optional($paymentIntent)->amount / 100, 2) }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Created</th>
                                        <td>
                                            {{ \Carbon\Carbon::createFromTimestamp(optional($paymentIntent)->created)->format('d M Y h:i A') }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Customer ID</th>
                                        <td>{{ optional($paymentIntent)->customer ?? 'N/A' }}</td>
                                    </tr>
                                </table>

                            </div>
                        </div> --}}

                        @if (isset($charge))
                            <div class="card shadow">
                                <div class="card-header primary-color">
                                    <h4 class="mb-0">Payment Details</h4>
                                </div>

                                <div class="card-body">

                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="250">Payment Intent ID</th>
                                            <td>{{ optional($paymentIntent)->id }}</td>
                                        </tr>

                                        {{-- <tr>
                                            <th width="250">Charge ID</th>
                                            <td>{{ optional($charge)->id }}</td>
                                        </tr> --}}

                                        <tr>
                                            <th>Customer Name</th>
                                            <td>{{ optional($charge)->metadata->name ?? 'N/A' }}</td>
                                        </tr>

                                        <tr>
                                            <th>Customer Email</th>
                                            <td>{{ optional($charge)->metadata->email ?? 'N/A' }}</td>
                                        </tr>

                                        <tr>
                                            <th>Amount</th>
                                            <td>
                                                {{ strtoupper(optional($charge)->currency) }}
                                                {{ number_format(optional($charge)->amount / 100, 2) }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Card Brand</th>
                                            <td>{{ $charge ? ucfirst(optional($charge)->payment_method_details->card->brand) : 'N/A' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Card Last 4</th>
                                            <td>
                                                **** **** ****
                                                {{ optional($charge)->payment_method_details->card->last4 ?? 'N/A' }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @if (optional($paymentIntent)->status == 'succeeded')
                                                    <span class="badge bg-success">Succeeded</span>
                                                @elseif(optional($paymentIntent)->status == 'processing')
                                                    <span class="badge bg-warning">Processing</span>
                                                @else
                                                    <span class="badge bg-danger">
                                                        {{ ucfirst(optional($paymentIntent)->status) }}
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Receipt</th>
                                            <td>
                                                @if (optional($charge)->receipt_url)
                                                    <a href="{{ optional($charge)->receipt_url }}" target="_blank"
                                                        class="btn btn-primary btn-sm">
                                                        View Receipt
                                                    </a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
