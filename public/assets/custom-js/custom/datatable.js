var pageInfo = 0;
var pageIndex = 0;
const table = $('#basic-1').DataTable({
    processing: true,
    serverSide: true,
    autoWidth: false,
    ajax: {
        url: APP_URL + datatable_url,
        type: 'GET',
        data: function (d) {
            d.status = $('#status').val()
            d.user_id = $('#user_id').val()
            d.branch_id = $('#branch_id').val()
            d.consignment_date = $('#consignment_date').val()
            d.date = $('#date').val()
            d.user_agent_id = $('#user_agent_id').val()
            d.agent_date = $('#agent_date').val()
            d.travel_date = $('#travel_date_range_filter').val()
            d.branch_manager_id = $('#branch_manager_id').val()
            d.region_id = $('#region_id').val()
            d.route_id = $('#route_id').val()
            // d.branch_id = $('#branch_id').val()
            d.sales_person_id = $('#sales_person_id').val()
            d.expense_type = $('#expense_type').val()
            d.expense_date = $('#expense_date').val()
        }
    },
    drawCallback: function () {
        pageCount()
    },
    language: {
        processing: '<div class="spinner-border text-primary m-1" role="status"><span class="sr-only">Loading...</span></div>'
    },
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']]
})

function pageCount() {
    pageInfo = table.page.info();
    pageIndex = pageInfo.page + 1;
}

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })


    $(document).on('keyup', '.col-search-input', function () {
        const value = $(this).val()
        $('#search_value').val(value)
        table.draw()
    })

    $('#data-table-search').keyup(function () {
        console.log($(this).val())
        table.search($(this).val()).draw()
    })

    $(document).on('click', '.filter_apply', function () {
        table.draw()
    })

    $(document).on('change', '.status-filter', function () {
        table.draw()
    })

    $(document).on('click', '.clear_filter', function () {
        $('#search_value').val('')
        $('#date_range_filter').val('').trigger('change')
        $('#start_date').val('').trigger('change')
        $('#end_date').val('').trigger('change')
        $('.col-search-input').val('')
        $('#user_id').val('').trigger('change')
        $('#user_agent_id').val('').trigger('change')
        $('#branch_id').val('').trigger('change')
        $('#travel_date_range_filter').val('').trigger('change')
        $('#status').val('').trigger('change')
        // $('#travel_date_range_filter').val('');
        $('#date').val('');
        $('#agent_date').val('');
        $('.ranges ul li').removeClass('active');
        $('li[data-range-key="All time"]').addClass('active');


        if (typeof dateRangePickerInput !== 'undefined') {
            dateRangePickerInput.data('daterangepicker').setStartDate(moment());
            dateRangePickerInput.data('daterangepicker').setEndDate(moment());
        }
        if (typeof sales_person_id !== 'undefined') {
            sales_person_id.setChoiceByValue('')
        }
        if (typeof expense_type !== 'undefined') {
            expense_type.setChoiceByValue('')
        }
        if (typeof route_id !== 'undefined') {
            route_id.setChoiceByValue('')
        }
        if (typeof user_id !== 'undefined') {
            user_id.setChoiceByValue('')
        }
        if (typeof user_agent_id !== 'undefined') {
            user_agent_id.setChoiceByValue('')
        }
        if (typeof branch_id !== 'undefined') {
            branch_id.setChoiceByValue('')
        }
        if (typeof branch_manager_id !== 'undefined') {
            branch_manager_id.setChoiceByValue('')
        }
        if (typeof region_id !== 'undefined') {
            region_id.setChoiceByValue('')
        }

        if (typeof branch_id !== 'undefined') {
            branch_id.setChoiceByValue('')
        }
        table.draw()
    })

    $(document).on('click', '.delete-single', function () {
        const value_id = $(this).data('id')

        Swal.fire({
            title: sweetalert_delete_title,
            text: sweetalert_delete_text,
            icon: 'warning',
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: sweetalert_confirm_button_text,
            cancelButtonText: sweetalert_cancel_button_text,
            customClass: {
                confirmButton: 'btn fw-bold btn-danger mx-2',
                cancelButton: 'btn fw-bold btn-info'
            }
        }).then((function (t) {
            if (t.isConfirmed) {
                deleteRecord(value_id)
            }
        }))
    })

    function deleteRecord(value_id) {
        loaderView()
        axios
            .delete(APP_URL + form_url + '/' + value_id)
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

    $(document).on('click', '.status-change', function () {
        const value_id = $(this).data('id')
        const status = $(this).data('status')
        Swal.fire({
            title: sweetalert_change_status,
            // text: sweetalert_change_status_text,
            icon: 'warning',
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: 'Yes Change It',
            cancelButtonText: 'Cancel',
            customClass: {
                confirmButton: 'btn fw-bold btn-danger',
                cancelButton: 'btn fw-bold btn-active-light-primary'
            },
        }).then((function (t) {
            if (t.isConfirmed) {
                changeStatus(value_id, status)
            }
        }))
    })


    function changeStatus(value_id, status) {
        loaderView()
        axios
            .get(APP_URL + form_url + '/status' + '/' + value_id + '/' + status)
            .then(function (response) {
                table.draw()
                notificationToast(response.data.message, 'success')
                loaderHide()
            })
            .catch(function (error) {
                notificationToast(error.response.data.message, 'warning')
                loaderHide()
            })
    }

    $(document).on('click', '.default-toggle', function () {
        const donation_id = $(this).data('id');
        const is_slider_display = $(this).data('is_slider_display');

        Swal.fire({
            title: sweetalert_change_default,
            icon: 'warning',
            showCancelButton: !0,
            buttonsStyling: !1,
            confirmButtonText: 'Yes, change it!',
            cancelButtonText: 'Cancel',
            customClass: {
                confirmButton: 'btn fw-bold btn-danger',
                cancelButton: 'btn fw-bold btn-active-light-primary'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                changeDefaultStatus(donation_id, is_slider_display);
            }
        });
    });

    function changeDefaultStatus(donation_id, is_slider_display) {
        axios.post('/admin/donation/update-default', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: donation_id,
            is_slider_display: is_slider_display
        })
            .then(function (response) {
                if (response.data.success) {
                    table.draw();
                    notificationToast(response.data.message, 'success');
                    loaderHide();
                } else {
                    notificationToast(response.data.message, 'warning');
                    loaderHide();
                }
            })
            .catch(function (error) {
                notificationToast(error.response.data.message, 'warning');
                loaderHide();
            });
    }
    $(document).on('click', '.detail-button', function () {
        const value_id = $(this).data('id')
        console.log(value_id)
        loaderView()
        axios
            .get(APP_URL + modal_url + '/' + value_id)
            .then(function (response) {
                $('#detailsModal').modal('show')
                $('#details_modal_title').html(response.data.modal_title)
                $('#details_modal_body').html(response.data.data)
                loaderHide()
                feather.replace()
                // KTMenu.init()
                // KTMenu.init()
            })
            .catch(function (error) {
                loaderHide()
                console.log(error)
            })
    })

    // integerOnly()
    function getFilterValues() {
        var filterArray =
            {
                'status': $('#status').val(),
                'user_id': $('#user_id').val(),
                'expense_type': $('#expense_type').val(),
                'search': $('#data-table-search').val(),
                'search_value': $('#search_value').val(),
                'date_range_filter': $('#date_range_filter').val(),
                'date': $('#date').val(),
                'agent_date': $('#agent_date').val(),
                'start_date': $('#start_date').val(),
                'end_date': $('#end_date').val(),
                'user_agent_id': $('#user_agent_id').val(),
                // 'agent_date': $('#agent_date').val(),
                'branch_id': $('#branch_id').val(),
                'travel_date': $('#travel_date_range_filter').val(),
                'consignment_date': $('#consignment_date').val(),
                'route_id': $('#route_id').val(),
                'branch_manager_id': $('#branch_manager_id').val(),
                'region_id': $('#region_id').val(),
                'sales_person_id': $('#sales_person_id').val(),
                'expense_date': $('#expense_date').val(),
            }
        jsonString = JSON.stringify(filterArray)
        return filterArray
    }

    $(document).on('click', '.print-report', function () {
        const value_id = $(this).data('id')
        axios
            .get(APP_URL + print_url + value_id)
            .then(function (response) {
                var printWindow = window.open("", "", "width=2500,height=2500");
                printWindow.document.write(response.data.print_preview);
                printWindow.document.close();
                printWindow.onload = function () {
                    printWindow.print();
                };
                loaderHide()
            })
            .catch(function (error) {
                console.log(error)
                notificationToast(error.response.data.message, 'warning')
                loaderHide()
            })
    })

    $(document).on('click', '.export-excle', function () {
        loaderView()
        var data = getFilterValues()
        jsonString = JSON.stringify(data)
        console.log(jsonString)
        let link = APP_URL + '/' + exportUrl + '/?filter=' + jsonString
        window.location.href = link
        loaderHide()
    })

    $(document).on('click', '.export-pdf', function () {
        loaderView()
        var data = getFilterValues()
        jsonString = JSON.stringify(data)
        console.log(jsonString)
        let link = APP_URL + '/' + exportUrlPdf + '/?filter=' + jsonString
        window.location.href = link
        loaderHide()
    })

    $(document).on('click', '.download-invoice', function () {
        const value_id = $(this).data('id')
        loaderView()
        let link = APP_URL + exportUrlInvoice + '/' + value_id
        window.location.href = link
        loaderHide()
    })
})


