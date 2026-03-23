@extends('layouts.app')
@section('title', 'Booking Conformation')
@section('meta_title', '')
@section('meta_description', '')

@section('content')
    <div class="contact_page" class="text-center">
        <div class="container">
            <div class=" text-center my-5">
                <h2 class="mb-3 inner-page-title text-white">Booking Confirmation</h2>
            </div>
        </div>
        <!-- MOB HEADER -->
        @include('layouts.mob_header')

    </div>

    <section class="section ">
        <div class="container">
            <form action="{{ route('booking.update', $booking->id) }}" method="POST"
                class="row  rounded-3 shadow-sm search-form-on">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="trip-head">
                            Your Trip
                        </h3>
                        <br>
                        <h4 class="fw-bold">Date</h4>
                        <h6>{{ \Carbon\Carbon::parse($booking->check_in)->format('F d, Y') }} -
                            {{ \Carbon\Carbon::parse($booking->check_out)->format('F d, Y') }}</h6>
                        <input type="hidden" id="propID" value="{{ $property->id }}">
                        <h3 class="trip-head mb-4">Accommodation #1</h3>
                        <h6 class="mb-4">Accommodation Type: <span class="fw-bold">
                                {{ $property->title }}
                            </span>
                        </h6>
                        <div class="form-group  mb-4">
                            <label class="fs-5">Adults <span>*</span></label>
                            <select name="number_of_adult" id="number_of_adult" class="form-control" required>
                                <option value="">Select</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>

                        <div class="form-group  mb-4">
                            <label class="fs-5">Childrens <span>*</span></label>
                            <select name="number_of_child" id="number_of_child" class="form-control" required>
                                <option value="">Select</option>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>

                        <h3 class="trip-head mb-4">Your Information</h3>
                        @if (session('success'))
                            <div class="alert alert-success mx-1 mt-3 rounded-3 shadow-sm" id="success-alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger mx-1 mt-3 rounded-3 shadow-sm" id="success-alert">
                                {{ session('message') }}
                            </div>
                        @endif
                        <div class="form-group mb-4">
                            <label class="fs-5">First Name <span>*</span></label>
                            <input id="first_name" type="text" name="first_name" class="form-control " required
                                value="" placeholder="First name">
                        </div>
                        <div class="form-group mb-4">
                            <label class="fs-5">Last Name <span>*</span></label>
                            <input id="last_name" type="text" name="last_name" class="form-control " required
                                value="" placeholder="Last name">
                        </div>
                        <div class="form-group mb-4">
                            <label class="fs-5">Email <span>*</span></label>
                            <input id="user_email" type="email" name="user_email" class="form-control " required
                                value="{{ $bookin->uuser_emaile ?? old('user_email') }}" placeholder="Enter your email">
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
                        <h3 class="trip-head mb-4">Payment Method</h3>
                        <div class="mb-4">
                            <div class="fs-5">Pay by Card (Stripe)</div>
                            <small>Pay with your credit card Via Stripe</small>
                        </div>
                        <div class="card p-2 shadow-sm mb-4">

                            <div class="form-group mb-4">
                                <label class="fs-5">Credit od debit card</label>
                                <input id="card_number" type="text" name="card_number" class="form-control" 
                                    value="{{ $bookin->card_number ?? old('card_number') }}"
                                    placeholder="0000 0000 0000 0000" inputmode="numeric" pattern="[0-9\s]*">
                                <img id="card_icon" src="" width="40"
                                    style="position:absolute; right:14px; top:52%; transform:translateY(-50%); display:none;"
                                    src="{{ asset('assets/images/cards/default.png') }}">
                            </div>

                        </div>
                        @if ($booking->status == 'locked')
                            <div class="form-group mb-3">
                                <input type="submit" class="btn book-cabin-btn" value="Book Now">
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
                                            <th>Dates</th>
                                            <th class="text-end">Amount</th>
                                        </tr>

                                        @foreach ($booking->dates as $date)
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
                                        </tr>

                                        <tr class="border-light">
                                            <th>Accommodation Subtotal</th>
                                            <th class="text-end">${{ $booking->price_without_tax }}</th>
                                        </tr>

                                        <tr class="border-light">
                                            <th colspan="2">Accommodation Taxes</th>
                                        </tr>

                                        <tr class="border-light">
                                            <td class="text-muted">New tax</td>
                                            <td class="text-muted text-end">${{ $booking->tax_amount }}</td>
                                        </tr>

                                        <tr class="border-light">
                                            <th>Taxes Subtotal</th>
                                            <th class="text-end">${{ $booking->tax_amount }}</th>
                                        </tr>

                                        <tr class="border-light">
                                            <th>Subtotal</th>
                                            <th class="text-end">${{ $booking->booking_amount }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Summary -->
                            <table class="table mt-1">
                                <tbody>
                                    <tr class="border-light">
                                        <td class="text-muted">Subtotal (excl. taxes)</td>
                                        <td class="text-muted text-end">${{ $booking->price_without_tax }}</td>
                                    </tr>
                                    <tr class="border-light">
                                        <td class="text-muted">Taxes</td>
                                        <td class="text-muted text-end">${{ $booking->tax_amount }}</td>
                                    </tr>
                                    <tr class="border-light">
                                        <th>Total</th>
                                        <th class="text-end">${{ $booking->booking_amount }}</th>
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
    <!-- Script -->
    <script>
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
    </script>

    <script>
        // const cvvInput = document.getElementById('cvv');
        // if (cvvInput) {
        //     cvvInput.addEventListener('input', function(e) {
        //         let value = e.target.value.replace(/\D/g, ''); // Remove non-digits

        //         // Limit to 4 digits (or change to 3 if your use case only supports that)
        //         if (value.length > 4) {
        //             value = value.slice(0, 4);
        //         }

        //         e.target.value = value;
        //     });

        //     cvvInput.addEventListener('blur', function(e) {
        //         const digitsOnly = e.target.value;
        //         if (digitsOnly.length < 3 || digitsOnly.length > 4) {
        //             alert('CVV must be 3 or 4 digits.');
        //             cvvInput.value = '';
        //         }
        //     });
        // }
    </script>
    <script>
        let cardInput = document.getElementById('card_number');
        let cardIcon = document.getElementById('card_icon');

        if (cardInput) {

            cardInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');

                // Detect type FIRST
                let type = detectCardType(value);

                // Dynamic length
                let maxLength = 16;
                if (type === 'amex') maxLength = 15;
                if (type === 'diners') maxLength = 14;

                value = value.substring(0, maxLength);

                // Format safely
                e.target.value = formatCardNumber(value, type);

                // Update icon
                updateCardIcon(type, value);
            });

            function detectCardType(number) {
                if (/^4/.test(number)) return 'visa';
                if (/^5[1-5]/.test(number)) return 'mastercard';
                if (/^3[47]/.test(number)) return 'amex';
                if (/^6(?:011|5)/.test(number)) return 'discover';
                if (/^3(?:0[0-5]|[68])/.test(number)) return 'diners';
                return '';
            }

            function formatCardNumber(value, type) {
                if (type === 'amex') {
                    return value.replace(/^(\d{0,4})(\d{0,6})(\d{0,5})$/, (_, a, b, c) => [a, b, c].filter(Boolean).join(
                        ' '));
                }

                if (type === 'diners') {
                    return value.replace(/^(\d{0,4})(\d{0,6})(\d{0,4})$/, (_, a, b, c) => [a, b, c].filter(Boolean).join(
                        ' '));
                }

                // default (Visa, MasterCard, Discover)
                return value.replace(/(\d{1,4})/g, '$1 ').trim();
            }

            function updateCardIcon(type, value) {
                if (!value) {
                    cardIcon.style.display = 'none';
                    return;
                }

                let icon = type ? type : 'default';

                cardIcon.src = `/assets/images/cards/${icon}.png`;
                cardIcon.style.display = 'block';
            }

            // fallback if image missing
            cardIcon.onerror = function() {
                this.src = '/assets/images/cards/default.png';
            };
        }
    </script>
@endpush
