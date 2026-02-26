@extends('admin.layouts.app')
@section('title', 'Case Studies List')
@section('content')
    <div class="container-fluid px-4">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="py-2">
                <h1 class="mt-4">Case Studies List</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Case Studies List</li>
                </ol>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.case-studies.create') }}" class="btn btn-primary">Add New</a>
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
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
            </div>
            <div class="card-body">

                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>SL No</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Topic</th>
                            <th>Short Description</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($caseStudies as $cs)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if (!$cs->image)
                                        <img src="{{ asset('storage/images/no_img.png') }}" alt="{{ $cs->title }}"
                                            class="rounded" width="180">
                                    @else
                                        <img src="{{ $cs->image }}" alt="{{ $cs->title }}" width="150"
                                            class="rounded">
                                    @endif
                                </td>
                                <td><b>{{ $cs->title }}</b></td>
                                <td>{{ $cs->topic->name }}</td>
                                <td>{{ Str::limit($cs->short_desc, 50, '...') }}</td>
                                <td>{{ \Carbon\Carbon::parse($cs->created_at)->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.case-studies.edit', $cs->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('admin.case-studies.destroy', $cs->id) }}" method="POST"
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
