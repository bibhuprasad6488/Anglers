@extends('layouts.app')
@section('title', 'Booking Conformation')
@section('meta_title', '')
@section('meta_description', '')

@section('content')
    <div class="contact_page" class="text-center">
        <div class="container">
            <div class=" text-center my-5">
                <h2 class="mb-3 inner-page-title text-white">Booking Payment</h2>
            </div>
        </div>

    </div>
    <section class="section ">
        <div class="container">
            <form action="{{ route('update-payment', $booking->id) }}" method="POST"
                class="row  rounded-3 shadow-sm search-form-on" id="bookConfirmForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">

                        <br>
                        @if (session('success'))
                            <div class="alert alert-success mx-1 mt-3 rounded-3 shadow-sm" id="success-alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger mx-1 mt-3 rounded-3 shadow-sm" id="success-alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <input type="hidden" id="propID" value="{{ $property->id }}">
                        <input type="hidden" id="created_at" value="{{ $booking->created_at->timestamp }}">
                        <input type="hidden" name="payment_id" id="payment_id" value="" readonly>
                        <input type="hidden" name="booking_amount" id="finalAmount" value="{{ $booking->booking_amount }}">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th colspan="2">
                                        <h3 class="trip-head">
                                            Your Trip
                                        </h3>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="250">Adults</th>
                                    <td>{{ $booking->number_of_adult }}</td>
                                </tr>
                                <tr>
                                    <th width="250">Childrens</th>
                                    <td>{{ $booking->number_of_child }}</td>
                                </tr>
                                <tr>
                                    <th width="250">Pets</th>
                                    <td>{{ $booking->number_of_pet }}</td>
                                </tr>
                                <tr>
                                    <th colspan="2">
                                        <h3 class="trip-head mb-4">Your Information</h3>
                                    </th>
                                </tr>
                                <tr>
                                    <th width="250">Your Name</th>
                                    <td>{{ $booking->user_name }}</td>
                                </tr>
                                <tr>
                                    <th width="250">Your Email</th>
                                    <td>{{ $booking->user_email }}</td>
                                </tr>
                                <tr>
                                    <th width="250">Your Phone</th>
                                    <td>{{ $booking->user_phone }}</td>
                                </tr>
                            </tbody>
                        </table>

                        <h3 class="trip-head mb-4">Payment Method</h3>
                        <div class="mb-4">
                            <div class="fs-5">Pay by Card (Stripe)</div>
                        </div>

                        <div class="card p-3 shadow-sm mb-4">
                            <label>Credit or debit card</label>
                            <div id="card-element" class="form-control p-3"></div>
                            <div id="card-errors" class="text-danger mt-2"></div>
                        </div>
                        @if ($booking->status == 'confirmed' && $booking->payment_status == 'pending')
                            <div class="form-group mb-3">
                                <input type="button" class="btn book-cabin-btn" value="Pay Now" id="payBtn">
                            </div>
                        @endif
                    </div>


                    <div class="col-md-6 ">
                        <hr>
                        <div class="mb-4 p-2">
                            <img src="{{ $property->images->first()->img_path }}" class="img-fluid" width="150px">
                        </div>
                        <hr>
                        <h3 class="trip-head mb-4">{{ $property->title }}</h3>
                        <p class="mb-4">{{ $property->sub_title }}</p>

                        <h4 class="fw-bold">Date</h4>
                        <h6>{{ \Carbon\Carbon::parse($booking->check_in)->format('F d, Y') }} -
                            {{ \Carbon\Carbon::parse($booking->check_out)->format('F d, Y') }}</h6>
                        <h3 class="trip-head mb-4">Price Details</h3>
                        <div class="card p-0 shadow-sm border-0">

                            <!-- Main Booking Row -->
                            <table class="table mb-2">
                                <tbody>
                                    <tr class="border-light">
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2"
                                                onclick="showPriceBreakUp(this)">+</button>

                                            # {{ $property->title }}
                                            <h6 class="text-muted mt-2 d-none" id="bkCat">Rate:
                                                {{ $property->category->title }}</h6>
                                        </td>
                                        <td class="text-muted text-end">
                                            ${{ $booking->booking_amount }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Price Breakup -->
                            <div id="priceBreakup" style="display: none;">
                                <table class="table table-sm table-bordered">
                                    <tbody>
                                        <tr class="border-light">
                                            <td class="text-muted">Adults</td>
                                            <td class="text-muted text-end" id="adultCount">
                                                {{ $booking->number_of_adult }}</td>
                                        </tr>
                                        <tr class="border-light">
                                            <td class="text-muted">Children</td>
                                            <td class="text-muted text-end" id="childCount">
                                                {{ $booking->number_of_child }}</td>
                                        </tr>
                                        <tr class="border-light">
                                            <td class="text-muted">Nights</td>
                                            <td class="text-muted text-end">{{ $booking->total_nights }}</td>
                                        </tr>
                                        <tr class="border-light">
                                            <td class="text-muted">Pets</td>
                                            <td class="text-muted text-end">{{ $booking->number_of_pet }}</td>
                                        </tr>

                                        <tr class="border-light">
                                            <th colspan="2">Dates</th>
                                            {{-- <th class="text-end">Amount</th> --}}
                                        </tr>

                                        <tr class="border-light">
                                            <td class="text-muted">
                                                {{ \Carbon\Carbon::parse($booking->check_in)->format('F d, Y') }}</td>
                                            <td class="text-muted text-end">
                                                {{ \Carbon\Carbon::parse($booking->check_out)->format('F d, Y') }}</td>
                                        </tr>

                                        <tr class="border-light">
                                            <th>Accommodation Subtotal</th>
                                            <th class="text-end">${{ $booking->price_without_tax }}</th>
                                        </tr>

                                        <tr class="border-light">
                                            <td>Additional Price (<small>Pet diposit Non-refundable</small>)</td>
                                            <td class="text-muted text-end">$<span id="petprice">0</span></td>
                                        </tr>

                                        @if ($booking->total_nights >= 30)
                                            <tr class="border-light">
                                                <th class="text-muted">Diposit</th>
                                                <td class="text-muted text-end">${{ $property->minimum_diposit }}</td>
                                            </tr>
                                        @endif

                                    </tbody>
                                </table>
                            </div>

                            <!-- Summary -->
                            <table class="table mt-1">
                                <tbody>
                                    <tr class="border-light">
                                        <th>Total</th>
                                        <th class="text-end">$ <span id="totalAmount">{{ $booking->booking_amount }}</span>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <!-- Script -->
    <script>
        localStorage.clear();

        function showPriceBreakUp(btn) {
            let section = document.getElementById('priceBreakup');
            let bCat = document.getElementById('bkCat');

            if (section.style.display === 'none') {
                section.style.display = 'block';
                bCat.classList.remove('d-none');
                btn.innerText = '-';
            } else {
                section.style.display = 'none';
                bCat.classList.add('d-none');
                btn.innerText = '+';
            }
        }
    </script>
    <script>
        let finalBookingAmount = document.getElementById('finalAmount');
        let bookingForm = document.getElementById('bookConfirmForm');
        let payBtn = document.getElementById('payBtn');
        // const stripe = Stripe(
        //     "pk_test_51TES9NQcR5k9cNV7ALf7HLqeRDxHIbLyjHcxpBzKfOrN8YFoEfVDytxUvhinZA5VOhuf5ruJ8jzR2IdBPEE8dGz1008rCzPS4D"
        // );
        const stripe = Stripe("{{ $stripeKey }}");
        const elements = stripe.elements();

        const card = elements.create("card");
        card.mount("#card-element");


        payBtn.addEventListener("click", async function(e) {

            payBtn.value = 'Processing...';
            payBtn.disabled = true;

            let err = true;
            if (!err) {
                // bookingForm.submit();
                payBtn.value = 'Book Now';
                payBtn.disabled = false;
                return;
            } else {

                // Step 1: call stripe controller
                let res = await fetch("{{ route('payment.store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        amount: document.getElementById('finalAmount').value,
                        booking_id: "{{ $booking->id }}",
                        name: "{{ $booking->user_name }}",
                        email: "{{ $booking->user_email }}",
                        phone: "{{ $booking->user_phone }}"
                    })
                });

                let data = await res.json();
                // console.log(data);
                // return false;
                // Step 2: confirm payment
                const result = await stripe.confirmCardPayment(data.client_secret, {
                    payment_method: {
                        card: card
                    }
                });

                // console.log(result);
                // return false;
                if (result.error) {
                    document.getElementById("card-errors").innerText = result.error.message;
                    console.log(result);
                    // Re-enable on failure
                    payBtn.removeAttribute('disabled');
                    payBtn.value = 'Book Now';
                } else {
                    if (result.paymentIntent.status === "succeeded") {
                        $('#payment_id').val(result.paymentIntent.id);
                        // return false;
                        bookingForm.submit();
                        // console.log(result);
                        // window.location.href = "/payment-success";
                    }
                }
            }
        });
    </script>
@endpush
