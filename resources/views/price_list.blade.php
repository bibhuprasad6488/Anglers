@extends('layouts.app')
@section('title', 'Price Lists')

@section('content')

    <div class="services" class="text-center">
        <!-- HERO -->
        <div class="services" class="text-center">
            {{-- <video class="bg-video" autoplay muted loop playsinline>
            <source src="{{ asset('assets/videos/intro.mp4') }}" type="video/mp4">
        </video> --}}
            <img src="{{ asset('assets/images/banner_bg.jpg') }}" class="bg-video" alt="Sterling Wills & Estate Planning">

            <!-- Overlay (optional dark mask) -->
            <div class="mask">
                <div class="text-white text-center">
                    <h2 class="mb-3 banner-title">Pricing:</h2>
                    <h3 class="mb-3 banner-subtitle"> Estate Planning & Will Writing Services</h3>
                </div>
            </div>
        </div>

        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>

    <section class="section page">
        <div class="container">
            <div class="row g-5">
                <div class="col-xs-12">
                    <div class="d-flex flex-column h-100 gap-3">
                        <h2 class="fw-bold mb-2">
                            Transparent, Fair & Simple Fees
                        </h2>
                        <div class="feature-box flex-fill">
                            <p>At Sterling, we believe in clear pricing so you know exactly what you’re paying for with no
                                hidden surprises. Our fees reflect the <b> quality, expertise and personal support</b> you
                                receive
                                from start to finish. Every client works directly with a dedicated adviser who prepares your
                                documents, answers your questions and guides you until completion — giving you confidence
                                and peace of mind.</p>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 px-5">
                    <div class="d-flex flex-column h-100 gap-2">
                        <h5 class="fw-bold mb-1">
                            <span class="icon">👉</span> Will Writing & Estate Planning Fees
                        </h5>
                        <div class="feature-box flex-fill">
                            <p>Whether you’re planning a simple will or a comprehensive estate strategy, we have options to
                                fit your needs:</p>
                            <ul>
                                <li class="mb-2"><b>Straightforward Single Will</b> – Ideal for individuals with
                                    uncomplicated estates.</li>
                                <li class="mb-2"><b>Mirror Wills (Couples)</b> – Two coordinated wills for partners with
                                    shared wishes.</li>
                                <li class="mb-2"><b>Complex Wills</b> – Includes specialist clauses for trusts, lifetime
                                    interests, or bespoke arrangements.</li>
                                <li class="mb-2"><b>Lasting Powers of Attorney (LPAs)</b> – For Property & Finance and
                                    Health & Welfare decisions.</li>
                                <li class="mb-2"><b>Combined Will + LPA Packages</b> – Save when you plan both together.
                                </li>
                            </ul>
                            <p><span class="icon">💼 </span> prices include professional drafting and support. Additional
                                statutory fees (e.g.,
                                Office of the Public Guardian registration) are charged separately.</p>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 px-5">
                    <div class="d-flex flex-column h-100 gap-2">
                        <h5 class="fw-bold mb-1">
                            <span class="icon">👉</span> Additional Services & Support
                        </h5>
                        <div class="feature-box flex-fill">
                            <p>We also offer:</p>
                            <ul>
                                <li class="mb-2"><b>Document Storage & Updates</b> — Secure storage with optional annual
                                    renewal and discounts on future document changes.</li>
                                <li class="mb-2"><b>Probate & Estate Administration Assistance </b>— We can help executors
                                    or act on your behalf.</li>
                                <li class="mb-2"><b>Inheritance Tax Advice</b> — Practical guidance to help minimise tax
                                    liabilities.</li>
                                <li class="mb-2"><b>Legal & Planning Consultations</b> — Tailored support wherever you are
                                    in life.</li>
                            </ul>
                            <p>Our pricing aims to be competitive but always reflective of the professionalism and
                                continuity you receive throughout the process. Meetings in person or online are available,
                                and any additional charges (e.g., out-of-office visits) are agreed in advance.</p>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 px-5">
                    <div class="d-flex flex-column h-100 gap-2">
                        <h5 class="fw-bold mb-1">
                            <span class="icon">👉</span> Why Our Pricing Works for You
                        </h5>
                        <div class="feature-box flex-fill">
                            <ul>
                                <li class="mb-2"><b>Transparent costs, no hidden fees</b></li>
                                <li class="mb-2"><b>Personal service from qualified experts</b></li>
                                <li class="mb-2"><b>Cost-effective bundles for combined services</b></li>
                                <li class="mb-2"><b>Ongoing support available</b></li>
                            </ul>
                            <p>Estate planning isn’t just paperwork — it’s peace of mind. Contact us today to <a
                                    href="{{ route('contact') }}" class="text-dark btn p-0 fw-bold">get a
                                    personalised quote</a> and find the right solution for you and your family.</p>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 px-5">
                    <div class="d-flex flex-column h-100 gap-2">
                        <h5 class="fw-bold mb-1">
                            <span class="icon">👉</span> Clear Pricing. Professional Service. No Hidden Fees.
                        </h5>
                        <div class="feature-box flex-fill">

                            <p>At Sterling Wills & Estate Planning, we believe pricing should be straightforward and
                                transparent. Our fees are clearly outlined so you know exactly what to expect before you
                                proceed. Every service includes professional advice, tailored documentation, and dedicated
                                support from start to completion — giving you total confidence and peace of mind.</p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="section py-5">
        <div class="container">
            {{-- <h2 class="text-center mb-5 maastrix">Our Services</h2> --}}
            <div class="row gap-5 mb-4">
                <div class="col-md-12 mx-auto">
                    @foreach ($priceArr as $k => $cps)
                        <table class="table mb-4">
                            <thead>
                                <tr>
                                    <td colspan="3" class="fs-3">{{ $cps['cat_name'] }}</td>
                                </tr>
                                <tr>
                                    <th class="fs-5">Service</th>
                                    <th class="fs-5">Description</th>
                                    <th class="fs-5">Price From</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cps['cat_prices'] as $item)
                                    <tr>
                                        <th>{{ $item['title'] }}</th>
                                        <td>{{ $item['text'] }}</td>
                                        <td>{{ '£' . $item['price'] }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="3"><i>{{ $cps['cat_desc'] }}</i></td>
                                </tr>
                            </tbody>
                        </table>
                    @endforeach
                </div>
            </div>

            <div class="row gap-5 mb-5">
                <div class="col-md-12 ">
                    <table class="table ">
                        <thead>
                            <tr>
                                <td colspan="3" class="fs-3">Estate Planning Packages</td>
                            </tr>
                            <tr>
                                <th class="fs-5">Package</th>
                                <th class="fs-5">Includes</th>
                                <th class="fs-5">Price From</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($packages as $package)
                                <tr>
                                    <th>{{ $package->package_title }}</th>
                                    <td>{{ $package->package_text }}</td>
                                    <td>{{ '£' . $package->price }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3"><i>Packages offer excellent value and ensure full future protection.</i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row mb-4">

                <div class="col-md-6 px-5">

                    <h5 class="fw-bold mb-1">
                        Additional Services
                    </h5>
                    <div class="feature-box flex-fill">
                        <ul>
                            <li class="mb-2">Secure document storage (annual or lifetime options available)</li>
                            <li class="mb-2">Ongoing will and LPA reviews</li>
                            <li class="mb-2">Executor and probate assistance</li>
                            <li class="mb-2">Inheritance tax planning guidance</li>
                            <li class="mb-2">Home visits or virtual consultations</li>
                        </ul>
                        <p>Any additional costs are always discussed and agreed in advance.</p>
                    </div>


                </div>

                <div class="col-md-6 px-5">

                    <h5 class="fw-bold mb-1">
                        Why Choose Sterling?
                    </h5>
                    <div class="feature-box flex-fill">
                        <ul class="list-unstyled">
                            <li class="mb-2">✔ Transparent, fixed pricing</li>
                            <li class="mb-2">✔ No hidden charges</li>
                            <li class="mb-2">✔ Personal, one-to-one service</li>
                            <li class="mb-2">✔ Flexible payment options</li>
                            <li class="mb-2">✔ Ongoing support available</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="py-5">
        <div class="container">
            <div class="cta text-center py-5">
                <h3 class="text-white">Get a Personalised Quote</h3>
                <p class="px-5 text-white">Every situation is different. If you’re unsure which service is right for you,
                    our team is happy to talk through your options and provide a tailored quote with no obligation.</p>
                <span class="w-50">
                    <hr class="text-secondary">
                </span>
                <a href="{{ route('journey') }}" class="btn btn-light  rounded-0 text-uppercase fw-semibold m-2 px-5">Guided journey</a>
                <a href="{{ route('contact') }}"
                    class="btn btn-light  rounded-0 text-uppercase fw-semibold m-2 px-4">Contact Our Team Today</a>
            </div>

        </div>
    </section>

    @include('cta_common')

@endsection
