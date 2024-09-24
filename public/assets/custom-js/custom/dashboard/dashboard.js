load_active_user_chart()
load_user_sitters_chart()
load_services_chart()
$(document).on('change', '#active_user_year', function () {
    load_active_user_chart()
})
$(document).on('change', '#user_sitters_year', function () {
    load_user_sitters_chart()
})
$(document).on('change', '#services_year', function () {
    load_services_chart()
})

function load_active_user_chart() {
    loaderView()
    var chart = document.getElementById("active_user_chart"),
        height_gray = (parseInt(KTUtil.css(chart, "height")), KTUtil.getCssVariableValue("--bs-gray-500")),
        gray = KTUtil.getCssVariableValue("--bs-gray-200"),
        info = KTUtil.getCssVariableValue("--bs-info"),
        light_info = KTUtil.getCssVariableValue("--bs-light-info");
    const active_user_option = {
        series: [{name: "Active-users", data: []}],
        chart: {fontFamily: "inherit", type: "area", height: 350, toolbar: {show: !1}},
        plotOptions: {},
        legend: {show: !1},
        dataLabels: {enabled: !1},
        fill: {type: "solid", opacity: 1},
        stroke: {curve: "smooth", show: !0, width: 3, colors: [info]},
        xaxis: {
            categories: ["Jan","Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "sep", "oct", "nov", "dec"],
            axisBorder: {show: !1},
            axisTicks: {show: !1},
            labels: {style: {colors: height_gray, fontSize: "12px"}},
            crosshairs: {position: "front", stroke: {color: info, width: 1, dashArray: 3}},
            tooltip: {enabled: !0, formatter: void 0, offsetY: 0, style: {fontSize: "12px"}},
        },
        yaxis: {labels: {style: {colors: height_gray, fontSize: "12px"}}},
        states: {
            normal: {filter: {type: "none", value: 0}},
            hover: {filter: {type: "none", value: 0}},
            active: {allowMultipleDataPointsSelection: !1, filter: {type: "none", value: 0}}
        },
        tooltip: {
            style: {fontSize: "12px"}, y: {
                formatter: function (e) {
                    return e
                }
            }
        },
        colors: [light_info],
        grid: {borderColor: gray, strokeDashArray: 4, yaxis: {lines: {show: !0}}},
        markers: {strokeColor: info, strokeWidth: 3}
    }

    let active_user_chart = new ApexCharts(document.querySelector('#active_user_chart'), active_user_option)
    active_user_chart.render()

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    axios
        .post(APP_URL + '/get-active-user-chart', {
            active_user_year: $('#active_user_year').val()
        })
        .then(function (response) {
            active_user_chart.resetSeries()
            active_user_chart.updateSeries([{
                name: 'Active-users',
                data: response.data.activeUserArray
            }])
            $('#active_user_count').text(response.data.totalActiveUsers)
            loaderHide()

        })
        .catch(function (error) {
            loaderHide()
            notificationToast(error.response.data.message, 'warning');
            loaderHide();
        });
}

function load_user_sitters_chart() {
    loaderView()
    var chart = document.getElementById("user_sitters_chart"),
        height_gray = (parseInt(KTUtil.css(chart, "height")), KTUtil.getCssVariableValue("--bs-gray-500")),
        gray = KTUtil.getCssVariableValue("--bs-gray-200"),
        info = KTUtil.getCssVariableValue("--bs-info"),
        danger = KTUtil.getCssVariableValue("--bs-danger"),
        light_info = KTUtil.getCssVariableValue("--bs-light-info"),
        light_danger = KTUtil.getCssVariableValue("--bs-light-danger");
    const active_user_option = {
        series: [{name: "Active-users", data: []}, {name: "Sitters", data: []}],
        chart: {fontFamily: "inherit", type: "area", height: 350, toolbar: {show: !1}},
        plotOptions: {},
        legend: {show: !1},
        dataLabels: {enabled: !1},
        stroke: {curve: "smooth", show: !0, width: 3, colors: [info, danger]},
        xaxis: {
            categories: ["Jan","Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "sep", "oct", "nov", "dec"],
            axisBorder: {show: !1},
            axisTicks: {show: !1},
            labels: {style: {colors: height_gray, fontSize: "12px"}},
            tooltip: {enabled: !0, formatter: void 0, offsetY: 0, style: {fontSize: "12px"}},
        },
        yaxis: {labels: {style: {colors: height_gray, fontSize: "12px"}}},
        states: {
            normal: {filter: {type: "none", value: 0}},
            hover: {filter: {type: "none", value: 0}},
            active: {allowMultipleDataPointsSelection: !1, filter: {type: "none", value: 0}}
        },
        tooltip: {
            style: {fontSize: "12px"}, y: {
                formatter: function (e) {
                    return e
                }
            }
        },
        colors: [info, danger],
        grid: {borderColor: gray, strokeDashArray: 4, yaxis: {lines: {show: !0}}},
        markers: {strokeColor: [info, danger], strokeWidth: 3},
    }

    let active_user_chart = new ApexCharts(document.querySelector('#user_sitters_chart'), active_user_option)
    active_user_chart.render()

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    axios
        .post(APP_URL + '/get-user-sitter-chart', {
            active_user_year: $('#user_sitters_year').val()
        })
        .then(function (response) {
            active_user_chart.resetSeries()
            active_user_chart.updateSeries([{
                name: 'Active-users',
                data: response.data.activeUserArray
            },
                {
                    name: 'Sitters',
                    data: response.data.activeStatusArray
                }])
            $('#user_sitters_count').text(response.data.totalUsersSitters)
            loaderHide()

        })
        .catch(function (error) {
            loaderHide()
            notificationToast(error.response.data.message, 'warning');
            loaderHide();
        });
}

function load_services_chart() {
    loaderView()
    var chart = document.getElementById("services_chart"),
        height_gray = (parseInt(KTUtil.css(chart, "height")), KTUtil.getCssVariableValue("--bs-gray-500")),
        gray = KTUtil.getCssVariableValue("--bs-gray-200"),
        info = KTUtil.getCssVariableValue("--bs-info"),
        danger = KTUtil.getCssVariableValue("--bs-danger"),
        light_info = KTUtil.getCssVariableValue("--bs-light-info"),
        light_danger = KTUtil.getCssVariableValue("--bs-light-danger");
    const active_user_option = {
        series: [{name: "Complete Services", data: []}, {name: "Active-Services", data: []}],
        chart: {fontFamily: "inherit", type: "area", height: 350, toolbar: {show: !1}},
        plotOptions: {},
        legend: {show: !1},
        dataLabels: {enabled: !1},
        stroke: {curve: "smooth", show: !0, width: 3, colors: [info, danger]},
        xaxis: {
            categories: ["Jan","Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "sep", "oct", "nov", "dec"],
            axisBorder: {show: !1},
            axisTicks: {show: !1},
            labels: {style: {colors: height_gray, fontSize: "12px"}},
            tooltip: {enabled: !0, formatter: void 0, offsetY: 0, style: {fontSize: "12px"}},
        },
        yaxis: {labels: {style: {colors: height_gray, fontSize: "12px"}}},
        states: {
            normal: {filter: {type: "none", value: 0}},
            hover: {filter: {type: "none", value: 0}},
            active: {allowMultipleDataPointsSelection: !1, filter: {type: "none", value: 0}}
        },
        tooltip: {
            style: {fontSize: "12px"}, y: {
                formatter: function (e) {
                    return e
                }
            }
        },
        colors: [info, danger],
        grid: {borderColor: gray, strokeDashArray: 4, yaxis: {lines: {show: !0}}},
        markers: {strokeColor: [info, danger], strokeWidth: 3},
    }

    let active_user_chart = new ApexCharts(document.querySelector('#services_chart'), active_user_option)
    active_user_chart.render()

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
    axios
        .post(APP_URL + '/get-services-chart', {
            active_user_year: $('#services_year').val()
        })
        .then(function (response) {
            active_user_chart.resetSeries()
            active_user_chart.updateSeries([{
                name: 'Complete Services',
                data: response.data.completeServicesArray
            },
                {
                    name: 'Active-Services',
                    data: response.data.activeServicesArray
                }])
            $('#services_count').text(response.data.totalUsersSitters)
            loaderHide()

        })
        .catch(function (error) {
            loaderHide()
            notificationToast(error.response.data.message, 'warning');
            loaderHide();
        });
}
