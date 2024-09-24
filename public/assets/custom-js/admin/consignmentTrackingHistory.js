const consignment_date = $('#consignment_date').flatpickr({
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
getCinsigments()

$(document).on('change', '#consignment_date', function () {
    getCinsigments()
    table.ajax.reload()
})

function getCinsigments() {
    var consignment_date = $('#consignment_date').val()
    loaderView()
    axios
        .post(APP_URL + getCheckInDetailsUrl, {
            consignment_date: consignment_date
        })
        .then(function (response) {
            console.log(response.data)
            // $('#new_arrival_count').text(response.data.newArrivalsCount)
            $('#transit_count').text(response.data.transitCount)
            $('#delivered_count').text(response.data.deliveredCount)
            $('#received_by_customer_count').text(response.data.receivedByCustomerCount)
            loaderHide()
        })
        .catch(function (error) {
            console.log(error)
            loaderHide()
            notificationToast(error.response.data.message, 'warning')
        })
}
