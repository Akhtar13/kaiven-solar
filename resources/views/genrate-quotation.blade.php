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
                                                    Quotation Info
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
                                                    <div class="mb-3">
                                                        <label class="form-label" for="gen-info-email-input">Address
                                                            Type</label>
                                                        <select class="form-select" id="address_type"
                                                            name="address_type"
                                                            aria-label="Floating label select example">
                                                            <option value="">Choose...</option>
                                                            @foreach ($addressType as $address)
                                                                <option value="{{ $address->id }}">{{ $address->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="city">City</label>
                                                        <select class="form-select" id="city" name="city">
                                                            <option value="">Choose...</option>
                                                            <option value="Bharuch">Bharuch</option>
                                                            <option value="Surat">Surat</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="billing_year">Enter Your Highest
                                                            Billing Per Year</label>
                                                        <input type="text" class="form-control float"
                                                            id="billing_year" name="billing_year"
                                                            placeholder="Enter your Highest Billing Year"
                                                            onchange="calculateExpectedAmount()">
                                                    </div>
                                                </div>

                                                @foreach ($kwts as $index => $kwt)
                                                    <div class="col-lg-12 mb-3 d-none result"
                                                        data-index="{{ $index }}" data-min="{{ $kwt->from_kwt }}"
                                                        data-max="{{ $kwt->to_kwt }}">
                                                        <label for="expected_amount" class="form-label required">
                                                            Your Minimum Requirement is {{ $kwt->suggestion_one }} or
                                                            {{ $kwt->suggestion_two }} kW.
                                                            Your Price will be between:
                                                        </label>
                                                        <div class="form-outline row g-2">
                                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                                <div class="form-check card-radio">
                                                                    <input id="expected_amount_{{ $kwt->id }}_1"
                                                                        name="expected_amount" type="radio"
                                                                        value="{{ 48500 * $kwt->suggestion_one }}" class="form-check-input">
                                                                    <label class="form-check-label"
                                                                        for="expected_amount_{{ $kwt->id }}_1">
                                                                        <span class="fw-normal text-wrap mb-1 d-block">
                                                                            48500 * {{ $kwt->suggestion_one }} =
                                                                            {{ 48500 * $kwt->suggestion_one }}
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-sm-6 mb-3">
                                                                <div class="form-check card-radio">
                                                                    <input id="expected_amount_{{ $kwt->id }}_2"
                                                                        name="expected_amount" type="radio"
                                                                        value="{{ 49500 * $kwt->suggestion_two }}" class="form-check-input">
                                                                    <label class="form-check-label"
                                                                        for="expected_amount_{{ $kwt->id }}_2">
                                                                        <span class="fw-normal text-wrap mb-1 d-block">
                                                                            49500 * {{ $kwt->suggestion_two }} =
                                                                            {{ 49500 * $kwt->suggestion_two }}
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-start gap-3 mt-3">
                                                    <button type="button"
                                                        class="btn btn-success right ms-auto nexttab"
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
                                                    <div class="mb-3">
                                                        <label class="form-label" for="name">Name</label>
                                                        <input type="text" class="form-control" id="name"
                                                            name="name" placeholder="Enter your name">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="mobile_no">Mobile No</label>
                                                        <input type="text" class="form-control" id="mobile_no"
                                                            name="mobile_no" placeholder="Enter your Mobile No">
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 mt-5 aligh-items-center">
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
                                                    <label for="panel_brand_select">Select Panel Brand</label>
                                                    <select id="panel_brand_select" class="form-select"
                                                        name="panel_brand_id" onchange="showQualityOptions(this)">
                                                        <option value="">-- Select Panel Brand --</option>
                                                        @foreach ($panelBrands as $panelBrand)
                                                            <option value="{{ $panelBrand->id }}">
                                                                {{ $panelBrand->name }}</option>
                                                        @endforeach
                                                    </select>

                                                    <div id="quality_options" class="mt-4">
                                                        @foreach ($panelBrands as $panelBrand)
                                                            <div class="quality-group d-none"
                                                                data-panel-id="{{ $panelBrand->id }}">
                                                                <h6>Quality Preferences for {{ $panelBrand->name }}
                                                                </h6>
                                                                <ul class="list-inline">
                                                                    @foreach ($qualityPreferences as $qualityPreference)
                                                                        @if ($qualityPreference->panel_brand_id === $panelBrand->id)
                                                                            <li class="list-inline-item">
                                                                                <div
                                                                                    class="form-check form-check-inline">
                                                                                    <input class="form-check-input"
                                                                                        type="radio"
                                                                                        name="quality_preference_id"
                                                                                        value="{{ $qualityPreference->id }}"
                                                                                        id="quality_preference_{{ $qualityPreference->id }}">
                                                                                    <label class="form-check-label"
                                                                                        for="quality_preference_{{ $qualityPreference->id }}">
                                                                                        {{ $qualityPreference->name }}
                                                                                    </label>
                                                                                </div>
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-start gap-3 mt-4">
                                                    <button type="button" class="btn btn-light btn-label previestab"
                                                        data-previous="quotation-info-tab"><i
                                                            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back
                                                        to Quotation Info</button>
                                                    <button type="submit" class="btn btn-success right ms-auto"
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
        function calculateExpectedAmount() {
            const billingYear = parseFloat(document.getElementById('billing_year').value);
            if (isNaN(billingYear)) return; // Stop if input is invalid

            const X = billingYear / 800;
            console.log('Calculated X:', X);

            // Get all result divs
            const resultDivs = document.querySelectorAll('.result');

            // Hide all result divs initially
            resultDivs.forEach(div => {
                div.classList.add('d-none'); // Hide all divs
                div.querySelectorAll('input[type="radio"]').forEach(checkbox => {
                    checkbox.checked = false; // Uncheck all checkboxes
                });
            });

            let lowestDiv = null;
            let highestDiv = null;
            let matchingDiv = null;

            resultDivs.forEach(div => {
                const min = parseFloat(div.getAttribute('data-min'));
                const max = parseFloat(div.getAttribute('data-max'));

                if (!lowestDiv || min < parseFloat(lowestDiv.getAttribute('data-min'))) {
                    lowestDiv = div;
                }
                if (!highestDiv || max > parseFloat(highestDiv.getAttribute('data-max'))) {
                    highestDiv = div;
                }

                if (X >= min && X < max) {
                    matchingDiv = div;
                }
            });

            // Logic to show the correct div
            if (matchingDiv) {
                matchingDiv.classList.remove('d-none'); // Show the matching div if found
            } else if (X < parseFloat(lowestDiv.getAttribute('data-min'))) {
                lowestDiv.classList.remove('d-none'); // Show the lowest div if X is smaller than all ranges
            } else if (X >= parseFloat(highestDiv.getAttribute('data-max'))) {
                highestDiv.classList.remove('d-none'); // Show the highest div if X is larger than all ranges
            }
        }

        function showQualityOptions(select) {
            const selectedPanelId = select.value;

            document.querySelectorAll('.quality-group').forEach(group => {
                group.classList.add('d-none'); // Hide all groups
                group.querySelectorAll('input[type="radio"]').forEach(radio => {
                    radio.checked = false; // Uncheck all radio buttons
                });
            });

            document.querySelectorAll('.quality-group').forEach(group => group.classList.add('d-none'));
            if (selectedPanelId) {
                const matchingGroup = document.querySelector(`.quality-group[data-panel-id="${selectedPanelId}"]`);
                if (matchingGroup) {
                    matchingGroup.classList.remove('d-none');
                }
            }
        }





        // document.addEventListener('DOMContentLoaded', function() {
        //     function updatePrice(quantityInput, priceDisplay, unitPrice) {
        //         var quantity = parseInt(quantityInput.value);
        //         var totalPrice = (quantity * unitPrice).toFixed(2);
        //         priceDisplay.textContent = totalPrice;
        //         updateTotalPrice();
        //     }

        //     function updateTotalPrice() {
        //         var total = 0;
        //         document.querySelectorAll('.product-price').forEach(function(priceElement) {
        //             total += parseFloat(priceElement.textContent);
        //         });
        //         document.getElementById('total_price').textContent = total.toFixed(2);
        //     }

        //     document.querySelectorAll('.panel-checkbox').forEach(function(checkbox) {
        //         checkbox.addEventListener('change', function() {
        //             var panelId = this.getAttribute('data-panel-id');
        //             var radioButtons = document.querySelectorAll('input[name="quality_preference[' +
        //                 panelId + ']"]');
        //             var quantityInput = document.querySelector(
        //                 'input.product-quantity[data-panel-id="' + panelId + '"]');
        //             var priceDisplay = document.querySelector('.product-price[data-panel-id="' +
        //                 panelId + '"]');
        //             var unitPrice = parseFloat(quantityInput.getAttribute('data-unit-price'));

        //             radioButtons.forEach(function(radio) {
        //                 radio.disabled = !checkbox.checked;
        //             });

        //             quantityInput.disabled = !checkbox.checked;

        //             if (!checkbox.checked) {
        //                 quantityInput.value = 1;
        //                 priceDisplay.textContent = '0.00';
        //             } else {
        //                 updatePrice(quantityInput, priceDisplay, unitPrice);
        //             }

        //             updateTotalPrice();
        //         });
        //     });

        //     document.querySelectorAll('.input-step').forEach(function(stepper) {
        //         var input = stepper.querySelector('.product-quantity');
        //         var panelId = input.getAttribute('data-panel-id');
        //         var priceDisplay = document.querySelector('.product-price[data-panel-id="' + panelId +
        //             '"]');
        //         var unitPrice = parseFloat(input.getAttribute('data-unit-price'));

        //         stepper.querySelector('.plus').addEventListener('click', function() {
        //             if (!input.disabled && Number(input.value) < Number(input.max)) {
        //                 input.value = parseInt(input.value) + 1;
        //                 updatePrice(input, priceDisplay, unitPrice);
        //             }
        //         });

        //         stepper.querySelector('.minus').addEventListener('click', function() {
        //             if (!input.disabled && Number(input.value) > Number(input.min)) {
        //                 input.value = parseInt(input.value) - 1;
        //                 updatePrice(input, priceDisplay, unitPrice);
        //             }
        //         });

        //         input.addEventListener('change', function() {
        //             if (!input.disabled) {
        //                 updatePrice(input, priceDisplay, unitPrice);
        //             }
        //         });
        //     });
        // });
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
