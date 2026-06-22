@extends('admin.layouts.app')
@section('title', 'Home Page')
@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-lg-12">
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="card border-0">
                            <form action="{{ route('admin.home-page-setting.store') }}"
                                class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data"
                                id="sForm">
                                @csrf
                                <div class="card">
                                    <div class="card-header primary-color">
                                        <h4>Page Details (Home Page)</h4>
                                    </div>
                                    <div class="card-body">
                                        <br />

                                        <div class="form-group row d-none  mb-2">
                                            <label for=""
                                                class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                                Title <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" name="title" id="title" class="form-control"
                                                    value="{{ optional($homePage)->title }}">
                                            </div>
                                        </div>
                                        <div class="form-group d-none row mb-2">
                                            <label for=""
                                                class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                                Desctiption</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <textarea name="description" id="description" class="form-control" rows="3">{{ optional($homePage)->description }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row  mb-2">
                                            <label for=""
                                                class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Banner
                                                Title
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" name="banner_title" id="banner_title"
                                                    class="form-control" value="{{ optional($homePage)->banner_title }}">
                                            </div>
                                        </div>
                                        <div class="form-group row  mb-2">
                                            <label for="firstname"
                                                class="d-flex justify-content-end col-md-3 col-sm-3 col-xs-12">
                                                Banner Sub Title </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="teext" name="banner_sub_title" id="banner_sub_title"
                                                    class="form-control"
                                                    value="{{ optional($homePage)->banner_sub_title }}">
                                            </div>
                                        </div>
                                        <div class="form-group row  mb-2">
                                            <label for=""
                                                class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Banner
                                                Image</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="file" name="banner_img" id="banner_img" class="form-control"
                                                    accept=".jpg,.jpeg,.png,.webp" onchange="previewSiteBannerImage(event)"
                                                    @if (!isset($homePage) && !isset($homePage->banner_img)) required @endif>
                                                <img @if ($homePage && $homePage->banner_img) src="{{ $homePage->banner_img }}"
                                    @else style="display: none;" @endif
                                                    alt="Banner Image" width="150" id="siteLogoPreview">
                                            </div>
                                        </div>

                                        <div class="form-group row  mb-2">
                                            <label for=""
                                                class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Section
                                                One Title
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" name="setion_one_title" id="setion_one_title"
                                                    class="form-control" value="{{ optional($homePage)->setion_one_title }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="form-group row  mb-2">
                                            <label for=""
                                                class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                                Section One Description
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <textarea name="setion_one_desc" id="setion_one_desc" class="form-control" rows="3">{{ optional($homePage)->setion_one_desc }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row  mb-2">
                                            <label for=""
                                                class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Section
                                                One Button Text
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" name="setion_one_btn_text" id="setion_one_btn_text"
                                                    class="form-control"
                                                    value="{{ optional($homePage)->setion_one_btn_text }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row  mb-2">
                                            <label for=""
                                                class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Section
                                                One Button Link
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" name="setion_one_btn_link" id="setion_one_btn_link"
                                                    class="form-control"
                                                    value="{{ optional($homePage)->setion_one_btn_link }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group row  mb-2">
                                            <label for=""
                                                class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Section One
                                                Image
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="file" name="setion_one_img" id="setion_one_img"
                                                    class="form-control" onchange="previewFSectionImage(event)">
                                                <img @if ($homePage && $homePage->setion_one_img) src="{{ $homePage->setion_one_img }}"
                                    @else style="display: none;" @endif
                                                    alt="Section Image" width="150" id="faviconPreview">
                                            </div>
                                        </div>

                                        <div class="form-group row  mb-2">
                                            <label for=""
                                                class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Section
                                                Two Title
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" name="setion_two_title" id="setion_two_title"
                                                    class="form-control"
                                                    value="{{ optional($homePage)->setion_two_title }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row  mb-2">
                                            <label for=""
                                                class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                                Section Two Description
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <textarea name="setion_two_desc" id="setion_two_desc" class="form-control" rows="3">{{ optional($homePage)->setion_two_desc }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row  mb-2">
                                            <label for=""
                                                class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Section Two
                                                Image
                                            </label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="file" name="setion_two_img" id="setion_two_img"
                                                    class="form-control" onchange="previewSSectionImage(event)">
                                                <img @if ($homePage && $homePage->setion_two_img) src="{{ $homePage->setion_two_img }}"
                                    @else style="display: none;" @endif
                                                    alt="Section Image" width="150" id="sfaviconPreview">
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
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input type="text" name="meta_title" id="meta_title"
                                                    class="form-control" value="{{ optional($homePage)->meta_title }}"
                                                    required>
                                            </div>
                                        </div>

                                        <div class="form-group  row mb-2">
                                            <label for=""
                                                class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                                Meta
                                                Description</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <textarea name="meta_desc" id="meta_desc" class="form-control" rows="3">{{ optional($homePage)->meta_desc }}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group  row mb-2">
                                            <label for=""
                                                class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                                Meta
                                                Keywords</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
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
                    <div class="col-md-6">
                        <div class="card border-0">
                            <form action="{{ route('admin.save-home-page-image') }}"
                                class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data"
                                id="hpimgUploadForm">
                                @csrf
                                <div class="card">
                                    <div class="card-header primary-color">
                                        <h4>Home Page Images</h4>
                                    </div>
                                    <div class="card-body">
                                        <br />
                                        <div class="form-group row  mb-2">
                                            <label for="Img"
                                                class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                                Multiple Image Upload (Drag & Drop)</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <small>Max Upload file size 2MB</small>

                                                <div class="drop-area" id="dropArea">
                                                    <p>Drag & Drop Images Here or Click to Select</p>
                                                    <input type="file" id="fileInput" name="hp_images[]" multiple
                                                        hidden accept=".jpg,.jpeg,.png,.webp">
                                                </div>


                                                <div class="preview" id="preview"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="d-flex justify-content-center">
                                                <div class="d-md-flex d-grid align-items-center gap-3">
                                                    <button type="button" id="uploadBtn"
                                                        class="btn primary-color px-4">Upload</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>

                            <div class="card-body">

                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>SL No</th>
                                            <th>Image</th>
                                            <th>Created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pageGallery as $pg)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <img src="{{ $pg->images }}" alt="Image {{ $loop->iteration }}"
                                                        width="80" class="rounded">
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($pg->created_at)->format('d-m-Y') }}</td>
                                                <td>
                                                    <form action="{{ route('admin.delete-home-page-image', $pg->id) }}"
                                                        method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this?');">Delete</button>
                                                    </form>
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
    <script>
        const dropArea = document.getElementById('dropArea');
        const fileInput = document.getElementById('fileInput');
        const preview = document.getElementById('preview');
        const uploadBtn = document.getElementById('uploadBtn');
        const form = document.getElementById('hpimgUploadForm');

        let files = [];

        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        const maxSize = 20 * 1024 * 1024; // ✅ 2MB in bytes

        // Store all files here
        const dt = new DataTransfer();

        dropArea.addEventListener('click', () => {
            fileInput.click();
        });

        // Manual selection
        fileInput.addEventListener('change', function() {
            addFiles(this.files);
        });

        // Drag over
        dropArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            dropArea.classList.add('dragover');
        });

        // Drag leave
        dropArea.addEventListener('dragleave', function() {
            dropArea.classList.remove('dragover');
        });

        // Drop
        dropArea.addEventListener('drop', function(e) {
            e.preventDefault();
            dropArea.classList.remove('dragover');

            addFiles(e.dataTransfer.files);
        });

        function addFiles(selectedFiles) {

            Array.from(selectedFiles).forEach(file => {

                if (!allowedTypes.includes(file.type)) {
                    alert('Only JPG, JPEG, PNG and WEBP files are allowed.');
                    return;
                }

                if (file.size > maxSize) {
                    alert('Maximum allowed size is 2MB.');
                    return;
                }

                // Prevent duplicate files
                const exists = Array.from(dt.files).some(existingFile =>
                    existingFile.name === file.name &&
                    existingFile.size === file.size &&
                    existingFile.lastModified === file.lastModified
                );

                if (exists) {
                    return;
                }

                // Add file to DataTransfer
                dt.items.add(file);

                // Update actual input
                fileInput.files = dt.files;

                // Preview
                const reader = new FileReader();

                reader.onload = function(e) {

                    const img = document.createElement('img');

                    img.src = e.target.result;
                    img.style.width = '145px';
                    img.style.margin = '5px';
                    img.style.borderRadius = '6px';

                    preview.appendChild(img);
                };

                reader.readAsDataURL(file);

            });

            console.log('Total Files:', fileInput.files.length);
        }

        uploadBtn.addEventListener('click', function(e) {
            e.preventDefault();

            uploadBtn.innerText = 'Processing...';
            // Correct way to disable button
            uploadBtn.setAttribute('disabled', true);

            if (fileInput.files.length === 0) {
                alert("Please select images first.");
                uploadBtn.innerText = 'Save';
                uploadBtn.removeAttribute('disabled');
                return;
            }

            let formData = new FormData();

            Array.from(fileInput.files).forEach((file) => {
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
                        uploadBtn.innerText = 'Save';
                        uploadBtn.removeAttribute('disabled');
                    }
                    return response.json();
                })
                .then(data => {
                    alert(data.message);
                    window.location.reload();
                })
                .catch(error => {
                    console.log(error);
                    uploadBtn.innerText = 'Save';
                    uploadBtn.removeAttribute('disabled');
                });
        });
    </script>
@endpush
