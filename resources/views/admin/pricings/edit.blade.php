@extends('admin.layouts.app')

@section('title', 'Edit Pricing')

@section('content')
    <div class="container-fluid px-4">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1">Edit Pricing</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item">Pricings</li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.pricings.index') }}" class="btn btn-outline-primary">
                ← Back
            </a>
        </div>

        <!-- Card -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-semibold">
                Pricing Information
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
                <form method="POST" action="{{ route('admin.pricings.update', $id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <!-- Name -->
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">
                                Pricing Category <span class="text-danger">*</span>
                            </label>
                            <select name="pricing_cat_id" id="pricing_cat_id" class="form-select border-secondary" autofocus
                                required>
                                <option value="" selected disabled>Select Category</option>
                                @foreach ($priceCategories as $pc)
                                    <option value="{{ $pc->id }}" {{ $id == $pc->id ? 'selected' : '' }}>
                                        {{ $pc->name }}</option>
                                @endforeach
                            </select>
                            @error('name')
                                <span class="alert text-danger py-1">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-8">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            <label for="pricingText" class="form-label">Service</label>
                                            <span class="text-danger">*</span>
                                        </th>
                                        <th>
                                            <label for="pricingText" class="form-label">Description</label>
                                            <span class="text-danger">*</span>
                                        </th>
                                        <th>
                                            <label for="pricingText">Price</label>
                                            <span class="text-danger">*</span>
                                        </th>
                                        <td>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pricings as $pricing)
                                        <tr>
                                            <td>
                                                <input type="text" name="pricing_title[]"
                                                    class="form-control border-secondary" placeholder="Service Name"
                                                    value="{{ $pricing->pricing_title }}" required>
                                            </td>

                                            <td>
                                                <textarea name="pricing_text[]" rows="3" class="form-control border-secondary" placeholder="Enter description">{{ $pricing->pricing_text }}</textarea>
                                            </td>

                                            <td style="width: 100px">
                                                <input type="text" name="price[]" placeholder="Price"
                                                    class="form-control border-secondary numeric-only"
                                                    value="{{ $pricing->price }}">
                                            </td>

                                            <td>
                                                @if ($loop->last)
                                                    <button type="button" class="btn btn-primary addKeys">+</button>
                                                @else
                                                    <button type="button" class="btn btn-danger removeKeys">-</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>


                    </div>

                    <!-- Actions -->
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.pricings.index') }}" class="btn btn-light">
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
        $(document).on('click', '.addKeys', function(e) {
            e.preventDefault();
            let tbody = $(this).closest('table').find('tbody');
            let row = ` <tr>
                            <td>
                                <input type="text" name="pricing_title[]"
                                    class="form-control border-secondary" placeholder="Service Name" required>
                            </td>
                            <td>
                                <textarea name="pricing_text[]" rows="3" class="form-control border-secondary" placeholder="Enter description"></textarea>
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
