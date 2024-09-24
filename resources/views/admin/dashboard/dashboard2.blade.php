@extends('admin.layouts.master')
@section('title','Dashboard')
@section('content')
    <div class="row">
        <div class="col-xxl-6">
            <div class="d-flex flex-column h-100">
                <div class="row h-100">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="row align-items-end">
                                    <div class="col-sm-8">
                                        <div class="p-3">
                                           <h3>Booking Statics</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fw-medium text-muted mb-0">Users</p>
                                        <h2 class="mt-4 ff-secondary fw-semibold">
                                            <span class="counter-value" data-target="28.05">0</span>k
                                        </h2>
                                        <p class="mb-0 text-muted">
                                            <span class="badge bg-light text-success mb-0">
                                                <i class="ri-arrow-up-line align-middle"></i> 16.24 %
                                            </span> vs. previous month
                                        </p>
                                    </div>
                                    <div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                                <i data-feather="users" class="text-info"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fw-medium text-muted mb-0">Sessions</p>
                                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                                                                        data-target="97.66">0</span>k
                                        </h2>
                                        <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0"> <i
                                                        class="ri-arrow-down-line align-middle"></i> 3.96 % </span> vs.
                                            previous month</p>
                                    </div>
                                    <div>
                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                                                <i data-feather="activity" class="text-info"></i>
                                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div> <!-- end row-->
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fw-medium text-muted mb-0">Users</p>
                                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                                                                        data-target="28.05">0</span>k
                                        </h2>
                                        <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0"> <i
                                                        class="ri-arrow-up-line align-middle"></i> 16.24 % </span> vs.
                                            previous month</p>
                                    </div>
                                    <div>
                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                                                <i data-feather="users" class="text-info"></i>
                                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div> <!-- end card-->
                    </div> <!-- end col-->

                    <div class="col-md-6">
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="fw-medium text-muted mb-0">Sessions</p>
                                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                                                                        data-target="97.66">0</span>k
                                        </h2>
                                        <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0"> <i
                                                        class="ri-arrow-down-line align-middle"></i> 3.96 % </span> vs.
                                            previous month</p>
                                    </div>
                                    <div>
                                        <div class="avatar-sm flex-shrink-0">
                                                            <span class="avatar-title bg-soft-info rounded-circle fs-2">
                                                                <i data-feather="activity" class="text-info"></i>
                                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div> <!-- end card-->
                    </div> <!-- end col-->
                </div> <!-- end row-->
            </div>
        </div>
        <div class="col-xxl-6">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Users by Device</h4>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                               aria-expanded="false">
                                <span class="text-muted fs-16"><i class="mdi mdi-dots-vertical align-middle"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Today</a>
                                <a class="dropdown-item" href="#">Last Week</a>
                                <a class="dropdown-item" href="#">Last Month</a>
                                <a class="dropdown-item" href="#">Current Year</a>
                            </div>
                        </div>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div id="user_device_pie_charts" data-colors='["--vz-primary", "--vz-warning", "--vz-info"]'
                         class="apex-charts" dir="ltr"></div>

                    <div class="table-responsive mt-3">
                        <table class="table table-borderless table-sm table-centered align-middle table-nowrap mb-0">
                            <tbody class="border-0">
                            <tr>
                                <td>
                                    <h4 class="text-truncate fs-14 fs-medium mb-0"><i
                                                class="ri-stop-fill align-middle fs-18 text-primary me-2"></i>Desktop
                                        Users</h4>
                                </td>
                                <td>
                                    <p class="text-muted mb-0"><i data-feather="users" class="me-2 icon-sm"></i>78.56k
                                    </p>
                                </td>
                                <td class="text-end">
                                    <p class="text-success fw-medium fs-12 mb-0"><i
                                                class="ri-arrow-up-s-fill fs-5 align-middle"></i>2.08% </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4 class="text-truncate fs-14 fs-medium mb-0"><i
                                                class="ri-stop-fill align-middle fs-18 text-warning me-2"></i>Mobile
                                        Users</h4>
                                </td>
                                <td>
                                    <p class="text-muted mb-0"><i data-feather="users" class="me-2 icon-sm"></i>105.02k
                                    </p>
                                </td>
                                <td class="text-end">
                                    <p class="text-danger fw-medium fs-12 mb-0"><i
                                                class="ri-arrow-down-s-fill fs-5 align-middle"></i>10.52%
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4 class="text-truncate fs-14 fs-medium mb-0"><i
                                                class="ri-stop-fill align-middle fs-18 text-info me-2"></i>Tablet Users
                                    </h4>
                                </td>
                                <td>
                                    <p class="text-muted mb-0"><i data-feather="users" class="me-2 icon-sm"></i>42.89k
                                    </p>
                                </td>
                                <td class="text-end">
                                    <p class="text-danger fw-medium fs-12 mb-0"><i
                                                class="ri-arrow-down-s-fill fs-5 align-middle"></i>7.36%
                                    </p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-xxl-12">
                            <div class="">
                                <div class="card-header border-0 align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Booking Counts</h4>
                                    <div>
                                        <button type="button" class="btn btn-soft-secondary btn-sm">
                                            ALL
                                        </button>
                                        <button type="button" class="btn btn-soft-secondary btn-sm active">
                                            Current Month
                                        </button>
                                        <button type="button" class="btn btn-soft-secondary btn-sm">
                                            Last Month
                                        </button>
                                        <button type="button" class="btn btn-soft-secondary btn-sm">
                                            This Year
                                        </button>
                                    </div>
                                </div>
                                <div class="row g-0 text-center">
                                    <div class="col-6 col-sm-4">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1"><span class="counter-value" data-target="36">0</span>
                                            </h5>
                                            <p class="text-muted mb-0">Admin</p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <div class="p-3 border border-dashed border-start-0">
                                            <h5 class="mb-1"><span class="counter-value" data-target="92">0</span>
                                            </h5>
                                            <p class="text-muted mb-0">BranchManager</p>
                                        </div>
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <div class="p-3 border border-dashed border-end-0">
                                            <h5 class="mb-1"><span class="counter-value" data-target="8">0</span>
                                            </h5>
                                            <p class="text-muted mb-0">SalesPerson</p>
                                        </div>
                                    </div>
                                </div>
                                <div id="booking_count_chart"
                                     data-colors='["--vz-primary","--vz-success", "--vz-gray-300"]' class="apex-charts"
                                     dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6 col-md-6">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Top Five Routes</h4>
                    <div class="flex-shrink-0">
                        {{--                        <button type="button" class="btn btn-soft-primary btn-sm">--}}
                        {{--                            Export Report--}}
                        {{--                        </button>--}}
                    </div>
                </div>

                <div class="card-body">

                    <div class="row align-items-center">
                        <div class="col-6">
                            <h6 class="text-muted text-uppercase fw-semibold text-truncate fs-12 mb-3">
                                Total Booking Count
                            </h6>
                            <h4 class="mb-0">725,800</h4>
                            <p class="mb-0 mt-2 text-muted">
                                <span class="badge badge-soft-success mb-0">
                                    <i class="ri-arrow-up-line align-middle"></i>15.72 %
                                </span> vs. previous month
                            </p>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <img src="{{asset('assets/images/illustrator-1.png')}}" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 pt-2">
                        <div class="progress progress-lg rounded-pill">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%"
                                 aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar bg-info" role="progressbar" style="width: 18%" aria-valuenow="18"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar bg-success" role="progressbar" style="width: 22%"
                                 aria-valuenow="22" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 16%"
                                 aria-valuenow="16" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 19%" aria-valuenow="19"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>

                    <div class="mt-3 pt-2">
                        <div class="d-flex mb-2">
                            <div class="flex-grow-1">
                                <p class="text-truncate text-muted fs-14 mb-0">
                                    <i class="mdi mdi-circle align-middle text-primary me-2"></i>Dubai-Ruwi
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <p class="mb-0">24</p>
                            </div>
                        </div>
                        <div class="d-flex mb-2">
                            <div class="flex-grow-1">
                                <p class="text-truncate text-muted fs-14 mb-0">
                                    <i class="mdi mdi-circle align-middle text-info me-2"></i>Ruwi-Dubai </p>
                            </div>
                            <div class="flex-shrink-0">
                                <p class="mb-0">17</p>
                            </div>
                        </div>
                        <div class="d-flex mb-2">
                            <div class="flex-grow-1">
                                <p class="text-truncate text-muted fs-14 mb-0"><i
                                            class="mdi mdi-circle align-middle text-success me-2"></i>Ruwi-Sohar</p>
                            </div>
                            <div class="flex-shrink-0">
                                <p class="mb-0">23</p>
                            </div>
                        </div><!-- end -->
                        <div class="d-flex mb-2">
                            <div class="flex-grow-1">
                                <p class="text-truncate text-muted fs-14 mb-0">
                                    <i class="mdi mdi-circle align-middle text-warning me-2"></i>Sohar-Dubai
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <p class="mb-0">12</p>
                            </div>
                        </div><!-- end -->
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate text-muted fs-14 mb-0">
                                    <i class="mdi mdi-circle align-middle text-danger me-2"></i>Dubai-Sohar
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <p class="mb-0">17</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('custom-script')
    <script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script>
        function getChartColorsArray(e) {
            if (null !== document.getElementById(e)) {
                var r = document.getElementById(e).getAttribute("data-colors");
                if (r) return (r = JSON.parse(r)).map(function (e) {
                    var r = e.replace(" ", "");
                    return -1 === r.indexOf(",") ? getComputedStyle(document.documentElement).getPropertyValue(r) || r : 2 == (e = e.split(",")).length ? "rgba(" + getComputedStyle(document.documentElement).getPropertyValue(e[0]) + "," + e[1] + ")" : r
                });
                console.warn("data-colors atributes not found on", e)
            }
        }

        //For Booking Count Chart
        let bookingCountChartData;
        const bookingCountChartBasicColors = getChartColorsArray("booking_count_chart");

        const currentDate = new Date();
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth();

        function formatDate(date) {
            const day = date.getDate();
            const month = date.getMonth();
            const monthName = months[month];
            return `${day} ${monthName}`;
        }

        const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
        const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        const xaxisCategories = [];
        for (let day = 1; day <= daysInMonth; day++) {
            const currentDate = new Date(currentYear, currentMonth, day);
            xaxisCategories.push(formatDate(currentDate));
        }
        if (bookingCountChartBasicColors) {
            const options = {
                series: [
                    {name: "Admin", data: [10, 41, 35, 51, 49, 62, 69, 91, 148]},
                    {name: "BranchManager", data: [40, 120, 83, 45, 31, 74, 35, 34, 78]},
                    {name: "SalesPerson", data: [95, 35, 20, 130, 64, 22, 43, 45, 31]}
                ],
                chart: {height: 350, type: "line", zoom: {enabled: false}, toolbar: {show: false}},
                dataLabels: {enabled: false},
                stroke: {curve: "smooth", width: 3},
                colors: bookingCountChartBasicColors,
                xaxis: {categories: xaxisCategories}
            };
            bookingCountChartData = options;
        }
        const bookingCountChartOptions = new ApexCharts(document.querySelector("#booking_count_chart"), bookingCountChartData);
        bookingCountChartOptions.render();


        // For User Count Chart
        const dountchartUserDeviceColors = getChartColorsArray("user_device_pie_charts");

        if (dountchartUserDeviceColors) {
            const options = {
                series: [78.56, 105.02, 42.89],
                labels: ["Desktop", "Mobile", "Tablet"],
                chart: {type: "donut", height: 219},
                plotOptions: {pie: {size: 100, donut: {size: "76%"}}},
                dataLabels: {enabled: false},
                legend: {
                    show: false,
                    position: "bottom",
                    horizontalAlign: "center",
                    offsetX: 0,
                    offsetY: 0,
                    markers: {width: 20, height: 6, radius: 2},
                    itemMargin: {horizontal: 12, vertical: 0}
                },
                stroke: {width: 0},
                yaxis: {
                    labels: {
                        formatter: function (e) {
                            return e + "k Users";
                        }
                    },
                    tickAmount: 4,
                    min: 0
                },
                colors: dountchartUserDeviceColors
            };
            const chart = new ApexCharts(document.querySelector("#user_device_pie_charts"), options);
            chart.render();
        }

    </script>
@endsection
