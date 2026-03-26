@extends('admin.layouts.app')
@section('title', 'CMS Gallery')
@section('content')
    <div class="container-fluid px-4">
        {{-- <h1 class="mt-4">CMS Home Page</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item ">CMS Home Page</li>
        </ol> --}}
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

                    <form action="{{ route('admin.gallery-page-setting.store') }}" id="imgUploadForm"
                        class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card mb-5">
                            <div class="card-header primary-color">
                                <h4>Add Gallery Image</h4>
                            </div>
                            <div class="card-body">
                                <br />
                                <div class="form-group row  mb-2">
                                    <label for="Img" class="col-md-2 d-flex justify-content-end col-sm-3 col-xs-12">
                                        Multiple Image Upload (Drag & Drop)</label>
                                    <div class="col-md-8 col-sm-6 col-xs-12">


                                        <div class="drop-area" id="dropArea">
                                            <p>Drag & Drop Images Here or Click to Select</p>
                                            <input type="file" id="fileInput" name="img_path[]" multiple hidden
                                                accept=".jpg,.jpeg,.png,.webp">
                                        </div>


                                        <div class="preview" id="preview"></div>
                                    </div>

                                    <div class="col-md-2 col-sm-6 col-xs-12">

                                        <div class="d-flex justify-content-center">
                                            <div class="d-md-flex d-grid align-items-center gap-3">
                                                <button type="button" id="uploadBtn" class="btn primary-color px-4">Upload
                                                    Images</button>
                                                {{-- <button type="submit" id="submitBtn1" class="btn primary-color px-4"
                                                    name="submit2">Upload Images</button> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="card-header primary-color">
                        <h4>Page Details (Gallery Page)</h4>
                    </div>
                    <div class="card-body">

                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>SL No</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($galleries as $g)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><b>{{ 'Image ' . $loop->iteration }}</b></td>
                                        <td>
                                            <img src="{{ $g->img_path }}" alt="{{ $g->title }}" width="80"
                                                class="rounded">
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($g->created_at)->format('d-m-Y') }}</td>
                                        <td>
                                            {{-- <a href="{{ route('admin.gallery-page-setting.edit', $g->id) }}"
                                                class="btn btn-sm btn-primary">Edit</a> --}}
                                            <form action="{{ route('admin.gallery-page-setting.destroy', $g->id) }}"
                                                method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this?');">Delete</button>
                                            </form>

                                            <label class="switch my-1" title="Show on Page">
                                                <input type="checkbox" id="accessToggle_{{ $loop->iteration }}"
                                                    onchange="accessUpdate('{{ route('admin.gallery-page-setting.show', $g->id) }}','{{ $loop->iteration }}')"
                                                    {{ $g->status == 1 ? 'checked' : '' }}>
                                                <span class="slider"></span>
                                            </label>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{-- <script>
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
    </script> --}}

    <script>
        const dropArea = document.getElementById('dropArea');
        const fileInput = document.getElementById('fileInput');
        const preview = document.getElementById('preview');
        const uploadBtn = document.getElementById('uploadBtn');
        const form = document.getElementById('imgUploadForm');

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

            if (files.length === 0) {
                alert("Please select images first.");
                return;
            }

            let formData = new FormData();

            files.forEach((file) => {
                formData.append('images[]', file);
            });

            formData.append('_token', "{{ csrf_token() }}");

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
                    alert(data.message);
                    window.location.reload();
                })
                .catch(error => {
                    console.log(error);
                });
        });
    </script>
@endpush
