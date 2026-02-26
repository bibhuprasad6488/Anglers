@extends('admin.layouts.app')

@section('title', 'Add Package')

@section('content')
    <div class="container-fluid px-4">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1">Add Package</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item">Packages</li>
                        <li class="breadcrumb-item active">Add</li>
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
                <form method="POST" action="{{ route('admin.packages.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-9 mx-auto">
                            <table class="table ">
                                <thead>

                                    <tr>
                                        <th>
                                            <label for="packageText" class="form-label">Package</label>
                                            <span class="text-danger">*</span>
                                        </th>
                                        <th>
                                            <label for="packageText" class="form-label">Includes</label>
                                            <span class="text-danger">*</span>
                                        </th>
                                        <th>
                                            <label for="packageText">Price</label>
                                            <span class="text-danger">*</span>
                                        </th>
                                        <td>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" name="package_title[]"
                                                class="form-control border-secondary" placeholder="Package Name">
                                        </td>
                                        <td>
                                            <textarea name="package_text[]" rows="2" class="form-control border-secondary" placeholder="Enter includes"></textarea>

                                        </td>
                                        <td style="width: 100px">
                                            <input type="text" name="price[]" placeholder="Price"
                                                class="form-control border-secondary numeric-only">
                                        </td>
                                        <td>
                                            <button class="btn btn-primary addKeys">+</button>

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
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.addKeys', function(e) {
            e.preventDefault();
            let tbody = $(this).closest('table').find('tbody');
            let row = ` <tr>
                            <td>
                                <input type="text" name="package_title[]"
                                    class="form-control border-secondary" placeholder="Package Name">
                            </td>
                            <td>
                                <textarea name="package_text[]" rows="2" class="form-control border-secondary" placeholder="Enter includes"></textarea>

                            </td>
                            <td>
                                <input type="text" name="price[]" placeholder="Price"
                                    class="form-control border-secondary numeric-only">
                            </td>
                            <td>
                                <button class="btn btn-danger removeKeys">-</button>
                            </td>
                        </tr>`;
            // row.find('td').empty();
            $(tbody).prepend(row);
        });
        $(document).on('click', '.removeKeys', function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        });
        $(document).on('input', '.numeric-only', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    </script>
@endpush
