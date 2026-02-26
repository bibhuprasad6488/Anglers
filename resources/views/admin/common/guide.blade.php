@extends('admin.layouts.app')
@section('title', 'Guided Jourey')
@section('content')
    <div class="container-fluid px-4">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="py-2">
                <h1 class="mt-4">Guided Jourey</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Guided Jourey</li>
                </ol>
            </div>
            <div class="ms-auto d-none">
                <div class="btn-group">
                    <a href="#" class="btn btn-primary">Add</a>
                </div>
            </div>
        </div>
        <!-- Card -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light fw-semibold">
                Guided Jourey Information
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
                <form method="POST" action="{{ route('admin.guided.journey.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3 g-4">
                        <!-- Description -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                Overview
                            </label>
                            <textarea name="journey_desc" rows="4" class="form-control" id="summernote" placeholder="Content">{{ $journey->journey_desc ?? old('journey_desc') }}</textarea>
                        </div>

                    </div>
                    <div class="row mb-3 g-4">
                        <!-- Description -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Step Title
                            </label>
                            <input type="text" class="form-control border-secondary" name="step_title" placeholder="Step title"
                                value="{{ $journey->step_title ?? old('step_title') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Step Sub Title
                            </label>
                            <input type="text" class="form-control border-secondary" name="step_sub_title" placeholder="Step sub title"
                                value="{{ $journey->step_sub_title ?? old('step_sub_title') }}">
                        </div>

                    </div>

                    <div class="row mb-3 g-4">
                        <!-- Step -->
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    1st Step
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="step_title_one"
                                            placeholder="Title"
                                            value="{{ $journey->step_title_one ?? old('step_title_one') }}">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="step_sub_title_one"
                                            placeholder="Sub Title"
                                            value="{{ $journey->step_sub_title_one ?? old('step_sub_title_one') }}">
                                    </div>
                                    <div class="mb-3">
                                        <textarea name="step_desc_one" rows="4" class="form-control border-secondary" placeholder="Content">{{ $journey->step_desc_one ?? old('step_desc_one') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" name="step_img_one" id="" class="form-control border-secondary"
                                            accept=".jpg,.jpeg,.png,.webp">
                                        <div class="my-2">
                                            @if (!empty($journey->step_img_one))
                                                <img width="150" src="{{ $journey->step_img_one }}" alt="Step Image">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Step -->
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    2nd Step
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="step_title_two"
                                            placeholder="Title"
                                            value="{{ $journey->step_title_two ?? old('step_title_two') }}">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="step_sub_title_two"
                                            placeholder="Sub Title"
                                            value="{{ $journey->step_sub_title_two ?? old('step_sub_title_two') }}">
                                    </div>
                                    <div class="mb-3">
                                        <textarea name="step_desc_two" rows="4" class="form-control border-secondary" placeholder="Content">{{ $journey->step_desc_two ?? old('step_desc_two') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" name="step_img_two" id="" class="form-control border-secondary"
                                            accept=".jpg,.jpeg,.png,.webp">
                                        <div class="my-2">
                                            @if (!empty($journey->step_img_two))
                                                <img width="150" src="{{ $journey->step_img_two }}" alt="Step Image">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Step -->
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    3rd Step
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="step_title_three"
                                            placeholder="Title"
                                            value="{{ $journey->step_title_three ?? old('step_title_three') }}">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="step_sub_title_three"
                                            placeholder="Sub Title"
                                            value="{{ $journey->step_sub_title_three ?? old('step_sub_title_three') }}">
                                    </div>
                                    <div class="mb-3">
                                        <textarea name="step_desc_three" rows="4" class="form-control border-secondary" placeholder="Content">{{ $journey->step_desc_three ?? old('step_desc_three') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" name="step_img_three" id="" class="form-control border-secondary"
                                            accept=".jpg,.jpeg,.png,.webp">
                                        <div class="my-2">
                                            @if (!empty($journey->step_img_three))
                                                <img width="150" src="{{ $journey->step_img_three }}" alt="Step Image">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Step -->
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    4th Step
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary"
                                            name="step_title_four" placeholder="Title"
                                            value="{{ $journey->step_title_four ?? old('step_title_four') }}">
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="step_sub_title_four"
                                            placeholder="Sub Title"
                                            value="{{ $journey->step_sub_title_four ?? old('step_sub_title_four') }}">
                                    </div>
                                    <div class="mb-3">
                                        <textarea name="step_desc_four" rows="4" class="form-control border-secondary" placeholder="Content">{{ $journey->step_desc_four ?? old('step_desc_four') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" name="step_img_four" id="" class="form-control border-secondary"
                                            accept=".jpg,.jpeg,.png,.webp">
                                        <div class="my-2">
                                            @if (!empty($journey->step_img_four))
                                                <img width="150" src="{{ $journey->step_img_four }}" alt="Step Image">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Approach -->
                        <div class="col-md-6">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    Meta Title
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="meta_title"
                                            placeholder="Title" value="{{ $journey->meta_title ?? old('meta_title') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Approach -->
                        <div class="col-md-6">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    Meta Description
                                </div>
                                <div class="card-body p-1">
                                    <textarea name="meta_desc" rows="4" class="form-control" placeholder="Description..">{{ $journey->meta_desc ?? old('meta_desc') }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Actions -->
                    <div class="mt-4 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .tox-editor-container {
            border: 1px solid #adb5bd !important;
        }
    </style>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Loop through all elements with the class 'cont'
            document.querySelectorAll(".cont").forEach(function(editor) {

                // Initialize TinyMCE for each editor
                tinymce.init({
                    target: editor, // Use 'target' to bind TinyMCE to the specific element
                    height: 600,
                    plugins: 'advlist autolink link image lists charmap preview code fullscreen',
                    toolbar: 'undo redo | blocks | bold italic underline strikethrough forecolor backcolor | alignleft aligncenter alignright | bullist numlist blockquote | link image | code fullscreen ',

                    // NEW: use "blocks" instead of "formatselect" in TinyMCE 6+
                    block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6; Preformatted=pre; Blockquote=blockquote',

                    setup: function(editorInstance) {
                        // Sync content
                        editorInstance.on('change', function() {
                            editor.value = editorInstance.getContent();
                        });
                    }
                });
            });
        });
    </script>
@endpush
