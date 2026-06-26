@extends('layouts.app')
@section('title', 'Booking Conformation')
@section('meta_title', '')
@section('meta_description', '')

@section('content')
    <style>
        .booking-timer-card {
            display: flex;
            align-items: center;
            gap: 15px;
            background: linear-gradient(135deg, #fff7e8, #fff);
            border: 2px solid #9EAA6C;
            border-radius: 15px;
            padding: 18px 20px;
            margin-bottom: 25px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
        }

        .timer-icon {
            width: 60px;
            height: 60px;
            min-width: 60px;
            border-radius: 50%;
            background: #9EAA6C;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .timer-content {
            flex: 1;
        }

        .timer-label {
            font-size: 14px;
            color: #777;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .timer-value {
            font-size: 32px;
            font-weight: 700;
            color: #9EAA6C;
            line-height: 1;
        }

        .timer-note {
            font-size: 13px;
            color: #666;
            margin-top: 5px;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.2;
            }

            100% {
                opacity: 1;
            }
        }
    </style>
    <div class="contact_page" class="text-center">
        <div class="container">
            <div class=" text-center my-5">
                <h2 class="mb-3 inner-page-title text-white">Booking Confirmation</h2>
            </div>
        </div>


    </div>
    @php
        if ($booking->total_nights >= 30) {
            $amount = $booking->booking_amount + $property->minimum_diposit;
        } else {
            $amount = $booking->booking_amount;
        }
    @endphp

    <section class="section ">
        <div class="container">
            <form action="{{ route('booking.update', $booking->id) }}" method="POST"
                class="row  rounded-3 shadow-sm search-form-on" id="bookConfirmForm">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="trip-head">
                            Your Trip
                        </h3>
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
                        <h4 class="fw-bold">Date</h4>
                        <h6>{{ \Carbon\Carbon::parse($booking->check_in)->format('F d, Y') }} -
                            {{ \Carbon\Carbon::parse($booking->check_out)->format('F d, Y') }}</h6>

                        <input type="hidden" id="propID" value="{{ $property->id }}">
                        <input type="hidden" id="created_at" value="{{ $booking->created_at->timestamp }}">
                        <input type="hidden" name="payment_id" id="payment_id" value="" readonly>
                        <input type="hidden" name="booking_amount" id="finalAmount" value="{{ $amount }}">

                        <h3 class="trip-head mb-4">Accommodation #1</h3>
                        <h6 class="mb-4">Accommodation Type: <span class="fw-bold">
                                {{ $property->title }}
                            </span>
                        </h6>
                        <div class="form-group  mb-4">
                            <label class="fs-5">Adults <span>*</span></label>
                            <select name="number_of_adult" id="number_of_adult" class="form-control" required>
                                <option value="">Select</option>
                                @for ($i = 1; $i <= $property->max_adult; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group  mb-4">
                            <label class="fs-5">Childrens <span>*</span></label>
                            <select name="number_of_child" id="number_of_child" class="form-control" required>
                                <option value="">Select</option>
                                @for ($i = 0; $i <= $property->max_child; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="form-group  mb-4">
                            <label class="fs-5">Pets <span>*</span></label>
                            <select name="number_of_pet" id="number_of_pet" class="form-control" required>
                                <option value="">Select</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                {{-- @for ($i = 0; $i <= $property->max_pet; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor --}}
                            </select>
                        </div>

                        <h3 class="trip-head mb-4">Your Information</h3>
                        <div class="form-group mb-4">
                            <label class="fs-5">First Name <span>*</span></label>
                            <input id="first_name" type="text" name="first_name" class="form-control " required
                                value="{{ $bookin->first_name ?? old('first_name') }}" placeholder="First name">
                        </div>
                        <div class="form-group mb-4">
                            <label class="fs-5">Last Name <span>*</span></label>
                            <input id="last_name" type="text" name="last_name" class="form-control " required
                                value="{{ $bookin->last_name ?? old('last_name') }}" placeholder="Last name">
                        </div>
                        <div class="form-group mb-4">
                            <label class="fs-5">Email <span>*</span></label>
                            <input id="user_email" type="email" name="user_email" class="form-control " required
                                value="{{ $bookin->user_email ?? old('user_email') }}" placeholder="Enter your email">
                        </div>
                        <div class="form-group mb-4">
                            <label class="fs-5">Phone <span>*</span></label>
                            <input id="user_phone" type="text" name="user_phone" class="form-control  numeric-only"
                                required value="{{ $bookin->user_phone ?? old('user_phone') }}"
                                placeholder="Enter your phone">
                        </div>
                        <div class="form-group d-none mb-4">
                            <label class="fs-5">Address</label>
                            <textarea name="user_address" id="user_address" class="form-control " placeholder="Address" rows="3">{{ $bookin->user_address ?? old('user_address') }}</textarea>
                        </div>
                        {{-- <h3 class="trip-head mb-4">Payment Method</h3>
                        <div class="mb-4">
                            <div class="fs-5">Pay by Card (Stripe)</div>
                        </div>

                        <div class="card p-3 shadow-sm mb-4">
                            <label>Credit or debit card</label>
                            <div id="card-element" class="form-control p-3"></div>
                            <div id="card-errors" class="text-danger mt-2"></div>
                        </div> --}}
                        @if ($booking->status == 'locked')
                            <div class="form-group mb-3">
                                <input type="button" class="btn book-cabin-btn" value="Book Now" id="payBtn">
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
                                            <td class="text-muted text-end" id="adultCount">5</td>
                                        </tr>
                                        <tr class="border-light">
                                            <td class="text-muted">Children</td>
                                            <td class="text-muted text-end" id="childCount">5</td>
                                        </tr>
                                        <tr class="border-light">
                                            <td class="text-muted">Nights</td>
                                            <td class="text-muted text-end">{{ $booking->total_nights }}</td>
                                        </tr>
                                        <tr class="border-light">
                                            <td class="text-muted">Pets</td>
                                            <td class="text-muted text-end" id="petCount">0</td>
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

                                        {{-- @foreach ($booking->dates as $date)
                                            <tr class="border-light">
                                                <td class="text-muted">
                                                    {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
                                                </td>
                                                <td class="text-muted text-end">
                                                    ${{ $booking->price_without_tax / $booking->total_nights }}
                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr class="border-light">
                                            <th>Dates Subtotal</th>
                                            <th class="text-end">${{ $booking->price_without_tax }}</th>
                                        </tr> --}}

                                        <tr class="border-light">
                                            <th>Accommodation Subtotal</th>
                                            <th class="text-end">${{ $booking->price_without_tax }}</th>
                                        </tr>

                                        <tr class="border-light">
                                            <td>Additional Price (<small>Pet diposit Non-refundable</small>)</td>
                                            <td class="text-muted text-end">$<span id="petprice">0</span></td>
                                        </tr>

                                        {{-- <tr class="border-light">
                                            <td class="text-muted">New tax</td>
                                            <td class="text-muted text-end">${{ $booking->tax_amount }}</td>
                                        </tr> --}}
                                        @if ($booking->total_nights >= 30)
                                            <tr class="border-light">
                                                <th class="text-muted">Diposit</th>
                                                <td class="text-muted text-end">${{ $property->minimum_diposit }}</td>
                                            </tr>
                                        @endif

                                        {{-- <tr class="border-light">
                                            <th>Taxes Subtotal</th>
                                            <th class="text-end">${{ $booking->tax_amount }}</th>
                                        </tr> --}}

                                        {{-- <tr class="border-light">
                                            <th>Subtotal</th>
                                            <th class="text-end">${{ $booking->booking_amount }}</th>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>

                            <!-- Summary -->
                            <table class="table mt-1">
                                <tbody>
                                    {{-- <tr class="border-light">
                                        <td class="text-muted">Subtotal (excl. taxes)</td>
                                        <td class="text-muted text-end">${{ $booking->price_without_tax }}</td>
                                    </tr>
                                    <tr class="border-light">
                                        <td class="text-muted">Taxes</td>
                                        <td class="text-muted text-end">${{ $booking->tax_amount }}</td>
                                    </tr> --}}
                                    <tr class="border-light">
                                        <th>Total</th>
                                        <th class="text-end">$ <span id="totalAmount">{{ $amount }}</span>
                                        </th>
                                    </tr>
                                </tbody>
                            </table>
                            {{-- <div class="booking-timer-card">
                                <div class="timer-icon">
                                    <i class="fas fa-clock"></i>
                                </div>

                                <div class="timer-content">
                                    <div class="timer-label">
                                        Reservation Hold Time
                                    </div>

                                    <div id="bookingTimer" class="timer-value">
                                        10:00
                                    </div>

                                    <div class="timer-note">
                                        Complete your booking before the timer expires.
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </form>
            {{-- <form action="{{ route('booking.destroy', $booking->id) }}" method="POST" style="display: inline-block;"
                id="deletForm">
                @csrf
                @method('DELETE')
            </form> --}}
        </div>
    </section>
    <div class="modal fade" id="sessionExpiredModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">

                <div class="modal-body text-center p-5">
                    <div class="mb-3">
                        <i class="fas fa-clock text-danger" style="font-size:50px;"></i>
                    </div>

                    <h4 class="mb-3">Booking Session Expired</h4>

                    <p class="text-muted">
                        Redirecting in <span id="redirectCount">3</span> seconds...
                    </p>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{-- <script src="https://js.stripe.com/v3/"></script> --}}
    <!-- Script -->

    {{-- <script>
        const createdAt = Number(document.getElementById('created_at').value);
        const deleteForm = document.getElementById('deletForm');
        const timerElement = document.getElementById('bookingTimer');

        // Expire 10 minutes after creation
        const expiryTime = createdAt + (10 * 60);

        const timer = setInterval(() => {

            const now = Math.floor(Date.now() / 1000);
            const remaining = expiryTime - now;

            if (remaining <= 300 && remaining > 60) {
                timerElement.style.color = '#ff9800';
            }

            if (remaining <= 60 && remaining > 0) {
                timerElement.style.color = '#dc3545';
                timerElement.style.animation = 'pulse 1s infinite';
            }

            if (remaining <= 0) {
                clearInterval(timer);

                timerElement.innerText = '00:00';
                let count = 3;
                const expiredModal = new bootstrap.Modal(
                    document.getElementById('sessionExpiredModal'), {
                        backdrop: 'static',
                        keyboard: false
                    }
                );

                expiredModal.show();

                const interval = setInterval(() => {
                    count--;
                    document.getElementById('redirectCount').innerText = count;

                    if (count <= 0) {
                        clearInterval(interval);
                        deleteForm.submit();
                    }
                }, 1000);

                return;
            }

            const mins = Math.floor(remaining / 60);
            const secs = remaining % 60;

            timerElement.innerText =
                String(mins).padStart(2, '0') +
                ':' +
                String(secs).padStart(2, '0');

        }, 1000);
    </script> --}}
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

        $(document).on('change', '#number_of_adult', function() {
            const value = $(this).val();
            $('#adultCount').text(value);
        });

        $(document).on('change', '#number_of_child', function() {
            const value = $(this).val();
            $('#childCount').text(value);

        });

        $(document).on('change', '#number_of_pet', function() {
            const perPetPrice = parseFloat('{{ $property->price_per_pet ?? 0 }}');
            const bookingAmount = parseFloat('{{ $amount ?? 0 }}');
            const petCount = parseInt($(this).val()) || 0;

            const petPrice = petCount * perPetPrice;
            const finalAmount = bookingAmount + petPrice;

            $('#petCount').text(petCount);
            $('#petprice').text(petPrice);
            $('#finalAmount').val(finalAmount);
            $('#totalAmount').text(finalAmount);


        });
    </script>
    <script>
        let adultValue = document.getElementById('number_of_adult');
        let childValue = document.getElementById('number_of_child');
        let petValue = document.getElementById('number_of_pet');
        let firstName = document.getElementById('first_name');
        let lastName = document.getElementById('last_name');
        let emailValue = document.getElementById('user_email');
        let phoneValue = document.getElementById('user_phone');
        let addressValue = document.getElementById('user_address');
        let finalBookingAmount = document.getElementById('finalAmount');
        let bookingForm = document.getElementById('bookConfirmForm');
        let payBtn = document.getElementById('payBtn');
        // const stripe = Stripe(
        //     "pk_test_51TES9NQcR5k9cNV7ALf7HLqeRDxHIbLyjHcxpBzKfOrN8YFoEfVDytxUvhinZA5VOhuf5ruJ8jzR2IdBPEE8dGz1008rCzPS4D"
        // );
        // const stripe = Stripe("{{ $stripeKey }}");
        // const elements = stripe.elements();

        // const card = elements.create("card");
        // card.mount("#card-element");


        payBtn.addEventListener("click", async function(e) {

            payBtn.value = 'Processing...';
            payBtn.disabled = true;

            let err = true;

            if (adultValue.value.trim() === '') {
                adultValue.focus();
                err = false;
            } else if (childValue.value.trim() === '') {
                childValue.focus();
                err = false;
            } else if (petValue.value.trim() === '') {
                petValue.focus();
                err = false;
            } else if (firstName.value.trim() === '') {
                firstName.focus();
                err = false;
            } else if (lastName.value.trim() === '') {
                lastName.focus();
                err = false;
            } else if (emailValue.value.trim() === '') {
                emailValue.focus();
                err = false;
            } else if (phoneValue.value.trim() === '') {
                phoneValue.focus();
                err = false;
            }
            // else if (addressValue.value.trim() === '') {
            //     addressValue.focus();
            //     err = false;
            // }

            if (!err) {
                // bookingForm.submit();
                payBtn.value = 'Book Now';
                payBtn.disabled = false;
                return;
            } else {

                bookingForm.submit();
                return;
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
                        name: firstName.value + ' ' + lastName.value,
                        email: emailValue.value,
                        phone: phoneValue.value
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
