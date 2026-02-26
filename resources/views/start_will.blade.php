@extends('layouts.app')
@section('title', 'Start Your Wills')

@section('content')

    <div class="services text-center">
        <!-- HERO -->
        <div class="services text-center">
            {{-- <video class="bg-video" autoplay muted loop playsinline>
            <source src="{{ asset('assets/videos/intro.mp4') }}" type="video/mp4">
        </video> --}}
            <img src="{{ asset('assets/images/banner_bg.jpg') }}" class="bg-video" alt="Sterling Wills & Estate Planning">

            <div class="mask">
                <div class="text-white">
                    <h2 class="mb-3 inner-page-title">Start Your Will</h2>
                </div>
            </div>
        </div>

        @include('layouts.mob_header')
    </div>

    <section class="py-5 mb-6 cm10">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-4 mx-auto">

                    <h2 class="fw-bold text-center maastrix fs-1 mb-4">
                        Start Your Will
                    </h2>

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

                    <form method="POST" action="{{ route('start.will.submit') }}" id="willForm">
                        @csrf

                        <!-- STEP 1 -->
                        <div class="step">
                            <h3 class="mb-4 text-center">What do you need?</h3>
                            <p class="fw-semibold">What would you like to set up today?</p>

                            <div class="form-check custom-check mb-3">
                                <input type="checkbox" name="setup[]" value="will" id="setupWill" class="">
                                <label class="form-check-label" for="setupWill">A Will</label>
                            </div>

                            <div class="form-check custom-check mb-3">
                                <input type="checkbox" name="setup[]" value="lpa" id="setupLpa">
                                <label class="form-check-label" for="setupLpa">A Lasting Power of Attorney</label>
                            </div>

                            <div class="form-check custom-check mb-4">
                                <input type="checkbox" name="setup[]" value="trust" id="setupTrust">
                                <label class="form-check-label" for="setupTrust">A Trust</label>
                            </div>

                            <button type="button" class="btn btn-secondary rounded-0 px-4"
                                onclick="nextStep()">Next</button>
                        </div>

                        <!-- STEP 2 -->
                        <div class="step d-none">
                            <h3 class="mb-4">About you</h3>

                            <div class="mb-3">
                                <label class="form-label">Full name</label>
                                <input type="text" name="full_name" class="form-control border-secondary rounded-0"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email address</label>
                                <input type="email" name="email" class="form-control border-secondary rounded-0"
                                    required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Postcode</label>
                                <input type="text" name="postcode" class="form-control border-secondary rounded-0"
                                    required>
                            </div>

                            <button type="button" class="btn btn-outline-secondary rounded-0 px-4 me-2"
                                onclick="prevStep()">Back</button>
                            <button type="button" class="btn btn-secondary rounded-0 px-4"
                                onclick="nextStep()">Next</button>
                        </div>

                        <!-- STEP 3 -->
                        <div class="step d-none">
                            <h3 class="mb-4">Important confirmations</h3>

                            <div class="form-check custom-check mb-3">
                                <input type="checkbox" name="confirm_england" id="c1" value="yes" required>
                                <label class="form-check-label" for="c1">
                                    I live in England or Wales
                                </label>
                            </div>

                            <div class="form-check custom-check mb-3">
                                <input type="checkbox" name="confirm_self" id="c2" value="yes" required>
                                <label class="form-check-label" for="c2">
                                    I am completing this for myself
                                </label>
                            </div>

                            <div class="form-check custom-check mb-3">
                                <input type="checkbox" name="confirm_no_advice" id="c3" value="yes" required>
                                <label class="form-check-label" for="c3">
                                    I understand this is not legal advice
                                </label>
                            </div>

                            <div class="form-check custom-check mb-4">
                                <input type="checkbox" name="confirm_free_will" id="c4" value="yes" required>
                                <label class="form-check-label" for="c4">
                                    I am doing this of my own free will
                                </label>
                            </div>

                            <button type="button" class="btn btn-outline-secondary rounded-0 px-4 me-2"
                                onclick="prevStep()">Back</button>

                            <button type="button" class="btn btn-secondary rounded-0 px-4"
                                onclick="nextStep()">Next</button>
                        </div>

                        <!-- STEP 4 -->
                        <div class="step d-none">
                            <h3 class="mb-4">Assets</h3>
                            <p class="text-muted">Do you have any of the following?</p>

                            <div class="form-check custom-check mb-3">
                                <input type="checkbox" name="assets[]" value="property" id="a1">
                                <label class="form-check-label" for="a1">Property</label>
                            </div>

                            <div class="form-check custom-check mb-3">
                                <input type="checkbox" name="assets[]" value="savings" id="a2">
                                <label class="form-check-label" for="a2">Savings or investments</label>
                            </div>

                            <div class="form-check custom-check mb-4">
                                <input type="checkbox" name="assets[]" value="business" id="a3">
                                <label class="form-check-label" for="a3">A business</label>
                            </div>

                            <button type="button" class="btn btn-outline-secondary rounded-0 px-4 me-2"
                                onclick="prevStep()">Back</button>
                            <button type="submit" class="btn btn-secondary rounded-0 px-5">Submit</button>
                        </div>

                        <!-- Progress Bar -->
                        <div class="progress my-4" style="height:6px;">
                            <div class="progress-bar" id="progressBar" style="width:25%"></div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('scripts')
    <script>
        let currentStep = 0;
        const steps = document.querySelectorAll('.step');
        const progressBar = document.getElementById('progressBar');

        function showStep(index) {
            steps.forEach((step, i) => {
                step.classList.toggle('d-none', i !== index);
            });
            progressBar.style.width = ((index + 1) / steps.length) * 100 + '%';
        }

        function validateStep(stepIndex) {
            if (stepIndex === 0 && !document.querySelector('input[name="setup[]"]:checked')) {
                alert('Please select at least one option to continue.');
                return false;
            }

            if (stepIndex === 1) {
                for (const input of steps[1].querySelectorAll('input[required]')) {
                    if (!input.checkValidity()) {
                        input.reportValidity();
                        return false;
                    }
                }
            }

            if (stepIndex === 2) {
                for (const box of steps[2].querySelectorAll('input[type="checkbox"]')) {
                    if (!box.checked) {
                        alert('Please confirm all statements.');
                        return false;
                    }
                }
            }

            return true;
        }

        function nextStep() {
            if (!validateStep(currentStep)) return;
            if (currentStep < steps.length - 1) currentStep++;
            showStep(currentStep);
        }

        function prevStep() {
            if (currentStep > 0) currentStep--;
            showStep(currentStep);
        }

        document.querySelectorAll('.custom-check input').forEach(input => {
            input.addEventListener('change', function() {
                this.closest('.custom-check').classList.toggle('active', this.checked);
            });
        });

        showStep(currentStep);
    </script>
    <script>
        $(document).on('input', '.numeric-only', function() {
            this.value = this.value.replace(/\D/g, '');
        });
    </script>
@endpush
