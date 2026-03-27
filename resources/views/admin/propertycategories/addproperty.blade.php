@extends('admin.layouts.app')
@section('title', 'Add Property Details')
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

                    <div class="ms-auto ">
                        <div class="btn-group">
                            <button onclick="window.history.back()" class="btn primary-color">Go Back</button>
                        </div>
                    </div>
                </div>

                <div class="card border-0">
                    @if (session('success'))
                        <div class="alert alert-success mx-1 mt-3 rounded-3 shadow-sm" id="success-alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger mx-1 mt-3 rounded-3 shadow-sm" id="success-alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('admin.properties.store') }}" class="form-horizontal form-label-left"
                        method="POST" enctype="multipart/form-data" id="pUploadForm">
                        @csrf
                        <div class="card mb-3">
                            <div class="card-header primary-color">
                                <h4> Property Type</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Property Type:
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <input type="text" name="pt_name" id="pt_name" class="form-control"
                                            value="{{ $pCat->title }}" placeholder="Title" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header primary-color">
                                <h4>Add Property Details</h4>
                            </div>
                            <div class="card-body">
                                <br />

                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Title <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <input type="text" name="title" id="title" class="form-control"
                                            value="{{ old('title') }}" placeholder="Title" required>
                                    </div>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <input type="hidden" name="category_id" id="category_id" class="form-control"
                                            value="{{ $pCat->id }}">
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Sub Title <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <input type="text" name="sub_title" id="sub_title" class="form-control"
                                            value="{{ old('sub_title') }}" placeholder="Sub Title" required>
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Price Per Night
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <input type="text" name="price_per_night" id="price_per_night"
                                            class="form-control numeric-only" value="{{ old('price_per_night') }}"
                                            placeholder="Price">
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Price Per Week
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <input type="text" name="price_per_week" id="price_per_week"
                                            class="form-control numeric-only" value="{{ old('price_per_week') }}"
                                            placeholder="Price">
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Price Per Month
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <input type="text" name="price_per_month" id="price_per_month"
                                            class="form-control numeric-only" value="{{ old('price_per_month') }}"
                                            placeholder="Price">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Short Description</label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <textarea name="short_desc" id="short_desc" class="form-control" rows="3" placeholder="Short desc"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Details
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <textarea name="long_desc" id="long_desc" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="form-group row  mb-2">
                                    <label for="Img" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Multiple Image Upload (Drag & Drop)</label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">


                                        <div class="drop-area" id="dropArea">
                                            <p>Drag & Drop Images Here or Click to Select</p>
                                            <input type="file" id="fileInput" name="img_path[]" multiple hidden
                                                accept=".jpg,.jpeg,.png,.webp">
                                        </div>


                                        <div class="preview" id="preview"></div>
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
                                    <button type="button" id="uploadBtn" class="btn primary-color px-4"
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
        const titleInput = document.getElementById('title');
        const subTitleInput = document.getElementById('sub_title');
        const shortDescInput = document.getElementById('short_desc');
        const longDescInput = document.getElementById('long_desc');
        const metaTitleInput = document.getElementById('meta_title');
        const metaDescInput = document.getElementById('meta_desc');
        const metaKeyInput = document.getElementById('meta_key');
        const dropArea = document.getElementById('dropArea');
        const fileInput = document.getElementById('fileInput');
        const preview = document.getElementById('preview');
        const uploadBtn = document.getElementById('uploadBtn');
        const form = document.getElementById('pUploadForm');

        let files = [];

        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        const maxSize = 2 * 1024 * 1024; // ✅ 2MB in bytes

        dropArea.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        dropArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropArea.classList.add('dragover');
        });

        dropArea.addEventListener('dragleave', () => {
            dropArea.classList.remove('dragover');
        });

        dropArea.addEventListener('drop', (e) => {
            e.preventDefault();
            dropArea.classList.remove('dragover');
            handleFiles(e.dataTransfer.files);
        });

        function handleFiles(selectedFiles) {
            for (let file of selectedFiles) {


                // allow only jpg, jpeg, png, webp
                if (!allowedTypes.includes(file.type)) {
                    alert("Only JPG, JPEG, PNG and WEBP files are allowed.");
                    continue;
                }

                // ✅ Size validation
                if (file.size > maxSize) {
                    alert("Maximum allowed size is 2MB.");
                    continue;
                }
                // Prevent duplicate files
                if (files.some(f => f.name === file.name && f.size === file.size)) {
                    continue;
                }

                files.push(file);

                let reader = new FileReader();
                reader.onload = function(e) {
                    let img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = "120px";
                    img.style.margin = "5px";
                    preview.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        }

        uploadBtn.addEventListener('click', function(e) {
            e.preventDefault();

            uploadBtn.innerText = 'Processing...';
            // Correct way to disable button
            uploadBtn.setAttribute('disabled', true);

            if (titleInput.value.trim() === '' || subTitleInput.value.trim() === '') {
                alert("Please fill in the Title and Sub Title fields.");
                uploadBtn.innerText = 'Save';
                uploadBtn.removeAttribute('disabled');
                return;
            }

            if (files.length === 0) {
                alert("Please select images first.");
                uploadBtn.innerText = 'Save';
                uploadBtn.removeAttribute('disabled');
                return;
            }

            let formData = new FormData();

            files.forEach((file) => {
                formData.append('images[]', file);
            });

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('title', titleInput.value.trim());
            formData.append('category_id', document.getElementById('category_id').value);
            formData.append('price_per_night', document.getElementById('price_per_night').value);
            formData.append('price_per_week', document.getElementById('price_per_week').value);
            formData.append('price_per_month', document.getElementById('price_per_month').value);
            formData.append('sub_title', subTitleInput.value.trim());
            formData.append('short_desc', shortDescInput.value.trim());
            formData.append('long_desc', longDescInput.value.trim());
            formData.append('meta_title', metaTitleInput.value.trim());
            formData.append('meta_desc', metaDescInput.value.trim());
            formData.append('meta_key', metaKeyInput.value.trim());

            fetch(form.action, {
                    method: "POST",
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw err;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // console.log(data);
                    if (data.status) {
                        alert(data.message);
                        window.location.href = "{{ route('admin.property-categories.index') }}";
                    } else {
                        alert(data.message);
                        uploadBtn.innerText = 'Save';
                        uploadBtn.removeAttribute('disabled');
                    }
                })
                .catch(error => {
                    console.log(error);
                    uploadBtn.innerText = 'Save';
                    uploadBtn.removeAttribute('disabled');
                });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#long_desc').summernote({
                placeholder: 'Details',
                tabsize: 2,
                height: 300,
                color: {
                    background: '#ffffff',
                    foreground: '#000000',
                }
            });
        });

        $(document).on('input', '.numeric-only', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    </script>
@endpush
