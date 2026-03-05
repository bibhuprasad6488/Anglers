@extends('admin.layouts.app')
@section('title', 'Resources Page')
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
                    <form action="{{ route('admin.resources-page-setting.store') }}" class="form-horizontal form-label-left"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header primary-color">
                                <h4>Page Details (Resources Page)</h4>
                            </div>
                            <div class="card-body">
                                <br />

                                <div class="form-group row   mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Title <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="title" id="title" class="form-control"
                                            value="{{ optional($resource)->title }}" autofocus>
                                    </div>
                                </div>
                                <div class="form-group d-none row mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Desctiption</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="description" id="description" class="form-control" rows="3">{{ optional($resource)->description }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Section
                                        One Title
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="setion_one_title" id="setion_one_title"
                                            class="form-control" value="{{ optional($resource)->setion_one_title }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Section One Description
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="setion_one_desc" id="setion_one_desc" class="form-control" rows="3">{{ optional($resource)->setion_one_desc }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Section One Image
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file" name="setion_one_img" id="setion_one_img" class="form-control"
                                            onchange="previewFSectionImage(event)">
                                        <img @if ($resource && $resource->setion_one_img) src="{{ $resource->setion_one_img }}"
                                    @else style="display: none;" @endif
                                            alt="Section Image" width="150" id="faviconPreview">
                                    </div>
                                </div>

                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Section
                                        Two Title
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="setion_two_title" id="setion_two_title"
                                            class="form-control" value="{{ optional($resource)->setion_two_title }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Section Two Description
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="setion_two_desc" id="setion_two_desc" class="form-control" rows="3">{{ optional($resource)->setion_two_desc }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Section Two Image
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file" name="setion_two_img" id="setion_two_img" class="form-control"
                                            onchange="previewSSectionImage(event)">
                                        <img @if ($resource && $resource->setion_two_img) src="{{ $resource->setion_two_img }}"
                                    @else style="display: none;" @endif
                                            alt="Section Image" width="150" id="sfaviconPreview">
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Resource Title
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="resource_title" id="resource_title"
                                            class="form-control" value="{{ optional($resource)->resource_title }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Resource Description
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="resource_desc" id="resource_desc" class="form-control" rows="3">{{ optional($resource)->resource_desc }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Resource Button Text
                                        1
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="resource_btn_one_text" id="resource_btn_one_text"
                                            class="form-control"
                                            value="{{ optional($resource)->resource_btn_one_text }}" required placeholder="Button Text">
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Resource Button Link
                                        1
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="resource_btn_one_link" id="resource_btn_one_link"
                                            class="form-control"
                                            value="{{ optional($resource)->resource_btn_one_link }}" placeholder="Button Link" >
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Resource Button Text
                                        2
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="resource_btn_two_text" id="resource_btn_two_text"
                                            class="form-control"
                                            value="{{ optional($resource)->resource_btn_two_text }}" required placeholder="Button Text">
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Resource Button Link
                                        2
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="resource_btn_two_link" id="resource_btn_two_link"
                                            class="form-control"
                                            value="{{ optional($resource)->resource_btn_two_link }}" placeholder="Button Link" >
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Resource Button Text
                                        3
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="resource_btn_three_text" id="resource_btn_three_text"
                                            class="form-control"
                                            value="{{ optional($resource)->resource_btn_three_text }}" required placeholder="Button Text">
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Resource Button Link
                                        3
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="resource_btn_three_link" id="resource_btn_three_link"
                                            class="form-control"
                                            value="{{ optional($resource)->resource_btn_three_link }}" placeholder="Button Link" >
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
                                            value="{{ optional($resource)->meta_title }}" required>
                                    </div>
                                </div>

                                <div class="form-group  row mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Meta
                                        Description</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="meta_desc" id="meta_desc" class="form-control" rows="3">{{ optional($resource)->meta_desc }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group  row mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Meta
                                        Keywords</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="meta_key" id="meta_key" class="form-control" rows="3">{{ optional($resource)->meta_key }}</textarea>
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
            $('#resource_desc').summernote({
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
@endpush
