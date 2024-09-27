<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>
    <base href="">
    <title>{{ env('APP_NAME') }} | @yield('title')</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset('assets/images/branding/logo.jpg') }}" />
    @include('admin.layouts.css')
    @yield('style')
</head>

<body>
    <div id="layout-wrapper">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header text-center">
                                <h1>Kaiven Solar Quotation</h4>
                            </div>
                            <div class="card-body checkout-tab">
                                <form method="POST" data-parsley-validate="" id="addEditForm" role="form">
                                    @csrf
                                    <div class="step-arrow-nav mt-n3 mx-n3 mb-3">

                                        <ul class="nav nav-pills nav-justified custom-nav" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link fs-15 p-3 active" id="quotation-info-tab"
                                                    data-bs-toggle="pill" data-bs-target="#quotation-info"
                                                    type="button" role="tab" aria-controls="quotation-info"
                                                    aria-selected="true" data-position="0">
                                                    <i
                                                        class="ri-user-2-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
                                                    Personal Info
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link fs-15 p-3" id="personal-info-tab"
                                                    data-bs-toggle="pill" data-bs-target="#personal-info" type="button"
                                                    role="tab" aria-controls="personal-info" aria-selected="false"
                                                    data-position="1" tabindex="-1">
                                                    <i
                                                        class="ri-truck-line fs-16 p-2 bg-primary-subtle text-primary rounded-circle align-middle me-2"></i>
                                                    Shipping Info
                                                </button>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="quotation-info" role="tabpanel"
                                            aria-labelledby="quotation-info-tab">
                                            <div>
                                                <h5 class="mb-1">Quotation Information</h5>
                                                <p class="text-muted mb-4">Please fill all information below</p>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-lg-12">
                                                    <div class="form-floating">
                                                        <select class="form-select" id="address_type"
                                                            name="address_type"
                                                            aria-label="Floating label select example">
                                                            <option value="">Choose...</option>
                                                            @foreach ($addressType as $address)
                                                                <option value="{{ $address->id }}">{{ $address->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <label for="floatingSelect">Address Type</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control"
                                                            id="cityfloatingInput" name="city"
                                                            placeholder="Enter your city">
                                                        <label for="cityfloatingInput">City</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control float"
                                                            id="billing_year" name="billing_year"
                                                            placeholder="Enter your Higest Billing Year">
                                                        <label for="billing_year">Enter Your Higest Billing Per
                                                            Year</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-start gap-3 mt-3">
                                                    <button type="button" class="btn btn-primary right ms-auto nexttab"
                                                        data-nexttab="personal-info-tab">
                                                        Generate My instant Quotation
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="personal-info" role="tabpanel"
                                            aria-labelledby="personal-info-tab">
                                            <div>
                                                <h5 class="mb-1">Personal Information</h5>
                                                <p class="text-muted mb-4">Please fill all information below</p>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-lg-6">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" placeholder="Enter your name">
                                                        <label for="name">Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="mobile_no"
                                                            name="mobile_no" placeholder="Enter your Mobile No">
                                                        <label for="mobile_no">Mobile No</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 aligh-items-center">
                                                    <button type="button" class="btn btn-success" id="send_otp">
                                                        Send OTP
                                                    </button>
                                                </div>
                                                <div class="col-lg-12 otp_div d-none">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control integer"
                                                            id="otp" name="otp"
                                                            placeholder="Enter your OTP">
                                                        <label for="floatingSelect">OTP</label>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <hr>
                                                    @foreach ($panelBrands as $panelBrand)
                                                        <div class="card product">
                                                            <div class="card-body">
                                                                <div class="row gy-3">
                                                                    <div class="col-sm">
                                                                        <h5 class="fs-14 text-truncate">
                                                                            <div class="form-check mb-3">
                                                                                <input
                                                                                    class="form-check-input panel-checkbox"
                                                                                    type="checkbox"
                                                                                    name="panel_brands[]"
                                                                                    id="panel_brand_{{ $panelBrand->id }}"
                                                                                    value="{{ $panelBrand->id }}"
                                                                                    data-panel-id="{{ $panelBrand->id }}">
                                                                                <label class="form-check-label"
                                                                                    for="panel_brand_{{ $panelBrand->id }}">
                                                                                    {{ $panelBrand->name }}
                                                                                </label>
                                                                            </div>
                                                                        </h5>
                                                                        <ul class="list-inline text-muted">
                                                                            <li class="list-inline-item">Price: <span
                                                                                    class="fw-medium">${{ $panelBrand->price }}</span>
                                                                            </li>
                                                                        </ul>
                                                                        <ul class="list-inline text-muted">
                                                                            <div class="mt-4 mt-lg-0">
                                                                                @foreach ($qualityPreferences as $qualityPreference)
                                                                                    @if ($qualityPreference->panel_brand_id === $panelBrand->id)
                                                                                        <li class="list-inline-item">
                                                                                            <div
                                                                                                class="form-check form-check-inline">
                                                                                                <input
                                                                                                    class="form-check-input"
                                                                                                    type="radio"
                                                                                                    value="{{ $qualityPreference->id }}"
                                                                                                    name="quality_preference[{{ $panelBrand->id }}]"
                                                                                                    id="quality_preference_{{ $qualityPreference->id }}"
                                                                                                    disabled>
                                                                                                <label
                                                                                                    class="form-check-label"
                                                                                                    for="quality_preference_{{ $qualityPreference->id }}">{{ $qualityPreference->name }}</label>
                                                                                            </div>
                                                                                        </li>
                                                                                    @endif
                                                                                @endforeach
                                                                            </div>
                                                                        </ul>
                                                                        <div class="input-step">
                                                                            <button type="button"
                                                                                class="minus material-shadow">–</button>
                                                                            <input type="number"
                                                                                class="product-quantity"
                                                                                value="1" min="0"
                                                                                max="100" name="quantity[] "
                                                                                data-panel-id="{{ $panelBrand->id }}"
                                                                                data-unit-price="{{ $panelBrand->price }}"
                                                                                disabled>
                                                                            <button type="button"
                                                                                class="plus material-shadow">+</button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-sm-auto">
                                                                        <div class="text-lg-end">
                                                                            <h5 class="fs-14">$<span
                                                                                    id="ticket_price_{{ $panelBrand->id }}"
                                                                                    class="product-price"
                                                                                    data-panel-id="{{ $panelBrand->id }}">0.00</span>
                                                                            </h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                    @endforeach
                                                    <div class="col-sm-auto">
                                                        <div class="text-lg-end">
                                                            <h5 class="fs-14">$<span id="total_price">0.00</span>
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-start gap-3 mt-4">
                                                    <button type="button" class="btn btn-light btn-label previestab"
                                                        data-previous="quotation-info-tab"><i
                                                            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back
                                                        to Quotation Info</button>
                                                    <button type="submit"
                                                        class="btn btn-primary right ms-auto"
                                                        data-nexttab="pills-payment-tab">Generate</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- JAVASCRIPT -->
    @include('admin.layouts.script')
    <script src="{{ asset('assets/js/pages/ecommerce-product-checkout.init.js') }}"></script>

    <script>
        APP_URL = {!! json_encode(url('/')) !!};
        let form_url = '/store-quotation';
        let redirect_url = '/thank-you-page';
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function updatePrice(quantityInput, priceDisplay, unitPrice) {
                var quantity = parseInt(quantityInput.value);
                var totalPrice = (quantity * unitPrice).toFixed(2);
                priceDisplay.textContent = totalPrice;
                updateTotalPrice();
            }

            function updateTotalPrice() {
                var total = 0;
                document.querySelectorAll('.product-price').forEach(function(priceElement) {
                    total += parseFloat(priceElement.textContent);
                });
                document.getElementById('total_price').textContent = total.toFixed(2);
            }

            document.querySelectorAll('.panel-checkbox').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    var panelId = this.getAttribute('data-panel-id');
                    var radioButtons = document.querySelectorAll('input[name="quality_preference[' +
                        panelId + ']"]');
                    var quantityInput = document.querySelector(
                        'input.product-quantity[data-panel-id="' + panelId + '"]');
                    var priceDisplay = document.querySelector('.product-price[data-panel-id="' +
                        panelId + '"]');
                    var unitPrice = parseFloat(quantityInput.getAttribute('data-unit-price'));

                    radioButtons.forEach(function(radio) {
                        radio.disabled = !checkbox.checked;
                    });

                    quantityInput.disabled = !checkbox.checked;

                    if (!checkbox.checked) {
                        quantityInput.value = 1;
                        priceDisplay.textContent = '0.00';
                    } else {
                        updatePrice(quantityInput, priceDisplay, unitPrice);
                    }

                    updateTotalPrice();
                });
            });

            document.querySelectorAll('.input-step').forEach(function(stepper) {
                var input = stepper.querySelector('.product-quantity');
                var panelId = input.getAttribute('data-panel-id');
                var priceDisplay = document.querySelector('.product-price[data-panel-id="' + panelId +
                    '"]');
                var unitPrice = parseFloat(input.getAttribute('data-unit-price'));

                stepper.querySelector('.plus').addEventListener('click', function() {
                    if (!input.disabled && Number(input.value) < Number(input.max)) {
                        input.value = parseInt(input.value) + 1;
                        updatePrice(input, priceDisplay, unitPrice);
                    }
                });

                stepper.querySelector('.minus').addEventListener('click', function() {
                    if (!input.disabled && Number(input.value) > Number(input.min)) {
                        input.value = parseInt(input.value) - 1;
                        updatePrice(input, priceDisplay, unitPrice);
                    }
                });

                input.addEventListener('change', function() {
                    if (!input.disabled) {
                        updatePrice(input, priceDisplay, unitPrice);
                    }
                });
            });
        });
    </script>
    <script src="{{ asset('assets/custom-js/custom/form.js') }}?v={{ time() }}"></script>
    <script>
        document.getElementById('send_otp').addEventListener('click', function() {
            const mobile_no = document.getElementById('mobile_no').value;
            if (!mobile_no || mobile_no.length !== 10) {
                notificationToast('Please enter a valid 10-digit mobile number.', 'warning');
                return;
            }
            loaderView()
            axios.post(APP_URL + '/send-otp', {
                    mobile_no: mobile_no
                })
                .then(function(response) {
                    loaderHide()
                    document.querySelector('.otp_div').classList.remove('d-none');
                    notificationToast('OTP has been sent successfully!', 'success');
                })
                .catch(function(error) {
                    loaderHide()
                    console.error('Error sending OTP:', error);
                    notificationToast('Failed to send OTP. Please try again.', 'warning');
                });

        });
    </script>
</body>

</html>
