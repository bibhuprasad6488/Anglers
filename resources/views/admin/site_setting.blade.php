@extends('admin.layouts.app')
@section('title', 'Site Setting')
@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Site Setting</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
            <li class="breadcrumb-item ">Site Setting</li>
        </ol>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card">
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
                        <form action="{{ route('admin.update.site.setting') }}" class="form-horizontal form-label-left"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <br />

                            <div class="form-group row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Site
                                    Title <span>*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="site_title" id="site_title" class="form-control"
                                        value="{{ optional($setting)->site_title }}" required>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Site
                                    Desctiption</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="site_desc" id="site_desc" class="form-control" rows="3">{{ optional($setting)->site_desc }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Contact
                                    No
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="contact_phone" id="contact_phone" class="form-control"
                                        value="{{ optional($setting)->contact_phone }}" required>
                                </div>
                            </div>
                            <div class="form-group row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Alt.
                                    Contact No
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="alt_phone" id="alt_phone" class="form-control"
                                        value="{{ optional($setting)->alt_phone }}">
                                </div>
                            </div>
                            <div class="form-group row  mb-2">
                                <label for=""
                                    class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Call/Whatsapp No
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="call_wp_number" id="call_wp_number" class="form-control"
                                        value="{{ optional($setting)->call_wp_number }}">
                                </div>
                            </div>
                            <div class="form-group row  mb-2">
                                <label for=""
                                    class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Whatsapp Message
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="wp_message" id="wp_message" class="form-control" rows="3">{{ optional($setting)->wp_message }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row  mb-2">
                                <label for="firstname" class="d-flex justify-content-end col-md-3 col-sm-3 col-xs-12">
                                    Email ID </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="email" name="contact_email" id="contact_email" class="form-control"
                                        value="{{ optional($setting)->contact_email }}">
                                </div>
                            </div>
                            <div class="form-group row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Alt.
                                    Email</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="email" name="alt_email" id="alt_email" class="form-control"
                                        value="{{ optional($setting)->alt_email }}">
                                </div>
                            </div>
                            <div class="form-group row  mb-2">
                                <label for=""
                                    class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Logo</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" name="site_logo" id="site_logo" class="form-control"
                                        accept=".jpg,.jpeg,.png,.webp" onchange="previewSiteLogoImage(event)"
                                        @if (!$setting && !$setting->site_logo) required @endif>
                                    <img @if ($setting && $setting->site_logo) src="{{ $setting->site_logo }}"
                                    @else style="display: none;" @endif
                                        alt="Site Logo" width="150" id="siteLogoPreview">
                                </div>
                            </div>
                            <div class="form-group row  mb-2">
                                <label for=""
                                    class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Footer
                                    Logo</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" name="footer_logo" id="footer_logo" class="form-control"
                                        onchange="previewFooterLogoImage(event)"
                                        @if (!$setting && !$setting->footer_logo) required @endif>
                                    <img @if ($setting && $setting->footer_logo) src="{{ $setting->footer_logo }}"
                                    @else style="display: none;" @endif
                                        alt="Site Logo" class="bg-gray" width="150" id="footerLogoPreview">
                                </div>
                            </div>
                            <div class="form-group row  mb-2">
                                <label for=""
                                    class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Footer
                                    Logo One</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" name="footer_logo_one" id="footer_logo_one"
                                        class="form-control">
                                    <img @if ($setting && $setting->footer_logo_one) src="{{ $setting->footer_logo_one }}"
                                    @else style="display: none;" @endif
                                        alt="Site Logo" width="100">
                                </div>
                            </div>
                            <div class="form-group row  mb-2">
                                <label for=""
                                    class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Footer
                                    Logo Two</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" name="footer_logo_two" id="footer_logo_two"
                                        class="form-control">
                                    <img @if ($setting && $setting->footer_logo_two) src="{{ $setting->footer_logo_two }}"
                                    @else style="display: none;" @endif
                                        alt="Site Logo" width="100">
                                </div>
                            </div>

                            <div class="form-group row  mb-2">
                                <label for=""
                                    class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Favicon
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="file" name="favicon" id="favicon" class="form-control"
                                        onchange="previewFaviconImage(event)">
                                    <img @if ($setting && $setting->favicon) src="{{ $setting->favicon }}"
                                    @else style="display: none;" @endif
                                        alt="Site Logo" width="32" height="32" id="faviconPreview">
                                </div>
                            </div>
                            <div class="form-group row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                    Address
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="address" id="address" class="form-control" rows="3">{{ optional($setting)->address }}</textarea>
                                </div>
                            </div>

                            <div class="form-group d-none row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">
                                    Google Map Setting
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="site_map_key" id="site_map_key" class="form-control" rows="3" placeholder="Iframe link">{{ optional($setting)->site_map_key }}</textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Site
                                    CTA Title </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="cta_title" id="cta_title" class="form-control"
                                        value="{{ optional($setting)->cta_title }}" placeholder="CTA Title">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Site
                                    CTA Sub Title</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="cta_sub_title" id="cta_sub_title" class="form-control"
                                        value="{{ optional($setting)->cta_sub_title }}" placeholder="CTA Sub Title">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Site
                                    Footer Text One</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="footer_text_one" id="footer_text_one" class="form-control" rows="3">{{ optional($setting)->footer_text_one }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Site
                                    Footer Text Two</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="footer_text_two" id="cont" class="form-control" rows="3">{{ optional($setting)->footer_text_two }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row  mb-2">
                                <label for=""
                                    class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Copyrights
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="copyright" id="copyright" class="form-control"
                                        value="{{ optional($setting)->copyright }}" required>
                                </div>
                            </div>

                            <div class="form-group d-none row mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Site
                                    Meta
                                    Description</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="site_meta_desc" id="site_meta_desc" class="form-control" rows="3">{{ optional($setting)->site_meta_desc }}</textarea>
                                </div>
                            </div>

                            <div class="form-group d-none row mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">Site
                                    Meta
                                    Keywords</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <textarea name="site_meta_key" id="site_meta_key" class="form-control" rows="3">{{ optional($setting)->site_meta_key }}</textarea>
                                </div>
                            </div>
                            <div class="form-group d-none row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">SMTP
                                    Host
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="smtp_host" id="smtp_host" class="form-control"
                                        value="{{ optional($setting)->smtp_host }}">
                                </div>
                            </div>
                            <div class="form-group d-none row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">SMTP
                                    Port
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="smtp_port" id="smtp_port" class="form-control"
                                        value="{{ optional($setting)->smtp_port }}">
                                </div>
                            </div>
                            <div class="form-group d-none row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">SMTP
                                    Username
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="smtp_username" id="smtp_username" class="form-control"
                                        value="{{ optional($setting)->smtp_username }}">
                                </div>
                            </div>
                            <div class="form-group d-none row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">SMTP
                                    Password
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="smtp_password" id="smtp_password" class="form-control"
                                        value="{{ optional($setting)->smt_password }}">
                                </div>
                            </div>
                            <div class="form-group d-none row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">SMTP
                                    From
                                    Name
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="smtp_from_name" id="smtp_from_name" class="form-control"
                                        value="{{ optional($setting)->smtp_from_name }}">
                                </div>
                            </div>
                            <div class="form-group d-none row  mb-2">
                                <label for="" class="col-md-3 d-flex justify-content-end col-sm-3 col-xs-12">SMTP
                                    From
                                    Email
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" name="smtp_from_email" id="smtp_from_email"
                                        class="form-control" value="{{ optional($setting)->smtp_from_email }}">
                                </div>
                            </div>


                            <hr />
                            <div class="row">
                                <label class=" col-form-label"></label>
                                <div class="d-flex justify-content-center">
                                    <div class="d-md-flex d-grid align-items-center gap-3">
                                        <button type="submit" id="submitBtn1" class="btn btn-primary px-4"
                                            name="submit2">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function previewSiteLogoImage(event) {
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

        function previewFooterLogoImage(event) {
            const input = event.target;
            const preview = document.getElementById('footerLogoPreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewFaviconImage(event) {
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
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#cont').summernote({
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
