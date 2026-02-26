@extends('admin.layouts.app')
@section('title', 'Package Lists')
@section('content')
    <div class="container-fluid px-4">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="py-2">
                <h1 class="mt-4">Package Lists</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Package Lists</li>
                </ol>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.packages.create') }}" class="btn btn-primary">Add</a>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            @if (session('success'))
                <div class="alert alert-success mx-4 mt-3 rounded-3 shadow-sm" id="success-alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger mx-4 mt-3 rounded-3 shadow-sm" id="success-alert">
                    {{ session('error') }}
                </div>
            @endif
            @if (session('warnign'))
                <div class="alert alert-danger mx-4 mt-3 rounded-3 shadow-sm" id="success-alert">
                    {{ session('warnign') }}
                </div>
            @endif
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
            </div>
            <div class="card-body">

                <table id="datatablesSimple" class="table">
                    <thead>
                        <tr>
                            <th>SL No</th>
                            <th>Package</th>
                            <th>Includes</th>
                            <th>Price</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($packages as $package)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $package->package_title }}</td>
                                <td>{{ Str::limit($package->package_text, 100) }}</td>
                                <td><b>{{ $package->price ? '£ ' . $package->price : '' }}</b></td>
                                <td>{{ \Carbon\Carbon::parse($package->created_at)->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.packages.edit', $package->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST"
                                        style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
