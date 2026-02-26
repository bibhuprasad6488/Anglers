@extends('admin.layouts.app')
@section('title', 'Protection Page')
@section('content')
    <div class="container-fluid px-4">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="py-2">
                <h1 class="mt-4">Protection Page</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Protection Page</li>
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
                Protection Page Information
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
                <form method="POST" action="{{ route('admin.protect.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3 g-4">
                        <!-- Description -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                Main Description
                            </label>
                            <textarea name="p_desc" rows="4" class="form-control" id="summernote" placeholder="Content">{{ $protect->p_desc ?? old('p_desc') }}</textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Main Image
                            </label>
                            <input type="file" name="p_image" id="p_image" class="form-control border-secondary"
                                accept=".jpg,.png,.jpeg,.webp">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Preview
                            </label>
                            <div class="my-2 border-secondary">
                                @if (!empty($protect->p_image))
                                    <img width="150" src="{{ $protect->p_image }}" alt="Step Image">
                                @endif
                            </div>
                        </div>

                    </div>

                    <div class="row mb-3 g-4">
                        <!-- Service -->
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    1st Service
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="ps_title_one"
                                            placeholder="Title" value="{{ $protect->ps_title_one ?? old('ps_title_one') }}">
                                    </div>
                                    <div class="mb-3">
                                        <textarea name="ps_desc_one" rows="4" class="form-control border-secondary" placeholder="Content">{{ $protect->ps_desc_one ?? old('ps_desc_one') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" name="ps_img_one" id=""
                                            class="form-control border-secondary" accept=".jpg,.jpeg,.png,.webp">
                                        <div class="my-2">
                                            @if (!empty($protect->ps_img_one))
                                                <img width="100" src="{{ $protect->ps_img_one }}" alt="Service Image">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Service -->
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    2nd Service
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="ps_title_two"
                                            placeholder="Title" value="{{ $protect->ps_title_two ?? old('ps_title_two') }}">
                                    </div>
                                    <div class="mb-3">
                                        <textarea name="ps_desc_two" rows="4" class="form-control border-secondary" placeholder="Content">{{ $protect->ps_desc_two ?? old('ps_desc_two') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" name="ps_img_two" id=""
                                            class="form-control border-secondary" accept=".jpg,.jpeg,.png,.webp">
                                        <div class="my-2">
                                            @if (!empty($protect->ps_img_two))
                                                <img width="100" src="{{ $protect->ps_img_two }}" alt="Service Image">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Service -->
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    3rd Service
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="ps_title_three"
                                            placeholder="Title"
                                            value="{{ $protect->ps_title_three ?? old('ps_title_three') }}">
                                    </div>
                                    <div class="mb-3">
                                        <textarea name="ps_desc_three" rows="4" class="form-control border-secondary" placeholder="Content">{{ $protect->ps_desc_three ?? old('ps_desc_three') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" name="ps_img_three" id=""
                                            class="form-control border-secondary" accept=".jpg,.jpeg,.png,.webp">
                                        <div class="my-2">
                                            @if (!empty($protect->ps_img_three))
                                                <img width="100" src="{{ $protect->ps_img_three }}"
                                                    alt="Service Image">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Service -->
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    4th Service
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="ps_title_four"
                                            placeholder="Title"
                                            value="{{ $protect->ps_title_four ?? old('ps_title_four') }}">
                                    </div>
                                    <div class="mb-3">
                                        <textarea name="ps_desc_four" rows="4" class="form-control border-secondary" placeholder="Content">{{ $protect->ps_desc_four ?? old('ps_desc_four') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" name="ps_img_four" id=""
                                            class="form-control border-secondary" accept=".jpg,.jpeg,.png,.webp">
                                        <div class="my-2">
                                            @if (!empty($protect->ps_img_four))
                                                <img width="100" src="{{ $protect->ps_img_four }}"
                                                    alt="Service Image">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    Protection Description
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <textarea name="pp_desc_one" rows="4" class="form-control border-secondary" placeholder="Content">{{ $protect->pp_desc_one ?? old('pp_desc_one') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    Sub Description
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <textarea name="pp_desc_two" rows="4" class="form-control border-secondary" placeholder="Content">{{ $protect->pp_desc_two ?? old('pp_desc_two') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    Partner Image
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <input type="file" name="pp_img" id=""
                                            class="form-control border-secondary" accept=".jpg,.jpeg,.png,.webp">

                                        <div class="my-2">
                                            @if (!empty($protect->pp_img))
                                                <img width="150" src="{{ $protect->pp_img }}" alt="Service Image">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Work -->
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    1st Work
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="pw_title_one"
                                            placeholder="Title"
                                            value="{{ $protect->pw_title_one ?? old('pw_title_one') }}">
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" name="pw_img_one" id=""
                                            class="form-control border-secondary" accept=".jpg,.jpeg,.png,.webp">
                                        <div class="my-2">
                                            @if (!empty($protect->pw_img_one))
                                                <img width="150" src="{{ $protect->pw_img_one }}"
                                                    alt="Work Image">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Work -->
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    2nd Work
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="pw_title_two"
                                            placeholder="Title"
                                            value="{{ $protect->pw_title_two ?? old('pw_title_two') }}">
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" name="pw_img_two" id=""
                                            class="form-control border-secondary" accept=".jpg,.jpeg,.png,.webp">
                                        <div class="my-2">
                                            @if (!empty($protect->pw_img_two))
                                                <img width="150" src="{{ $protect->pw_img_two }}"
                                                    alt="Work Image">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Work -->
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    3rd Work
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="pw_title_three"
                                            placeholder="Title"
                                            value="{{ $protect->pw_title_three ?? old('pw_title_three') }}">
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" name="pw_img_three" id=""
                                            class="form-control border-secondary" accept=".jpg,.jpeg,.png,.webp">
                                        <div class="my-2">
                                            @if (!empty($protect->pw_img_three))
                                                <img width="150" src="{{ $protect->pw_img_three }}"
                                                    alt="Work Image">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Work -->
                        <div class="col-md-3">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    4th Work
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="pw_title_four"
                                            placeholder="Title"
                                            value="{{ $protect->pw_title_four ?? old('pw_title_four') }}">
                                    </div>
                                    <div class="mb-3">
                                        <input type="file" name="pw_img_four" id=""
                                            class="form-control border-secondary" accept=".jpg,.jpeg,.png,.webp">
                                        <div class="my-2">
                                            @if (!empty($protect->pw_img_four))
                                                <img width="150" src="{{ $protect->pw_img_four }}"
                                                    alt="Work Image">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="col-md-4">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    CTA Title
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="pcta_title"
                                            placeholder="CTA Title"
                                            value="{{ $protect->pcta_title ?? old('pcta_title') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="col-md-4">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    CTA Button Text
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="pcta_btn_text"
                                            placeholder="CTA button text"
                                            value="{{ $protect->pcta_btn_text ?? old('pcta_btn_text') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CTA -->
                        <div class="col-md-4">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    CTA Button Link
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="pcta_btn_link"
                                            placeholder="CTA button link"
                                            value="{{ $protect->pcta_btn_link ?? old('pcta_btn_link') }}">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Approach -->
                        <div class="col-md-6 d-none">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    Meta Title
                                </div>
                                <div class="card-body p-1">
                                    <div class="mb-3">
                                        <input type="text" class="form-control border-secondary" name="meta_title"
                                            placeholder="Title" value="{{ $protect->meta_title ?? old('meta_title') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Approach -->
                        <div class="col-md-6 d-none">
                            <div class="card border-0">
                                <div class="card-header border-0 fw-bold">
                                    Meta Description
                                </div>
                                <div class="card-body p-1">
                                    <textarea name="meta_desc" rows="4" class="form-control border-secondary" placeholder="Description..">{{ $protect->meta_desc ?? old('meta_desc') }}</textarea>
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
