@extends('admin.layouts.app')
@section('title', 'Wills')
@section('content')
    <div class="container-fluid px-4">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="py-2">
                <h1 class="mt-4">Wills</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Wills</li>
                </ol>
            </div>
            <div class="ms-auto d-none">
                <div class="btn-group">
                    <a href="{{ route('admin.pricings.create') }}" class="btn btn-primary">Add</a>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
            </div>
            <div class="card-body">

                <table id="datatablesSimple" class="table">
                    <thead>
                        <tr>
                            <th>SL No</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Post Code</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wills as $w)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $w->full_name }}</td>
                                <td>{{ $w->email }}</td>
                                <td>{{ $w->postcode }}</td>
                                <td>{{ \Carbon\Carbon::parse($w->created_at)->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.wills.list.show', $w->id) }}"
                                        class="btn btn-sm btn-secondary">View Details</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
