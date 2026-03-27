@extends('admin.layouts.app')
@section('title', 'Contact Page')
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
                            <a href="{{ route('admin.all-page') }}" class="btn primary-color">Back</a>
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
                    <form action="{{ route('admin.contact-page-setting.store') }}" class="form-horizontal form-label-left"
                        method="POST" enctype="multipart/form-data" id="sForm">
                        @csrf
                        <div class="card">
                            <div class="card-header primary-color">
                                <h4>Page Details (Contact Us)</h4>
                            </div>
                            <div class="card-body">
                                <br />

                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Title <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="title" id="title" class="form-control"
                                            value="{{ optional($contactPage)->title }}">
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
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="meta_title" id="meta_title" class="form-control"
                                            value="{{ optional($contactPage)->meta_title }}" required>
                                    </div>
                                </div>

                                <div class="form-group  row mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Meta
                                        Description</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="meta_desc" id="meta_desc" class="form-control" rows="3">{{ optional($contactPage)->meta_desc }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group  row mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Meta
                                        Keywords</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="meta_key" id="meta_key" class="form-control" rows="3">{{ optional($contactPage)->meta_key }}</textarea>
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

        function previewFSectionImage(event) {
            const input = event.target;
            const preview = document.getElementById('faviconPreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewSSectionImage(event) {
            const input = event.target;
            const preview = document.getElementById('sfaviconPreview');

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
            $('#setion_one_desc').summernote({
                placeholder: 'Content',
                tabsize: 2,
                height: 300,
                color: {
                    background: '#ffffff',
                    foreground: '#000000',
                }
            });
            $('#setion_two_desc').summernote({
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
