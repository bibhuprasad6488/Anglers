@extends('admin.layouts.app')
@section('title', 'Partners List')
@section('content')
    <div class="container-fluid px-4">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="py-2">
                <h1 class="mt-4">Partners List</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Partners List</li>
                </ol>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ route('admin.partners.create') }}" class="btn btn-primary">Add New</a>
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
            <div class="card-header d-flex">
                <div class="tab-iocn">
                    <i class="fas fa-table me-1"></i>
                </div>

                <div class="toogle-bar ms-auto">
                    <b>On Page: </b> Hide
                    <label class="switch my-1" title="Show on Page">
                        <input type="checkbox" id="accessToggle"
                            onchange="accessUpdate('{{ route('admin.change.access') }}','partner')"
                            {{ $setting->partner_show ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                    Show
                </div>
            </div>
            <div class="card-body">

                <table id="datatablesSimple" class="table">
                    <thead>
                        <tr>
                            <th>SL No</th>
                            <th>Name</th>
                            <th>Logo</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($partners as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><b>{{ $p->name }}</b></td>
                                <td>
                                    <img src="{{ $p->logo_path }}" alt="{{ $p->name }}" width="150" class="rounded">
                                </td>
                                <td>{{ \Carbon\Carbon::parse($p->created_at)->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.partners.edit', $p->id) }}"
                                        class="btn btn-sm btn-primary">Edit</a>
                                    <form action="{{ route('admin.partners.destroy', $p->id) }}" method="POST"
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
