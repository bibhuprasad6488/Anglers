<section class="cta py-5 cm10">
    <div class="container">
        <div class="row justify-content-center text-center">
            @php
                $siteSetting = \App\Models\SiteSetting::find(1);
            @endphp
            <div class="col-lg-10">
                <h2 class="cta-title mb-3">
                    {{ $siteSetting->cta_title ?? 'Get Started with a Will Today' }}
                </h2>

                <p class="cta-subtitle mb-4">
                    <i>{{ $siteSetting->cta_sub_title ?? 'Clear advice, fixed fees, and complete peace of mind. Contact us today.' }}</i>
                </p>
            </div>

        </div>

        <div class="row justify-content-center mt-3 g-3">

            <div class="col-md-5 col-lg-4">
                <a href="{{ route('start.will') }}" class="btn btn-light w-100 py-3 rounded-0 text-uppercase fw-semibold">
                    Fill Out Our Form
                </a>
            </div>


            <div class="col-md-5 col-lg-4">
                <a href="tel:{{ $siteSetting->contact_phone ?? '' }}"
                    class="btn btn-light w-100 py-3 rounded-0 text-uppercase fw-semibold">
                    Call
                    @if ($siteSetting && $siteSetting->contact_phone)
                        {{ $siteSetting->contact_phone }}
                    @endif
                </a>
            </div>

        </div>
    </div>
</section>
