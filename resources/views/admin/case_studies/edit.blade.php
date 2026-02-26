@extends('admin.layouts.app')

@section('title', 'Edit Case Study')

@section('content')
    <div class="container-fluid px-4">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="fw-bold mb-1">Edit Case Study</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item">Case Studies</li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.case-studies.index') }}" class="btn btn-outline-primary">
                ← Back
            </a>
        </div>

        <!-- Card -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-semibold">
                Case Study Information
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
                <form method="POST" action="{{ route('admin.case-studies.update', $cs->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">
                        <!-- Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" name="title"
                                value="{{ optional($cs)->title ?? old('title') }}" placeholder="Enter Title" required
                                autofocus>
                            @error('title')
                                <span class="alert text-danger py-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Topic -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">
                                Select Topic <span class="text-danger">*</span>
                            </label>
                            <select name="topic_id" id="topic_id" class="form-select">
                                <option value="" selected disabled>Select</option>
                                @foreach ($topics as $topic)
                                    <option value="{{ $topic->id }}"
                                        {{ ($cs->topic_id ? $cs->topic_id : old('topic_id') == $topic->id) ? 'selected' : '' }}>
                                        {{ $topic->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Logo Upload -->
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">
                                Image
                            </label>
                            <input type="file" class="form-control" name="image" accept=".jpg,.jpeg,.png,.webp"
                                onchange="previewImage(event)">

                            <small class="text-muted">
                                Supported formats: JPG, PNG, WEBP (Max 2MB)
                            </small>
                        </div>

                        <!-- Short Desc -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Short Description <span class="text-danger">*</span>
                            </label>
                            <textarea name="short_desc" id="short_desc" cols="" class="form-control" rows="5"
                                placeholder="Short Description" required>{{ optional($cs)->short_desc ?? old('short_desc') }}</textarea>
                        </div>

                        <!-- Image Preview -->
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="border rounded p-2 w-100 text-center bg-light">
                                <img id="imagePreview"
                                    @if (!empty($cs->image)) src="{{ $cs->image }}" style="max-height: 120px;"
                                    @else
                                    style="max-height: 120px; display: none;" @endif
                                    alt="Image Preview">
                                <div class="text-muted small mt-2">
                                    Image Preview
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                Long Decription <span class="text-danger">*</span>
                            </label>
                            <textarea name="long_desc" rows="5" class="form-control border-secondary" id="summernote"placeholder="Description">{{ optional($cs)->long_desc ?? old('long_desc') }}</textarea>
                        </div>

                        <!-- Meta Title -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Meta Title
                            </label>
                            <input type="text" class="form-control" name="meta_title"
                                value="{{ optional($cs)->meta_title ?? old('meta_title') }}" placeholder="Meta title">
                        </div>
                        <!-- Meta Desc -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Meta Description
                            </label>
                            <textarea name="meta_desc" id="meta_desc" cols="" class="form-control" rows="5"
                                placeholder="Meta Description" >{{ optional($cs)->meta_desc ?? old('meta_desc') }}</textarea>
                        </div>
                        <!-- Meta Keys -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Meta Keywords
                            </label>
                            <textarea name="meta_keywords" id="meta_keywords" cols="" class="form-control" rows="5"
                                placeholder="Meta keywords" >{{ optional($cs)->meta_keywords ?? old('meta_keywords') }}</textarea>
                        </div>
                    </div>
                    <!-- Actions -->
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.case-studies.index') }}" class="btn btn-light">
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
