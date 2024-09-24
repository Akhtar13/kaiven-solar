const travel_date = $('#travel_date').flatpickr({
    dateFormat: 'Y-m-d',
    onChange: function (selectedDates, dateStr, instance) {
        var selectedDate = selectedDates[0];
        var currentDate = new Date();
        currentDate.setHours(0, 0, 0, 0);
        if (selectedDate >= currentDate) {
            is_past = 0
        } else {
            is_past = 1
        }
    }
})

getRoutes()

$(document).on('change', '#travel_date', function () {
    getRoutes()
})

$(document).on('click', '.get-checkin-details', function () {
    var route_id = $(this).data('id')
    getCheckInDetails(route_id)
})

$(document).on('click', '.download-checked-in-excle', function () {
    loaderView()
    var route_id = $(this).data('id')
    var travel_date = $('#travel_date').val()
    window.location.href = APP_URL + downloadCheckedInExcleUrl + '/' + route_id + '/' + travel_date
    loaderHide()
})

function getRoutes() {
    var travel_date = $('#travel_date').val()
    $('#render_details').html('')
    loaderView()
    axios
        .post(APP_URL + getCheckInRoutes, {
            travel_date: travel_date,
        })
        .then(function (response) {
            $('#render_details').html(response.data.view)
            loaderHide()
        })
        .catch(function (error) {
            console.log(error)
            notificationToast(error.response.data.message, 'warning')
            loaderHide()
        })
}

function getCheckInDetails(route_id) {
    $('#booking_details_modal_body').html('')
    var travel_date = $('#travel_date').val()
    loaderView()
    axios
        .post(APP_URL + getCheckInDetailsUrl, {
            travel_date: travel_date,
            route_id: route_id,
        })
        .then(function (response) {
            $('#booking_details_modal_body').html(response.data.view)
            $('#booking_details_modal').modal('show')
            $('#pending_customer_table').DataTable({"pageLength": 5})
            $('#checked_in_customer_table').DataTable({"pageLength": 5})
            loaderHide()
        })
        .catch(function (error) {
            console.log(error)
            loaderHide()
            notificationToast(error.response.data.message, 'warning')
        })
}