@extends('admin.layouts.app')
@section('title', 'CMS Home Page')
@section('content')
    <div class="container-fluid px-4">
        {{-- <h1 class="mt-4">CMS Home Page</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item ">CMS Home Page</li>
        </ol> --}}
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0">
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
                    <div class="card p-0">
                        <div class="card-header primary-color">
                            <h4>All Pages</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Page Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Home Page</td>
                                        <td><a href="{{ route('admin.home-page-setting.index') }}"
                                                class="btn primary-color">Edit</a></td>
                                    </tr>
                                    <tr>
                                        <td>Resources</td>
                                        <td><a href="{{ route('admin.resources-page-setting.index') }}"
                                                class="btn primary-color">Edit</a></td>
                                    </tr>
                                    <tr>
                                        <td>Gallery</td>
                                        <td><a href="{{ route('admin.gallery-page-setting.index') }}"
                                                class="btn primary-color">Edit</a></td>
                                    </tr>
                                    <tr>
                                        <td>Contact Page</td>
                                        <td><a href="{{ route('admin.contact-page-setting.index') }}"
                                                class="btn primary-color">Edit</a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
