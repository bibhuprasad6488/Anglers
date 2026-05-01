@extends('layouts.app')
@section('title', 'Search')
@section('meta_title', '')
@section('meta_description', '')

@section('content')
    @php
        $pCats = \App\Models\PropertyCategory::where('status', 1)->orderByDesc('id')->get();
    @endphp
    <div class="contact_page" class="text-center">
        <div class="container">
            <div class=" text-center my-5">
                <h2 class="mb-3 inner-page-title text-white">Search Result</h2>
            </div>
        </div>


    </div>

    <section class="section ">
        <div class="container">
            <div class="row">
                @if ($properties->isNotEmpty())

                    <h5 class="my-5">
                        {{ $properties->count() }} accommodations found from
                        {{ \Carbon\Carbon::parse($formDate)->format('F d, Y') }}
                        till
                        {{ \Carbon\Carbon::parse($toDate)->format('F d, Y') }}
                    </h5>
                    @foreach ($properties as $k => $p)
                        <div class="row g-4 ">
                            <div class="col-md-4">

                                <div class="slider">
                                    <div class="slides">
                                        @foreach ($p->images as $image)
                                            <img src="{{ $image->img_path }}"
                                                class="slide {{ $loop->first ? 'active' : '' }}" alt="Property Image">
                                        @endforeach
                                    </div>

                                    <button class="prev">❮</button>
                                    <button class="next">❯</button>
                                </div>

                            </div>
                            <div class="col-md-8">
                                <a href="{{ route('property.details', $p->slug) }}" class="text-decoration-none">
                                    <div class="card service-card h-100 rounded-0 border-0">
                                        <div
                                            class="card-body d-flex flex-column justify-content-center align-items-start gap-3">
                                            <div>
                                                <h2>{{ $p->title }}</h2>
                                            </div>
                                            <div class="taj">
                                                <p>{{ Str::limit($p->short_desc, 430, '...') }}</p>
                                            </div>
                                            <div class="text-muted">
                                                <h5>
                                                    <b>Price start at:</b>
                                                    <span class="mphb-price">
                                                        <span
                                                            class="mphb-currency">$</span>{{ $p->pricing['total_price'] }}</span>
                                                    <span class="mphb-price-period"
                                                        title="Based on your search parameters">per
                                                        night</span>
                                                </h5>

                                            </div>
                                            <div>
                                                <form action="{{ route('search.result') }}" method="GET">
                                                    @csrf
                                                    <input id="check_in_date" type="hidden" name="check_in_date"
                                                        class="form-control border-secondary"
                                                        value="{{ request('check_in_date') ?? request('check_in') }}">
                                                    <input id="check_out_date" type="hidden" name="check_out_date"
                                                        class="form-control border-secondary"
                                                        value="{{ request('check_out_date') ?? request('check_out') }}">
                                                    <input type="hidden" name="property_id" value="{{ $p->id }}">
                                                    <input type="hidden" name="category_id" value="{{ $p->category_id }}">

                                                    <a href="{{ route('property.details', $p->slug) }}" target="_blank"
                                                        class="mx-3 py-2 btn-outline">View Details</a>

                                                    @if ($p->pricing['total_price'])
                                                        <button type="submit" class="btn book-cabin-btn">Book
                                                        </button>
                                                    @endif
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    @endforeach
                @else
                    <h5 class="my-5">
                        No accommodations found from
                        {{ \Carbon\Carbon::parse($formDate)->format('F d, Y') }}
                        till
                        {{ \Carbon\Carbon::parse($toDate)->format('F d, Y') }}
                    </h5>
                @endif
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        let checkInDate = document.getElementById('check_in_date').value;
        let checkOutDate = document.getElementById('check_out_date').value;

        document.addEventListener("DOMContentLoaded", function() {
            localStorage.setItem('check_in_date',checkInDate);
            localStorage.setItem('check_out_date',checkOutDate);
            // localStorage.clear();
            // console.log(checkInDate + ', ' + checkOutDate);

            document.querySelectorAll(".slider").forEach(function(slider) {

                let currentSlide = 0;
                const slides = slider.querySelectorAll(".slide");

                function showSlide(index) {
                    if (index >= slides.length) {
                        currentSlide = 0;
                    } else if (index < 0) {
                        currentSlide = slides.length - 1;
                    } else {
                        currentSlide = index;
                    }

                    slides.forEach(slide => slide.classList.remove("active"));
                    slides[currentSlide].classList.add("active");
                }

                slider.querySelector(".next").addEventListener("click", function() {
                    showSlide(currentSlide + 1);
                });

                slider.querySelector(".prev").addEventListener("click", function() {
                    showSlide(currentSlide - 1);
                });

                setInterval(function() {
                    showSlide(currentSlide + 1);
                }, 3000);

            });

        });
    </script>
    <script>
        let url = "{{ route('category.property', ':id') }}";

        // function getProperties() {
        //     const catId = document.getElementById('category_id').value;
        //     const pId = document.getElementById('pHtml');
        //     const propId = document.getElementById('propID').value;
        //     if (catId != '') {
        //         let finalUrl = url.replace(':id', catId);
        //         $.get(finalUrl + '?prop_id=' + propId, function(res) {
        //             console.log(res);
        //             if (res.status) {
        //                 pId.innerHTML = res.html; // ✅ correct for JS
        //             }
        //         });
        //     }
        //     // alert('ok' + catId + ',' + finalUrl);
        // }


        // document.addEventListener("DOMContentLoaded", function() {
        //     getProperties();
        // });
    </script>
@endpush
