@extends('layouts.app')
@section('title', 'Protection')

@section('content')

    <!-- HERO -->
    <div class="servics cmt10 pt-5" class="text-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    {!! $protect->p_desc !!}
                </div>
                <div class="col-lg-6 text-center">
                    <!-- Replace with your image -->
                    <img src="{{ $protect->p_image }}" class="img-fluid rounded" alt="Protection">
                </div>
            </div>
        </div>
    </div>

    <!-- MOB HEADER -->
    @include('layouts.mob_header')

    <!-- SERVICES -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-5 fw-bold">Our Protection Services</h2>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="service-card text-center">
                        <div class="service-icon">
                            <img src="{{ $protect->ps_img_one }}" alt="{{ $protect->ps_title_one }}">
                        </div>
                        <h5 class="fw-bold">{{ $protect->ps_title_one }}</h5>
                        <p>{{ $protect->ps_desc_one }}</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="service-card text-center">
                        <div class="service-icon">
                            <img src="{{ $protect->ps_img_two }}" alt="{{ $protect->ps_title_two }}">
                        </div>
                        <h5 class="fw-bold">{{ $protect->ps_title_two }}</h5>
                        <p>{{ $protect->ps_desc_two }}</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="service-card text-center">
                        <div class="service-icon">
                            <img src="{{ $protect->ps_img_three }}" alt="{{ $protect->ps_title_three }}">
                        </div>
                        <h5 class="fw-bold">{{ $protect->ps_title_three }}</h5>
                        <p>{{ $protect->ps_desc_three }}</p>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="service-card text-center">
                        <div class="service-icon">
                            <img src="{{ $protect->ps_img_four }}" alt="{{ $protect->ps_title_four }}">
                        </div>
                        <h5 class="fw-bold">{{ $protect->ps_title_four }}</h5>
                        <p>{{ $protect->ps_desc_four }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PARTNER -->
    <section class="py-4 bg-light">
        <div class="container partn">
            <h5 class="fs-4 text-center">In Partnership with <strong>Portman Rise</strong></h5>
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <p class="mt-3 fs-5">
                        {{ $protect->pp_desc_one }}
                    </p>

                </div>
                <div class="col-lg-6 text-center border-secondary portman">
                    <!-- Replace with your image -->
                    <img src="{{ $protect->pp_img }}" class="img-fluid rounded border" alt="Protection">
                </div>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section class="py-5">
        <div class="container">
            <p class="mb-5">Our process starts with an <b>initial consultation</b> to understand your situation, followed
                by a referral to the regulated advisers at Portman Rise. They’ll provide <b>personalised, FCA-regulated
                    advice </b> recommend protection solutions tailored to your needs.</p>
            <h2 class="text-center mb-5 fw-bold">How It Works</h2>

            <div class="row g-4">
                <div class="col-md-3">
                    <div class="step-box text-center">
                        <strong>1</strong>
                        <img src="{{ $protect->pw_img_one }}" height="100" alt="{{ $protect->pw_title_one }}">
                        <p class="mt-2">✔ {{ $protect->pw_title_one }}</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="step-box text-center">
                        <strong>2</strong>
                        <img src="{{ $protect->pw_img_two }}" height="100" alt="{{ $protect->pw_title_two }}">
                        <p class="mt-2">✔ {{ $protect->pw_title_two }}</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="step-box text-center">
                        <strong>3</strong>
                        <img src="{{ $protect->pw_img_three }}" height="100" alt="{{ $protect->pw_title_three }}">
                        <p class="mt-2">✔ {{ $protect->pw_title_three }}</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="step-box text-center">
                        <strong>4</strong>
                        <img src="{{ $protect->pw_img_four }}" height="100" alt="{{ $protect->pw_title_four }}">
                        <p class="mt-2">✔ {{ $protect->pw_title_four }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-5">
        <div class="container">
            <div class="cta text-center py-4">
                <h3 class="text-white">{{ $protect->pcta_title }}</h3>
                <span class="w-50">
                    <hr class="text-secondary">
                </span>
                <a href="{{ route('contact') }}"
                    class="btn btn-light  rounded-0 text-uppercase fw-semibold mt-3 px-5">{{ $protect->pcta_btn_text }}</a>
            </div>

            <div class="py-5">
                <p>
                    Please note that <b>Sterling Wills is not authorised or regulated by the Financial Conduct Authority
                        (FCA)</b> and does not provide financial advice. All protection advice is provided independently by
                    Portman Rise, who are FCA-regulated specialists.
                </p>
                <p class="fst-italic d-none">
                    All protection advice is provided by Portman Rise, independent and FCA regulated specialists.
                </p>
            </div>
        </div>
    </section>
    <style>
        .service-card {
            border: 1px solid #e5e5e5;
            padding: 30px;
            border-radius: 8px;
            height: 100%;
        }

        .service-icon {
            font-size: 40px;
            margin-bottom: 15px;
            filter: grayscale(100%);
        }

        .partner-box {
            border: 1px solid #ddd;
            padding: 20px;
            text-align: center;
        }

        .step-box {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            height: 100%;
        }

        .step-box strong {
            background: #000;
            color: #fff;
            border-radius: 25px;
            padding: 6px 14px;
            justify-content: start;
            font-size: 19px;
        }

        .cta {
            background: #2b2b2b;
            color: #fff;
            padding: 50px 20px;
            text-align: center;
            /* border-radius: 8px; */
        }

        .cta .btn {
            background: #fff;
            color: #000;
            font-weight: 600;
        }

        .disclaimer {
            font-size: 14px;
            color: #312f2f;
            margin-top: 40px;
        }
    </style>
@endsection
