@extends('admin.layouts.app')
@section('title', 'Post Add')
@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="py-2 d-none">
                        <h1 class="mt-4">Contact Forms</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Contact Forms</li>
                        </ol>
                    </div>

                    <div class="ms-auto">
                        <div class="btn-group">
                            <a href="{{ route('admin.posts.index') }}" class="btn primary-color">Back</a>
                        </div>
                    </div>
                </div>
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
                    <form action="{{ route('admin.posts.store') }}" class="form-horizontal form-label-left" method="POST"
                        enctype="multipart/form-data" id="sForm">
                        @csrf
                        <div class="card">
                            <div class="card-header primary-color">
                                <h4>Add Post Details</h4>
                            </div>
                            <div class="card-body">
                                <br />

                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Title <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <input type="text" name="title" id="title" class="form-control"
                                            value="" placeholder="Blog title">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Short Desctiption</label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <textarea name="short_desc" id="short_desc" class="form-control" rows="3" placeholder="Short desc"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Main Description
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <textarea name="long_desc" id="long_desc" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Blog
                                        Image</label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <input type="file" name="blog_img" id="blog_img" class="form-control"
                                            accept=".jpg,.jpeg,.png,.webp" onchange="previewSiteBannerImage(event)"
                                            required>
                                        <img style="display: none;" alt="Banner Image" width="150" id="siteLogoPreview">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header primary-color">
                                <h4>SEO Setting</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Meta
                                        Title
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <input type="text" name="meta_title" id="meta_title" class="form-control"
                                            value="" placeholder="Meta title">
                                    </div>
                                </div>

                                <div class="form-group  row mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Meta
                                        Description</label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <textarea name="meta_desc" id="meta_desc" class="form-control" rows="3" placeholder="Meta Description"></textarea>
                                    </div>
                                </div>

                                <div class="form-group  row mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Meta
                                        Keywords</label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <textarea name="meta_key" id="meta_key" class="form-control" rows="3" placeholder="Meta Keys"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="submit" id="submitBtn1" class="btn primary-color px-4"
                                        name="submit2">Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function previewSiteBannerImage(event) {
            const input = event.target;
            const preview = document.getElementById('siteLogoPreview');

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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#long_desc').summernote({
                placeholder: 'Content',
                tabsize: 2,
                height: 300,
                color: {
                    background: '#ffffff',
                    foreground: '#000000',
                }
            });
        });
    </script>
    <script>
        let subBtn = document.getElementById('submitBtn1');
        let subForm = document.getElementById('sForm');
        subBtn.addEventListener("click", async function() {
            subBtn.innerText = 'Processing...';
            // Correct way to disable button
            subBtn.setAttribute('disabled', true);
            subForm.submit();
        });
    </script>
@endpush
