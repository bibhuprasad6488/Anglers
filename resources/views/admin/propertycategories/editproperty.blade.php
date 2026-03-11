@extends('admin.layouts.app')
@section('title', 'Edit Property Details')
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

                    <div class="ms-auto d-none">
                        <div class="btn-group">
                            <a href="{{ route('admin.posts.create') }}" class="btn primary-color">Create</a>
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
                    <form action="{{ route('admin.properties.update', $property->id) }}"
                        class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data"
                        id="pUploadForm">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-header primary-color">
                                <h4>Edit Property Details</h4>
                            </div>
                            <div class="card-body">
                                <br />

                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Title <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <input type="text" name="title" id="title" class="form-control"
                                            value="{{ $property->title }}" placeholder="Title" required>
                                    </div>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <input type="hidden" name="category_id" id="category_id" class="form-control"
                                            value="{{ $property->category_id }}">
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Sub Title <span class="text-danger">*</span>
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <input type="text" name="sub_title" id="sub_title" class="form-control"
                                            value="{{ $property->sub_title }}" placeholder="Sub Title" required>
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Price Per Night
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <input type="text" name="price" id="price"
                                            class="form-control numeric-only" value="{{ $property->price }}"
                                            placeholder="Price">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Short Description</label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <textarea name="short_desc" id="short_desc" class="form-control" rows="3" placeholder="Short desc">{{ $property->short_desc }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row  mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Details
                                    </label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <textarea name="long_desc" id="long_desc" class="form-control" rows="3">{{ $property->long_desc }}</textarea>
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
                                        @foreach ($images as $img)
                                            <div class="card p-0 my-2" style="display: inline-block;">
                                                <div class="card-header py-0 text-center" style="cursor: pointer;"
                                                    onclick="deleteImage('{{ route('admin.del-property-img', $img->id) }}','{{ $loop->iteration }}')">
                                                    <i class="fa fa-times"></i> Delete
                                                </div>
                                                <div>
                                                    <img src="{{ $img->img_path }}" alt="" width="120px"
                                                        style="margin: 5px">
                                                </div>
                                            </div>
                                        @endforeach
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
                                            value="{{ $property->meta_title }}" placeholder="Meta title">
                                    </div>
                                </div>

                                <div class="form-group  row mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Meta
                                        Description</label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <textarea name="meta_desc" id="meta_desc" class="form-control" rows="3" placeholder="Meta Description">{{ $property->meta_desc }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group  row mb-2">
                                    <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Meta
                                        Keywords</label>
                                    <div class="col-md-9 col-sm-6 col-xs-12">
                                        <textarea name="meta_key" id="meta_key" class="form-control" rows="3" placeholder="Meta Keys">{{ $property->meta_key }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <div class="d-md-flex d-grid align-items-center gap-3">
                                    <button type="button" id="uploadBtn" class="btn primary-color px-4"
                                        name="submit2">Update</button>
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

            if (titleInput.value.trim() === '' || subTitleInput.value.trim() === '') {
                alert("Please fill in the Title and Sub Title fields.");
                return;
            }

            // if (files.length === 0) {
            //     alert("Please select images first.");
            //     return;
            // }

            let formData = new FormData();

            files.forEach((file) => {
                formData.append('images[]', file);
            });

            formData.append('_token', "{{ csrf_token() }}");
            formData.append('_method', "PUT"); // ADD THIS LINE
            formData.append('title', titleInput.value.trim());
            formData.append('category_id', document.getElementById('category_id').value);
            formData.append('price', document.getElementById('price').value);
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
                    console.log(data);
                    if (data.status) {
                        alert(data.message);
                        window.location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.log(error);
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

        function deleteImage(action, k) {
            if (confirm("Are you sure you want to delete this image?")) {
                fetch(action, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            alert(data.message);
                            window.location.reload();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        }
    </script>
@endpush
