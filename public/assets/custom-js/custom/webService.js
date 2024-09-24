$(document).on('click', '.cancel-service', function () {
    const value_id = $(this).data('id')

    Swal.fire({
        title: 'Cancel Service',
        text: 'Are you sure you want to cancel this service',
        icon: 'warning',
        showCancelButton: !0,
        buttonsStyling: !1,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
        customClass: {
            confirmButton: 'btn fw-bold btn-danger',
            cancelButton: 'btn fw-bold btn-active-light-primary'
        }
    }).then((function (t) {
        if (t.isConfirmed) {
            cancelRecord(value_id)
        }
    }))
})

function cancelRecord(value_id) {
    loaderView()
    axios
        .get(APP_URL + '/service-cancel' + '/' + value_id)
        .then(function (response) {
            notificationToast(response.data.message, 'success')
            table.draw()
            loaderHide()
        })
        .catch(function (error) {
            notificationToast(error.response.data.message, 'warning')
            loaderHide()
        })

}