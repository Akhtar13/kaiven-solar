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
                            <div class="card-body">
                                <div class="live-preview">
                                    <form method="POST" data-parsley-validate="" id="addEditForm" role="form">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="col-lg-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="name"
                                                        name="name" placeholder="Enter your name">
                                                    <label for="name">Name</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="mobile_no"
                                                        name="mobile_no" placeholder="Enter your Mobile No">
                                                    <label for="mobile_no">Mobile No</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-floating">
                                                    <select class="form-select" id="address_type" name="address_type"
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
                                                    <input type="text" class="form-control" id="cityfloatingInput"
                                                        placeholder="Enter your city">
                                                    <label for="cityfloatingInput">City</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control float" id="billing_year" name="billing_year"
                                                        placeholder="Enter your Higest Billing Year">
                                                    <label for="billing_year">Enter Your Higest Billing Per Year</label>
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
                                                                                type="checkbox" name="panel_brands[]"
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
                                                                        <input type="number" class="product-quantity"
                                                                            value="1" min="0"
                                                                            max="100"
                                                                            name="quantity[] "
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

                                                <div class="text-end mb-4">
                                                    <button type="submit"
                                                        class="btn btn-success btn-label right ms-auto">
                                                        <i
                                                            class="ri-arrow-right-line label-icon align-bottom fs-16 ms-2"></i>
                                                        Submit Request
                                                    </button>
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
</body>

</html>
