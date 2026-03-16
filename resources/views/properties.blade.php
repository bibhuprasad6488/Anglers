@extends('layouts.app')
@section('title', 'Properties')
@section('meta_title', '')
@section('meta_description', '')

@section('content')
    <style>
        .swiper-slide img {
            /* width: 800px !important; */
            object-fit: cover !important;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #fff !important;
            font-weight: 600;
        }
    </style>
    <div class="contact_page" class="text-center">
        <!-- Overlay (optional dark mask) -->
        <div class="mask">

            <form action="{{ route('search.result') }}" method="GET"
                class="form-inline d-flex justify-content-center align-items-center gap-4 flex-wrap p-5 rounded-3 shadow-sm search-form-one">
                @csrf
                <div class="form-group">
                    <h4>
                        ▷ Browse Our <br><span> Cabin Selection </span> <span title="required">*</span>
                    </h4>
                </div>
                <div class="form-group">
                    <label class="text-white">Check In</label>
                    <input id="check_in_date" value="" placeholder="Check-in Date" required="required" type="date"
                        name="check_in_date" class="form-control" autocomplete="off">
                        <input type="hidden" name="category" value="{{ $cat->slug }}">
                </div>
                <div class="form-group">
                    <label class="text-white">Check Out</label>
                    <input id="check_out_date" value="" placeholder="Check-out Date" required="required"
                        type="date" name="check_out_date" class="form-control" autocomplete="off">
                </div>

                <div class="form-group">
                    <input type="submit" class="btn book-cabin-btn" value="Search">
                </div>
            </form>
        </div>

        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>

    <section class="section ">
        <div class="container py-5">
            {{-- <h2 class="text-center mb-5 maastrix">Our Services</h2> --}}
            @foreach ($properties as $k => $p)
                <div class="row g-4 py-5">
                    <div class="col-md-8">
                        <a href="{{ route('property.details', $p->slug) }}" class="text-decoration-none">
                            <div class="card service-card h-100 rounded-0 border-0">
                                <div class="card-body d-flex flex-column justify-content-center align-items-start gap-3">
                                    <div>
                                        <h2>{{ $p->title }}</h2>
                                    </div>
                                    <div class="text-muted">
                                        <p>{{ Str::limit($p->short_desc, 350, '...') }}</p>
                                    </div>
                                    <div><a href="{{ route('property.details', $p->slug) }}#booking-form-{{ $p->id }}"
                                            class="btn book-cabin-btn">Check
                                            Availability</a></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">

                        <div class="swiper gallerySwiper">
                            <div class="swiper-wrapper">

                                @foreach ($p->images as $img)
                                    <div class="swiper-slide">
                                        <img src="{{ $img->img_path }}" class="img-fluid w-100">
                                    </div>
                                @endforeach

                            </div>

                            <!-- Navigation -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>

                            <!-- Pagination -->
                            {{-- <div class="swiper-pagination"></div> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        var swiper = new Swiper(".gallerySwiper", {
            loop: true,
            spaceBetween: 20,
            slidesPerView: 1,
            centeredSlides: true,

            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },

            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },

            breakpoints: {
                320: {
                    slidesPerView: 1
                },
                768: {
                    slidesPerView: 1
                },
                1024: {
                    slidesPerView: 1
                }
            }
        });
    </script>
@endpush
