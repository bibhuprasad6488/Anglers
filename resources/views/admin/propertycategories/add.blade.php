@extends('admin.layouts.app')
@section('title', 'Add Property Type')
@section('content')
    <div class="container-fluid px-4">
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
                            <a href="{{ route('admin.property-categories.create') }}" class="btn primary-color">Add New</a>
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

                    <form action="{{ route('admin.property-categories.store') }}"
                        class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card mb-5">
                            <div class="card-header primary-color">
                                <h4>Category Name</h4>
                            </div>
                            <div class="card-body">
                                <br />
                                <div class="form-group row  mb-2">
                                    <label for="name" class="col-md-2 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Category Name</label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">
                                        <input type="text" id="title" name="title" required
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}" placeholder="Enter category name">
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-2 col-sm-6 col-xs-12">

                                        <div class="d-flex justify-content-center">
                                            <div class="d-md-flex d-grid align-items-center gap-3">
                                                <button type="submit" id="submitBtn1" class="btn primary-color px-4"
                                                    name="submit2">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
