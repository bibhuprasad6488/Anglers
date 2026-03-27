@extends('admin.layouts.app')
@section('title', 'Terms Of Business')
@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                    <div class="py-2 d-none">
                        <h1 class="mt-4">Terms Of Business</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Terms Of Business</li>
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
                    <div class="card-header primary-color">
                        <h4>Terms & Conditions</h4>
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
                    <div class="card-body p-1">
                        <form method="POST" action="{{ route('admin.term.business.store') }}" enctype="multipart/form-data"
                            id="sForm">
                            @csrf

                            <div class="form-group mb-3">
                                {{-- <label class="form-label fw-semibold">
                                        Contnt
                                    </label> --}}
                                <textarea name="content" rows="4" class="form-control" id="cont" placeholder="Content">{{ $term->content ?? old('content') }}</textarea>
                            </div>

                            <!-- Actions -->
                            <div class="mt-4 d-flex justify-content-end gap-2">
                                <button type="submit" class="btn primary-color px-4" id="submitBtn1">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
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
            $('#cont').summernote({
                placeholder: 'Content',
                tabsize: 2,
                height: 600
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
