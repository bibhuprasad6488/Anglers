@extends('admin.layouts.app')

@section('title', 'Edit Package')

@section('content')
    <div class="container-fluid px-4">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1">Edit Package</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item">Pricings</li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.packages.index') }}" class="btn btn-outline-primary">
                ← Back
            </a>
        </div>

        <!-- Card -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-semibold">
                Package Information
            </div>

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
            <div class="card-body">
                <form method="POST" action="{{ route('admin.packages.update', $package->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="col-md-8 mx-auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            <label for="pricingText" class="form-label">Package</label>
                                            <span class="text-danger">*</span>
                                        </th>
                                        <th>
                                            <label for="pricingText" class="form-label">Includes</label>
                                            <span class="text-danger">*</span>
                                        </th>
                                        <th>
                                            <label for="pricingText">Price</label>
                                            <span class="text-danger">*</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" name="package_title"
                                                class="form-control border-secondary" placeholder="Service Name"
                                                value="{{ $package->package_title }}" required>
                                        </td>

                                        <td>
                                            <textarea name="package_text" rows="3" class="form-control border-secondary" placeholder="Enter description">{{ $package->package_text }}</textarea>
                                        </td>

                                        <td style="width: 100px">
                                            <input type="text" name="price" placeholder="Price"
                                                class="form-control border-secondary numeric-only"
                                                value="{{ $package->price }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>

                    <!-- Actions -->
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.packages.index') }}" class="btn btn-light">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('input', '.numeric-only', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    </script>
@endpush
