<!DOCTYPE html>
{{-- <html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" data-layout-mode="dark"> --}}
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
                                    <form action="#">
                                        <div class="row g-3">
                                            <div class="col-lg-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="name"
                                                        placeholder="Enter your name">
                                                    <label for="name">Name</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="mobile_no"
                                                        placeholder="Enter your Mobile No">
                                                    <label for="mobile_no">Mobile No</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-floating">
                                                    <select class="form-select" id="floatingSelect"
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
                                                    <input type="text" class="form-control float" id="billing_year"
                                                        placeholder="Enter your Higest Billing Year">
                                                    <label for="billing_year">Enter Your Higest Billing Per Year</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-floating">
                                                    <select class="form-select" id="floatingSelect"
                                                        aria-label="Floating label select example">
                                                        <option value="">Choose...</option>
                                                        @foreach ($panelBrands as $panelBrand)
                                                            <option value="{{ $panelBrand->id }}">
                                                                {{ $panelBrand->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <label for="floatingSelect">Panel Brand</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                @foreach ($qualityPreferences as $qualityPreference)
                                                    <div class="card product">
                                                        <div class="card-body">
                                                            <div class="row gy-3">
                                                                <div class="col-sm">
                                                                    <h5 class="fs-14 text-truncate"><a
                                                                            href="ecommerce-product-detail.html"
                                                                            class="text-body">{{$qualityPreference->name}}
                                                                        </a></h5>
                                                                    <ul class="list-inline text-muted">
                                                                        <li class="list-inline-item">Color : <span
                                                                                class="fw-medium">Pink</span></li>
                                                                        <li class="list-inline-item">Size : <span
                                                                                class="fw-medium">M</span></li>
                                                                    </ul>

                                                                    <div class="input-step">
                                                                        <button type="button"
                                                                            class="minus material-shadow">–</button>
                                                                        <input type="number" class="product-quantity"
                                                                            value="2" min="0"
                                                                            max="100">
                                                                        <button type="button"
                                                                            class="plus material-shadow">+</button>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-auto">
                                                                    <div class="text-lg-end">
                                                                        <p class="text-muted mb-1">Item Price:</p>
                                                                        <h5 class="fs-14">$<span id="ticket_price"
                                                                                class="product-price">119.99</span></h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <div class="text-end mb-4">
                                                    <a href="apps-ecommerce-checkout.html"
                                                        class="btn btn-success btn-label right ms-auto"><i
                                                            class="ri-arrow-right-line label-icon align-bottom fs-16 ms-2"></i>
                                                        Checkout</a>
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
    @yield('custom-script')
</body>

</html>
