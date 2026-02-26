@extends('admin.layouts.app')

@section('title', 'Edit Testimonial')

@section('content')
    <div class="container-fluid px-4">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1">Edit Testimonial</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item">Testimonials</li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-primary">
                ← Back
            </a>
        </div>

        <!-- Card -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-semibold">
                Testimonial Information
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
                <form method="POST" action="{{ route('admin.testimonials.update', $t->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Client Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="client_name"
                                value="{{ optional($t)->client_name ?? old('client_name') }}"
                                placeholder="Enter partner client name" required autofocus>
                            @error('client_name')
                                <span class="alert text-danger py-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Website -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">
                                Location <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="client_position"
                                value="{{ optional($t)->client_position ?? old('client_position') }}"
                                placeholder="Enter Client Position" required>
                        </div>
                        <!-- Rating -->
                        <div class="col-md-3 d-none">
                            <label class="form-label fw-semibold">
                                Rating (1 to 5) <span class="text-danger">*</span>
                            </label>
                            <select name="client_rating" class="form-select" required>
                                <option value="" selected disabled>Select rating</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}"
                                        {{ optional($t)->client_rating == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>

                        </div>

                        <!-- Logo Upload -->
                        <div class="col-md-6 d-none">
                            <label class="form-label fw-semibold">
                                Testimonial Image <span class="text-danger">*</span>
                            </label>
                            <input type="file" class="form-control" name="client_photo_path"
                                accept=".jpg,.jpeg,.png,.webp" onchange="previewImage(event)">

                            <small class="text-muted">
                                Supported formats: JPG, PNG, WEBP (Max 2MB)
                            </small>
                        </div>

                        <!-- Logo Preview -->
                        <div class="col-md-6 d-flex align-items-end d-none">
                            <div class="border rounded p-2 w-100 text-center bg-light">
                                <img id="imagePreview"
                                    @if ($t->client_photo_path) src="{{ $t->client_photo_path }}" style="max-height: 120px;" @else style="max-height: 120px; display: none;" @endif
                                    alt="Logo Preview">
                                <div class="text-muted small mt-2">
                                    Image Preview
                                </div>
                            </div>
                        </div>
                        <!-- Description -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Client Message <span class="text-danger">*</span>
                            </label>
                            <textarea name="testimonial_text" rows="4" class="form-control" placeholder="Client Message" required>{{ optional($t)->testimonial_text ?? old('testimonial_text') }}</textarea>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-light">
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
    </script>
@endpush
