@extends('layouts.app')
@section('title', 'Properties')
@section('meta_title', '')
@section('meta_description', '')

@section('content')

    <div class="contact_page" class="text-center">
        <div class="mask">
            <div class="text-white">
                <h2 class="mb-3 inner-page-title text-white">Search Result</h2>
            </div>
        </div>
        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>

    <section class="section ">
        <div class="container">
            @if (!empty($properties))
                @foreach ($properties as $k => $p)
                    <div class="row g-4 py-5">
                        <div class="col-md-8">
                            <div class="card service-card h-100 rounded-0 border-0">
                                <div class="card-body d-flex flex-column justify-content-center align-items-start gap-3">
                                    <div>
                                        <a href="{{ route('property.details', $p->slug) }}" class="text-decoration-none">
                                            <h2>{{ $p->title }}</h2>
                                        </a>
                                    </div>
                                    <div class="text-muted">
                                        <p>{{ Str::limit($p->short_desc, 350, '...') }}</p>
                                    </div>
                                    <div class="text-muted">
                                    </div>
                                    <div>
                                        @if ($p->pricing)
                                            <span class="fw-bold text-muted p-2 " style="width: max-content;">Total Days:
                                                {{ $p->pricing['total_days'] }},
                                                Price $ {{ $p->pricing['final_price'] }}</span>

                                            <a href="{{ route('property.details', $p->slug) }}#booking-form-{{ $p->id }}"
                                                class="btn book-cabin-btn">Book
                                                Now</a>
                                        @else
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">

                            <div class="slider">
                                <div class="slides">
                                    @foreach ($p->images as $image)
                                        <img src="{{ $image->img_path }}" class="slide {{ $loop->first ? 'active' : '' }}"
                                            alt="Property Image">
                                    @endforeach
                                </div>

                                <button class="prev">❮</button>
                                <button class="next">❯</button>
                            </div>

                        </div>
                    </div>
                @endforeach
            @else
                <h5 class="mb-5">
                    No accommodations found from
                    {{ \Carbon\Carbon::parse($formDate)->format('F d, Y') }}
                    till
                    {{ \Carbon\Carbon::parse($toDate)->format('F d, Y') }}
                </h5>
            @endif
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

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
@endpush
