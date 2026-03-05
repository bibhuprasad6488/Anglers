@extends('admin.layouts.app')
@section('title', 'Posts')
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

                    <div class="ms-auto">
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
                        <h4>All Posts</h4>
                    </div>
                    <div class="card-body">

                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $blog)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><b>{{ $blog->title }}</b></td>
                                        <td>
                                            <img src="{{ $blog->blog_img }}" alt="{{ $blog->title }}" width="80"
                                                class="rounded">
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($blog->created_at)->format('d-m-Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.posts.edit', $blog->id) }}"
                                                class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('admin.posts.destroy', $blog->id) }}" method="POST"
                                                style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this?');">Delete</button>
                                            </form>

                                            <label class="switch my-1" title="Show on Page">
                                                <input type="checkbox" id="accessToggle_{{ $loop->iteration }}"
                                                    onchange="accessUpdate('{{ route('admin.posts.show', $blog->id) }}','{{ $loop->iteration }}')"
                                                    {{ $blog->status == 1 ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </td>
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
