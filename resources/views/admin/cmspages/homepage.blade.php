@extends('admin.layouts.app')
@section('title', 'CMS Home Page')
@section('content')
    <div class="container-fluid px-4">
        {{-- <h1 class="mt-4">CMS Home Page</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item ">CMS Home Page</li>
        </ol> --}}
        <div class="row">
            <div class="col-lg-8 mx-auto">
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
                    <form action="{{ route('admin.home-page-setting.store') }}" class="form-horizontal form-label-left"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header primary-color"><h4>Page Details (Home Page)</h4></div>
                            <div class="card-body">
                                <br />

                                <div class="form-group row d-none  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Title <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="title" id="title" class="form-control"
                                            value="{{ optional($homePage)->title }}">
                                    </div>
                                </div>
                                <div class="form-group d-none row mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Desctiption</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="description" id="description" class="form-control" rows="3">{{ optional($homePage)->description }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Banner
                                        Title
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="banner_title" id="banner_title" class="form-control"
                                            value="{{ optional($homePage)->banner_title }}" required>
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for="firstname" class="d-flex justify-content-end col-md-3 col-sm-3 col-xs-12">
                                        Banner Sub Title </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="teext" name="banner_sub_title" id="banner_sub_title"
                                            class="form-control" value="{{ optional($homePage)->banner_sub_title }}">
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Banner
                                        Image</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file" name="banner_img" id="banner_img" class="form-control"
                                            accept=".jpg,.jpeg,.png,.webp" onchange="previewSiteBannerImage(event)"
                                            @if (!isset($homePage) && !isset($homePage->banner_img)) required @endif>
                                        <img @if ($homePage && $homePage->banner_img) src="{{ $homePage->banner_img }}"
                                    @else style="display: none;" @endif
                                            alt="Site Logo" width="150" id="siteLogoPreview">
                                    </div>
                                </div>

                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Section
                                        One Title
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="setion_one_title" id="setion_one_title"
                                            class="form-control" value="{{ optional($homePage)->setion_one_title }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Section One Description
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="setion_one_desc" id="setion_one_desc" class="form-control" rows="3">{{ optional($homePage)->setion_one_desc }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Section
                                        One Button Text
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="setion_one_btn_text" id="setion_one_btn_text"
                                            class="form-control" value="{{ optional($homePage)->setion_one_btn_text }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Section
                                        One Button Link
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="setion_one_btn_link" id="setion_one_btn_link"
                                            class="form-control" value="{{ optional($homePage)->setion_one_btn_link }}"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Section One Image
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file" name="setion_one_img" id="setion_one_img"
                                            class="form-control" onchange="previewFSectionImage(event)">
                                        <img @if ($homePage && $homePage->setion_one_img) src="{{ $homePage->setion_one_img }}"
                                    @else style="display: none;" @endif
                                            alt="Site Logo" width="32" height="32" id="faviconPreview">
                                    </div>
                                </div>

                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Section
                                        Two Title
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="setion_two_title" id="setion_two_title"
                                            class="form-control" value="{{ optional($homePage)->setion_two_title }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Section Two Description
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="setion_two_desc" id="setion_two_desc" class="form-control" rows="3">{{ optional($homePage)->setion_two_desc }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Section Two Image
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="file" name="setion_two_img" id="setion_two_img"
                                            class="form-control" onchange="previewSSectionImage(event)">
                                        <img @if ($homePage && $homePage->setion_two_img) src="{{ $homePage->setion_two_img }}"
                                    @else style="display: none;" @endif
                                            alt="Site Logo" width="32" height="32" id="sfaviconPreview">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-header primary-color"><h4>SEO Setting</h4></div>
                            <div class="card-body">
                                <div class="form-group row  mb-2">
                                    <label for=""
                                        class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Meta
                                        Title
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" name="meta_title" id="meta_title" class="form-control"
                                            value="{{ optional($homePage)->meta_title }}" required>
                                    </div>
                                </div>

                                <div class="form-group  row mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Meta
                                        Description</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="meta_desc" id="meta_desc" class="form-control" rows="3">{{ optional($homePage)->meta_desc }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group  row mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Meta
                                        Keywords</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <textarea name="meta_key" id="meta_key" class="form-control" rows="3">{{ optional($homePage)->meta_key }}</textarea>
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
@endpush
