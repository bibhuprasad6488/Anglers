@extends('admin.layouts.app')

@section('title', 'Add Service')

@section('content')
    <div class="container-fluid px-4">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1">Add Service</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item">Services</li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.services.index') }}" class="btn btn-outline-primary">
                ← Back
            </a>
        </div>

        <!-- Card -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-semibold">
                Service Information
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
                <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-4">
                        <!-- Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Service Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                placeholder="Enter service name" required>
                            @error('name')
                                <span class="alert text-danger py-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Logo Upload -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Thumbnail Image <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" name="service_image" accept=".jpg,.jpeg,.png,.webp"
                                onchange="previewImage(event)" required>

                            <small class="text-muted">
                                Supported formats: JPG, PNG, JPEG, WEBP (Max 2MB)
                            </small>
                        </div>

                        <!-- Banner Upload -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Banner Image <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" name="banner_image" accept=".jpg,.jpeg,.png,.webp"
                                onchange="previewImageBanner(event)" required>

                            <small class="text-muted">
                                Supported formats: JPG, PNG, JPEG, WEBP (Max 2MB)
                            </small>
                        </div>

                        <!-- Logo Preview -->
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="border rounded p-2 w-100 text-center bg-light">
                                <img id="imagePreview" src="" alt="Logo Preview"
                                    style="max-height: 120px; display: none;">
                                <div class="text-muted small mt-2">
                                    Logo Preview
                                </div>
                            </div>
                        </div>

                        <!-- Banner Preview -->
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="border rounded p-2 w-100 text-center bg-light">
                                <img id="imagePreview1" src="" alt="Banner Preview"
                                    style="max-height: 120px; display: none;">
                                <div class="text-muted small mt-2">
                                    Banner Preview
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                Description
                            </label>
                            <textarea name="description" rows="4" class="form-control" id="summernote" placeholder="Optional description">{{ old('description') }}</textarea>
                        </div>
                        <!-- Meta Title -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Meta Title
                            </label>
                            <input type="text" class="form-control" name="meta_title" value=""
                                placeholder="Meta title">
                        </div>
                        <!-- Meta Desc -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Meta Description
                            </label>
                            <textarea name="meta_desc" id="meta_desc" cols="" class="form-control" rows="5"
                                placeholder="Meta Description"></textarea>
                        </div>
                        <!-- Meta Keys -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Meta Keywords
                            </label>
                            <textarea name="meta_keywords" id="meta_keywords" cols="" class="form-control" rows="5"
                                placeholder="Meta keywords"></textarea>
                        </div>

                    </div>

                    <!-- Actions -->
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.services.index') }}" class="btn btn-light">
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
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewImageBanner(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview1');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
