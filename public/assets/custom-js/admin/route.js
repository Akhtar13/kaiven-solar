$(function () {
    $(document).on('click', '#add_prices', function () {
        var location_ids = $('#location_id').val()
        var start_point = $('#start_point').val()
        var end_point = $('#end_point').val()
        $('#price-table-body').html('')
        $('#location_price').addClass('d-none')
        if (location_ids.length > 0) {
            var selectedOrder = new Array()
            $('ul#sortable-row li').each(function () {
                selectedOrder.push($(this).attr('id'))
            })
            document.getElementById('row_order').value = selectedOrder

            axios
                .post(APP_URL + location_price_table_url, {
                    // 'location_ids': location_ids,
                    'start_point': start_point,
                    'end_point': end_point,
                    'location_ids': selectedOrder
                })
                .then(function (response) {
                    $('#price-table-body').html(response.data.view)
                    $('#location_price').removeClass('d-none')
                    $('#order_modal').modal('hide')
                    loaderHide()
                })
                .catch(function (error) {
                    console.log(error)
                    loaderHide()
                    notificationToast(error.response.data.message, 'warning')
                })
        } else {
            notificationToast(select_more_then_one, 'warning')
        }
    })
    $(document).on('change', '#end_point', function () {
        let start_point = $('#start_point').val()
        let end_point = $(this).val()
        $('#locations-render').addClass('d-none')
        $('#locations-render').html('')
        $('#price-table-body').html('')
        $('#location_price').addClass('d-none')
        if (start_point == end_point) {
            notificationToast(start_point_end_point_not_same, 'warning')
            $(this).val('')
        } else {
            axios
                .post(APP_URL + location_selection_url + end_point, {'endpoint': start_point})
                .then(function (response) {
                    $('#locations-render').html(response.data.view)
                    $('#locations-render').removeClass('d-none')
                    loaderHide()
                })
                .catch(function (error) {
                    console.log(error)
                    loaderHide()
                    notificationToast(error.response.data.message, 'warning')
                })
        }
    })
    $(document).on('change', '#start_point', function () {
        let start_point = $(this).val()
        let end_point = $('#end_point').val()
        $('#locations-render').addClass('d-none')
        $('#locations-render').html('')
        $('#price-table-body').html('')
        $('#location_price').addClass('d-none')
        if (start_point == end_point) {
            notificationToast(start_point_end_point_not_same, 'warning')
            $(this).val('')
        } else {
            axios
                .post(APP_URL + location_selection_url + start_point, {'endpoint': end_point})
                .then(function (response) {
                    $('#locations-render').html(response.data.view)
                    $('#locations-render').removeClass('d-none')
                    loaderHide()
                })
                .catch(function (error) {
                    console.log(error)
                    loaderHide()
                    notificationToast(error.response.data.message, 'warning')
                })
        }
    })
    $(document).on('click', '#arrange_stops', function () {
        var location_ids = $('#location_id').val()
        var start_point = $('#start_point').val()
        var end_point = $('#end_point').val()
        $('#price-table-body').html('')
        $('#location_price').addClass('d-none')
        $('#order_modal_body').html('')
        if (location_ids.length > 0) {
            axios
                .post(APP_URL + get_stops_order_modal, {'location_ids': location_ids})
                .then(function (response) {
                    console.log(response)
                    loaderHide()
                    $('#order_modal_body').html(response.data.view)
                    $('#order_modal').modal('show')

                })
                .catch(function (error) {
                    console.log(error)
                    loaderHide()
                    notificationToast(error.response.data.message, 'warning')
                })
        } else {
            notificationToast(select_more_then_one, 'warning')
        }
    })

})