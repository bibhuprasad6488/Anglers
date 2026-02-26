@extends('admin.layouts.app')
@section('title', 'Price Lists')
@section('content')
    <div class="container-fluid px-4">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="py-2">
                <h1 class="mt-4">Price Lists</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Price Lists</li>
                </ol>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.pricings.create') }}" class="btn btn-primary">Add</a>
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
                            <th>Service</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pricings as $price)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $price->pricing_title }}</td>
                                <td>{{ Str::limit($price->pricing_text, 100) }}</td>
                                <td>{{ $price->category->name }}</td>
                                <td><b>{{ $price->price ? '£ ' . $price->price : '' }}</b></td>
                                <td>{{ \Carbon\Carbon::parse($price->created_at)->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.pricings.edit', $price->pricing_cat_id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('admin.pricings.destroy', $price->id) }}" method="POST"
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
