var is_past = 0
var is_main_international = 0
var is_retun_international = 0
$('#travel_date').flatpickr({
    dateFormat: 'd/m/Y',
    onChange: function (selectedDates, dateStr, instance) {
        var selectedDate = selectedDates[0];
        var currentDate = new Date();
        currentDate.setHours(0, 0, 0, 0);
        if (selectedDate >= currentDate) {
            is_past = 0
        } else {
            is_past = 1
            $('#submit_part').addClass('d-none')
        }
    }
})
$('#return_travel_date').flatpickr({
    dateFormat: 'd/m/Y',
    minDate: new Date(),
    onChange: function (selectedDates, dateStr, instance) {
        var selectedDate = selectedDates[0];
        var currentDate = new Date();
        currentDate.setHours(0, 0, 0, 0);
        $('.return_seat_number').remove();
        returnSeatArray = []
        if (selectedDate >= currentDate) {
            is_past = 0
        } else {
            is_past = 1
            $('#submit_part').addClass('d-none')
        }
    }
})
var returnSeatArray = []
var gender_choices_element = []
const route_id_choices_element = new Choices(document.querySelector('#route_id'), {
    maxItemCount: Infinity,
    shouldSort: false
});

const return_route_id_choices_element = new Choices(document.querySelector('#return_route_id'), {
    maxItemCount: Infinity,
    shouldSort: false
});

const region_id_choices_element = new Choices(document.querySelector('#region_id'), {
    maxItemCount: Infinity
});
const trip_id_choices_element = new Choices(document.querySelector('#trip_id'), {
    shouldSort: false,
    searchPlaceholderValue: 'Select a trip ID',
    itemSelectText: '',
    maxItemCount: Infinity
});


const return_trip_id_choices_element = new Choices(document.querySelector('#return_trip_id'), {
    shouldSort: false,
    searchPlaceholderValue: 'Select a trip ID',
    itemSelectText: '',
    maxItemCount: Infinity
});
var nationality_choices_element = '';
var multiple_seat_array = [];
var unblock_id_array = [];
var block_unblock_object = {};

$(document).on('click', '.book-seat', function () {
    $('#available_seats_render').html('')
    console.log('come herre')
    let seatNumber = $(this).data('seat-number');
    let dataName = $(this).data('name');
    let bookingcount = $(this).data('bookingcount');
    let unblockid = $(this).data('unblockid');

    if (dataName == 'print_ticket') {
        if ($(this).hasClass('blockFalse')) {
            if (bookingcount === 1) {
                printTicket([$(this).data('id')])
            } else {
                loaderView()
                axios
                    .post(APP_URL + get_booked_routes, {
                        travel_date: $('#travel_date').val(),
                        route_id: $('#route_id').val(),
                        seat_number: seatNumber
                    })
                    .then(function (response) {
                        loaderHide()
                        $('#ticket_print_modal_body').html(response.data.view);
                        $('#ticket_print_modal').modal('show');
                    })
                    .catch(function (error) {
                        console.log(error)
                        loaderHide()
                    })
            }
        } else {
            notificationToast(this_seat_is_not_booked, 'warning')
        }
    } else if (dataName == 'block_unblock_seat') {
        console.log(unblockid === undefined)
        if ($(this).hasClass('blockFalse') && unblockid === undefined) {
            notificationToast(this_seat_already_booked, 'warning')
        } else {
            if (multiple_seat_array.includes(seatNumber)) {
                delete block_unblock_object[seatNumber];
                if (unblock_id_array.includes(unblockid)) {
                    const index2 = unblock_id_array.indexOf(unblockid);
                    if (index2 > -1) {
                        unblock_id_array.splice(index2, 1);
                    }
                }
                const index = multiple_seat_array.indexOf(seatNumber);
                if (index > -1) {
                    multiple_seat_array.splice(index, 1);
                }
                disselectSeat($(this).data('selected_no'))
                $(this).removeClass('multiple_selected');
            } else {

                if (unblockid != undefined) {
                    unblock_id_array.push(unblockid)
                    block_unblock_object[seatNumber] = {'seat_number': seatNumber, 'unblockid': unblockid};
                } else {
                    loaderView()
                    axios
                        .post(APP_URL + validate_seat_url, {
                            travel_date: $('#travel_date').val(),
                            route_id: $('#route_id').val(),
                            trip_id: $('#trip_id').val(),
                            seat_number: seatNumber,
                            unique_timestamp: $('#unique_timestamp').val(),
                        })
                        .then(function (response) {
                            loaderHide()
                            $('#seat_number_' + seatNumber).data("selected_no", response.data.booking_id);
                            $('#seat_number_' + seatNumber).attr("data-selected_no", response.data.booking_id);
                            block_unblock_object[seatNumber] = {'seat_number': seatNumber, 'unblockid': null};
                            multiple_seat_array.push(seatNumber);
                            $('#seat_number_' + seatNumber).addClass('multiple_selected');
                        })
                        .catch(function (error) {
                            console.log(error)
                            loaderHide()
                            notificationToast(error.response.data.message, 'warning')
                        })
                }

            }
        }

    } else if (dataName == 'add_seats') {
        if ($(this).hasClass('booked_seats')) {
            notificationToast(this_seat_already_booked, 'warning')
        } else {
            console.log($('#is_max_count').val())
            if (is_past == 1) {
                notificationToast(bus_has_already_depatured, 'warning')
            } else if (multiple_seat_array.includes(seatNumber)) {
                removeAddBookingForms(seatNumber)
                const index = multiple_seat_array.indexOf(seatNumber);
                if (index > -1) {
                    multiple_seat_array.splice(index, 1);
                }
                if (multiple_seat_array.length === 0) {
                    $('#submit_part').addClass('d-none')
                }
                disselectSeat($(this).data('selected_no'))
                var newValue = 0;
                $(this).data('selected_no', newValue);
                $(this).attr('data-selected_no', newValue);
                $(this).removeClass('multiple_selected');
            } else {
                // multiple_seat_array.push(seatNumber);
                // $(this).addClass('multiple_selected');
                // getAddBookingForms(seatNumber, false)
                if ($('#is_max_count').val() === "1") {
                    notificationToast(you_already_booked_max_seats, 'warning')
                } else {
                    multiple_seat_array.push(seatNumber);
                    $(this).addClass('multiple_selected');
                    getAddBookingForms(seatNumber, false)
                }
            }
        }
    } else {
        if ($(this).hasClass('is_update')) {
            if (multiple_seat_array.includes(seatNumber)) {
                removeAddBookingForms(seatNumber)
                const index = multiple_seat_array.indexOf(seatNumber);
                if (index > -1) {
                    multiple_seat_array.splice(index, 1);
                }
                if (multiple_seat_array.length === 0) {
                    $('#submit_part').addClass('d-none')
                }
                $(this).removeClass('multiple_selected');
            } else {
                getAddBookingForms(seatNumber, true)
                multiple_seat_array.push(seatNumber);
                $(this).addClass('multiple_selected');
            }
        } else {
            notificationToast(this_seat_is_not_booked, 'warning')
        }
    }
})

$(document).on('click', '.blocked_seat', function () {
    if (!($(this).hasClass('book-seat'))) {
        notificationToast(this_seat_is_blocked, 'warning')
    }
})

$(document).on('change', '#region_id', function () {
    $('.region_price').addClass('d-none')
    $('#region_price_id_' + $(this).val()).removeClass('d-none')
})

$(document).on('change', '#return_region_id', function () {
    $('.return_region_price').addClass('d-none')
    $('#return_region_price_id_' + $(this).val()).removeClass('d-none')
})
$(document).on('change', '#travel_date', function () {
    var route_id = $('#route_id').val()
    var trip_id = $("#trip_id").val();
    var return_ticket = $("#return_ticket").val();
    var travel_date = $('#travel_date').val()
    if (route_id && trip_id && travel_date) {
        getSeatings(route_id, trip_id, travel_date)
    }
    if (route_id && trip_id == null && $('#trip_id').prop('disabled')) {
        getSeatings(route_id, 0, travel_date)
    }
})

$(document).on('change', '#return_travel_date', function () {
    var route_id = $('#return_route_id').val()
    var trip_id = $("#return_trip_id").val();
    var travel_date = $('#return_travel_date').val()
    if (route_id && trip_id && travel_date) {
        getSeatings(route_id, trip_id, travel_date, 1)
    }
    if (route_id && trip_id == null && $('#return_trip_id').prop('disabled')) {
        getSeatings(route_id, 0, travel_date, 1)
    }
})
$(document).on('change', '#route_id', function () {
    var route_id = $(this).val()
    var travel_date = $('#travel_date').val()
    // trip_id_choices_element
    // trip_id_choices_element.disable();
    // trip_id_choices_element.clearStore();
    $('#region_1_charge').val(0)
    $('#region_2_charge').val(0)
    $('#region_1_charge_below_10').val(0)
    $('#region_2_charge_below_10').val(0)
    $('#seats_render').addClass('d-none')
    $('#seats_render').html('')
    $('#add_booking_form').html('')
    $('#return_ticket_data').addClass('d-none')
    $('#return_seats_render').html("")
    if (route_id === '') {
        return
    }
    tripRender(route_id, trip_id_choices_element, travel_date)

})

$(document).on('change', '#return_route_id', function () {
    var route_id = $(this).val()
    var travel_date = $('#return_travel_date').val()
    // trip_id_choices_element
    // trip_id_choices_element.disable();
    // trip_id_choices_element.clearStore();
    $('#return_region_1_charge').val(0)
    $('#return_region_2_charge').val(0)
    $('#return_seats_render').addClass('d-none')
    $('#return_seats_render').html('')
    // $('#add_booking_form').html('')
    if (route_id === '') {
        return
    }
    tripRender(route_id, return_trip_id_choices_element, travel_date)
})

$(document).on('change', '#store_data_temp', function () {
    var value = $(this).is(':checked') ? 1 : 0;
    if (value === 1) {
        var seat = $(this).data('seat');
        let $form = $('#booking_add_form')
        let formData = new FormData($form[0])
        formData.append('seat_number_selected', seat)
        axios
            .post(APP_URL + temp_store_data, formData)
            .then(function (response) {
            })
            .catch(function (error) {
                console.log(error)
                loaderHide()
            })
    }
})

$(document).on('change', '#return_ticket', function () {
    var value = $(this).is(':checked') ? 1 : 0;
    if (value === 1) {
        $('#available_seats_render').html('')
        const checkbox = $('#block_unblock_seat');
        if (checkbox.prop('checked')) {
            checkbox.prop('checked', !checkbox.prop('checked'));
            $('#submit_part').addClass('d-none')
            multiple_seat_array.length = 0;
            $('.book-seat').removeClass('multiple_selected');
        }
        const checkbox2 = $('#print_ticket');
        if (checkbox2.prop('checked')) {
            checkbox2.prop('checked', !checkbox2.prop('checked'));
            $('#submit_part').addClass('d-none')
            multiple_seat_array.length = 0;
            $('.book-seat').removeClass('multiple_selected');
        }
        const checkbox3 = $('#update_seats');
        if (checkbox3.prop('checked')) {
            checkbox3.prop('checked', !checkbox3.prop('checked'));
            $('#submit_part').addClass('d-none')
            multiple_seat_array.length = 0;
            $('.book-seat').removeClass('multiple_selected');
        }
        const checkbox4 = $('#block_unblock_seat');
        if (checkbox4.prop('checked')) {
            checkbox4.prop('checked', !checkbox4.prop('checked'));
            $('#submit_part').addClass('d-none')
            multiple_seat_array.length = 0;
            $('.book-seat').removeClass('multiple_selected');
        }
        $('#book_seat').addClass('d-none');
        setSeatDataName('update_seats', 'add_seats')
        setSeatDataName('block_unblock_seat', 'add_seats')
        setSeatDataName('print_ticket', 'add_seats')
        $('#is_return_ticket').val('on')
        $('#return_ticket_data').removeClass('d-none')
        var route_id = $('#route_id').val()
        var travel_date = $('#travel_date').val()
        returnRoutes(route_id, return_route_id_choices_element, travel_date)
    } else {
        clearReturnForm()
        $('#is_return_ticket').val('off')
        $('#is_international').val(is_main_international)
        $('#return_ticket_data').addClass('d-none')
        $('#return_seats_render').html("")
    }
})


$(document).on('change', '#print_ticket', function () {
    $('#available_seats_render').html('')

    $('#submit_part').addClass('d-none')
    var value = $(this).is(':checked') ? 1 : 0;
    multiple_seat_array.length = 0;
    $('.book-seat').removeClass('multiple_selected');

    const checkbox = $('#block_unblock_seat');
    if (checkbox.prop('checked')) {
        checkbox.prop('checked', !checkbox.prop('checked'));
        setSeatDataName('block_unblock_seat', 'add_seats')
    }

    const checkbox2 = $('#update_seats');
    if (checkbox2.prop('checked')) {
        checkbox2.prop('checked', !checkbox2.prop('checked'));
        setSeatDataName('update_seats', 'add_seats')
    }

    if (value === 1) {
        clearReturnForm()
        $('#book_seat').removeClass('d-none');
        setSeatDataName('add_seats', 'print_ticket')
    } else {
        $('#book_seat').addClass('d-none');
        setSeatDataName('print_ticket', 'add_seats')
        setSeatDataName('block_unblock_seat', 'add_seats')
        setSeatDataName('update_seats', 'add_seats')
    }

})
$(document).on('change', '#update_seats', function () {
    $('#available_seats_render').html('')
    $('#submit_part').addClass('d-none')

    var value = $(this).is(':checked') ? 1 : 0;
    multiple_seat_array.length = 0;
    $('.book-seat').removeClass('multiple_selected');

    const checkbox = $('#block_unblock_seat');
    if (checkbox.prop('checked')) {
        checkbox.prop('checked', !checkbox.prop('checked'));
        setSeatDataName('block_unblock_seat', 'add_seats')
    }

    const checkbox2 = $('#print_ticket');
    if (checkbox2.prop('checked')) {
        checkbox2.prop('checked', !checkbox2.prop('checked'));
        setSeatDataName('print_ticket', 'add_seats')
    }

    if (value === 1) {
        $('#book_seat').removeClass('d-none');
        setSeatDataName('add_seats', 'update_seats')
        clearReturnForm()
    } else {
        $('#book_seat').addClass('d-none');
        setSeatDataName('update_seats', 'add_seats')
        setSeatDataName('block_unblock_seat', 'add_seats')
        setSeatDataName('print_ticket', 'add_seats')
    }
})

$(document).on('change', '#block_unblock_seat', function () {
    $('#available_seats_render').html('')

    $('#submit_part').removeClass('d-none')

    var value = $(this).is(':checked') ? 1 : 0;
    multiple_seat_array.length = 0;
    $('.book-seat').removeClass('multiple_selected');

    const checkbox = $('#update_seats');
    if (checkbox.prop('checked')) {
        checkbox.prop('checked', !checkbox.prop('checked'));
        $('#book_seat').addClass('d-none');
        setSeatDataName('update_seats', 'add_seats')
    }

    const checkbox2 = $('#print_ticket');
    if (checkbox2.prop('checked')) {
        checkbox2.prop('checked', !checkbox2.prop('checked'));
        setSeatDataName('print_ticket', 'add_seats')
    }

    if (value === 1) {
        clearReturnForm()
        $('#book_seat').removeClass('d-none');
        setSeatDataName('add_seats', 'block_unblock_seat')
    } else {
        $('#book_seat').addClass('d-none');
        setSeatDataName('update_seats', 'add_seats')
        setSeatDataName('block_unblock_seat', 'add_seats')
        setSeatDataName('print_ticket', 'add_seats')
    }
})

$(document).on('change', '#trip_id', function () {
    var sub_route_id = $(this).val()
    var route_id = $('#route_id').val()
    var travel_date = $('#travel_date').val()
    $('#seats_render').addClass('d-none')
    $('#seats_render').html('')
    $('#region_1_charge').val(0)
    $('#region_2_charge').val(0)
    $('#region_1_charge_below_10').val(0)
    $('#region_2_charge_below_10').val(0)
    if (sub_route_id && route_id && travel_date) {
        getSeatings(route_id, sub_route_id, travel_date)
    } else {
        notificationToast(please_fill_all_filed, 'warning')
    }
})

$(document).on('change', '#return_trip_id', function () {
    var sub_route_id = $(this).val()
    var route_id = $('#return_route_id').val()
    var travel_date = $('#return_travel_date').val()
    $('#return_seats_render').addClass('d-none')
    $('#return_seats_render').html('')
    $('#return_region_1_charge').val(0)
    $('#return_region_2_charge').val(0)
    $('#return_region_1_charge_below_10').val(0)
    $('#return_region_2_charge_below_10').val(0)
    if (sub_route_id && route_id && travel_date) {
        getSeatings(route_id, sub_route_id, travel_date, 1)
    } else {
        notificationToast(please_fill_all_filed, 'warning')
    }
})

$(document).on('click', '#select_bookings', function () {
    const checkboxes = document.getElementsByName('booking_ids[]');
    const selectedValues = [];
    for (let i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            selectedValues.push(checkboxes[i].value);
        }
    }
    printTicket(selectedValues)
})
$(document).on('click', '#additional_seats', function () {
    $('#available_seats_render').html('')
    $('#main_seats_table').toggleClass('d-none');
    $('#additional_seats_table').toggleClass('d-none');
})

$(document).on('click', '#additional_seats_render', function () {
    $('#main_seats_table_render').toggleClass('d-none');
    $('#additional_seats_table_render').toggleClass('d-none');
})

$(document).on('change', '#update_dob', function () {
    const currentDate = new Date();
    var dateOfBirth = $(this).val();
    var date = new Date(dateOfBirth);
    var age = currentDate.getFullYear() - date.getFullYear();
    if (currentDate < new Date(date.setFullYear(currentDate.getFullYear()))) {
        age--;
    }
    $('#age_update').val(age)
})

$('#viewBookingModal').on('hide.bs.modal', function () {
    $('#viewBookingModalBody').html('')
    modelReset()
});

$('#ticket_print_modal').on('hide.bs.modal', function () {
    $('#ticket_print_modal_body').html('')
});

$(document).on('change', '.passport_exp', function () {
    const dateValue = $(this).val();
    const formattedDate = moment(dateValue, 'DD/MM/YYYY').format('DD/MM/YYYY');
    $(this).val(formattedDate);
})
$(document).on('change', '.national_exp', function () {
    const dateValue = $(this).val();
    const formattedDate = moment(dateValue, 'DD/MM/YYYY').format('DD/MM/YYYY');
    $(this).val(formattedDate);
})
$(document).on('change', '.dob', function () {
    const dateValue = $(this).val();
    const formattedDate = moment(dateValue, 'DD/MM/YYYY').format('DD/MM/YYYY');
    $(this).val(formattedDate);
})

$(document).on('click', '#print_booking', function () {
    printTicket([$('.edit_value').val()])
})
$('#booking_update_modal').on('hidden.bs.modal', function (e) {
    $('#booking_update_modal_body').html('')
})
//Travel Date Update

let route_id_date_change = new Choices(document.querySelector('#route_id_date_change'), {
    maxItemCount: Infinity
});
let trip_id_date_change = new Choices(document.querySelector('#trip_id_date_change'), {
    shouldSort: false,
    searchPlaceholderValue: 'Select a trip ID',
    itemSelectText: '',
    maxItemCount: Infinity
});

$(document).on('click', '#change_travel_date', function () {
    var booking_id = $(this).data('id');
    loaderView()
    // route_id_date_change.setChoiceByValue('');
    // trip_id_date_change.setChoiceByValue('');
    $('#update_travel_date_input').val('')
    $('#update_travel_date_modal').modal('show');
    $('#old_booking_id').val(booking_id);
    $('#update_travel_date_input').flatpickr({
        minDate: 'today',
        dateFormat: 'd/m/Y',
    })
    axios
        .get(APP_URL + form_url + '/' + booking_id)
        .then(function (response) {
            var booking_details = response.data.booking_details
            console.log(booking_details)
            console.log("setChoiceByValue(\'" + booking_details.route_id + "\')")
            route_id_date_change.setChoiceByValue(booking_details.route_id.toString())
            if (booking_details.sub_route_id === 0) {
                trip_id_date_change
                trip_id_date_change.disable();
                trip_id_date_change.clearStore();
            } else {
                tripRender(booking_details.route_id, trip_id_date_change, $('#travel_date').val())
                    .then(function () {
                        console.log(booking_details.sub_route_id.toString() + ' After Function');
                        trip_id_date_change.setChoiceByValue(booking_details.sub_route_id)
                        loaderHide();
                    })
                    .catch(function (error) {
                        console.log(error);
                        loaderHide();
                    });
            }
            loaderHide()

        })
        .catch(function (error) {
            console.log(error)
            loaderHide()
            notificationToast(error.response.data.message, 'warning')
        })
})

$(document).on('click', '#get_available_seats', function () {
    var route_id = $('#route_id_date_change').val();
    var sub_route_id = $('#trip_id_date_change').val();
    var travel_date = $('#update_travel_date_input').val()
    var old_booking_id = $('#old_booking_id').val();
    loaderView()
    $('#available_seats_render').html('')
    axios
        .post(APP_URL + get_route_seating_url, {
            'route_id': route_id,
            'sub_route_id': sub_route_id,
            'travel_date': travel_date,
            'is_update_seatings': true,
            'old_booking_id': old_booking_id,
        })
        .then(function (response) {
            $('#available_seats_render').html(response.data.view)
            $('#available_seats_render').removeClass('d-none')
            $('#update_travel_date_modal').modal('hide');
            loaderHide()
        })
        .catch(function (error) {
            console.log(error)
            loaderHide()
            notificationToast(error.response.data.message, 'warning')
        })
})

$(document).on('click', '.update-seat', function () {
    let seatNumber = $(this).data('seat-number');
    var returnTicketIsChecked = $('#return_ticket').prop('checked');

    if ($(this).hasClass('booked_seats')) {
        notificationToast(this_seat_already_booked, 'warning')
    } else {
        if (!returnTicketIsChecked) {
            Swal.fire({
                title: are_you_sure,
                text: you_dont_change_this_again,
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
                    chageDate($('#old_booking_id').val(), $('#update_travel_date_input').val(), seatNumber, $('#route_id_date_change').val(), $('#trip_id_date_change').val());
                }
            }))
        } else {
            if (returnSeatArray.includes(seatNumber)) {
                const index = returnSeatArray.indexOf(seatNumber);
                if (index > -1) {
                    returnSeatArray.splice(index, 1);
                }
                $('#return_seat_number_' + seatNumber).remove()
                $(this).removeClass('multiple_selected');
            } else {
                returnSeatArray.push(seatNumber);
                $(this).addClass('multiple_selected');
                var formElement = document.getElementById('booking_add_form');
                var newInput = document.createElement('input');
                newInput.type = 'hidden';
                newInput.name = 'return_seat_number[]';
                newInput.id = 'return_seat_number_' + seatNumber;
                newInput.value = seatNumber;
                newInput.className = 'return_seat_number';
                formElement.appendChild(newInput);
            }
            console.log(returnSeatArray)
            console.log($('#return_seat_number').val())
        }
    }
})

$(document).on('change', '#route_id_date_change', function () {
    var route_id = $(this).val()
    var travel_date = $('#travel_date').val()
    trip_id_date_change
    trip_id_date_change.disable();
    trip_id_date_change.clearStore();
    $('#available_seats_render').html('')
    if (route_id === '') {
        return
    }
    loaderView()
    axios
        .post(APP_URL + get_sub_route_url + route_id)
        .then(function (response) {
            var trips = response.data.trips;
            if (trips.length > 0) {
                const choicesOptions = [
                    {value: '', label: select_trip, selected: true, disabled: true}
                ];
                trips.forEach(function (value) {
                    choicesOptions.push({
                        value: value.id,
                        label: value.start_location_name + ' - ' + value.end_location_name
                    });
                });
                trip_id_date_change.setChoices(choicesOptions, 'value', 'label', {sorting: false});
                trip_id_date_change.enable();
            }
            loaderHide()
        })
        .catch(function (error) {
            console.log(error)
            loaderHide()
            notificationToast(error.response.data.message, 'warning')
        })
})
$('#booking_update_modal').on('show.bs.modal', function (e) {
    document.activeElement.blur()
})

//AutoComplete
$('#booking_search').autocomplete({
    delay: 0,
    minLength: 0,
    appendTo: "#autocomplete-suggestions",
    source: function (request, response) {
        if (!hasWhiteSpace($("#booking_search").val())) {
            return false;
        } else if ($('#booking_search').val() != '') {
            var data = {};
            data.travel_date = $("#travel_date").val();
            data.search_value = $('#booking_search').val().trim();
            axios
                .post(APP_URL + booking_search, {'search_value': $('#booking_search').val().trim()})
                .then(function (data) {
                    response($.map(data.data.bookings, function (item) {
                        return ({
                            ColCount: 'FIVEBOOKING',
                            name: item.first_name + ' ' + item.last_name,
                            route_name: item.route_name,
                            contact: item.contact,
                            passport_no: item.passport_no,
                            national_no: item.national_no,
                            booking_id: item.id,
                            travel_date: item.travel_date,
                            seat_number: item.seat_number,
                            headers: ["Customer Name", "Route", "Contact No", "Travel Date", "Passport", "NationalId"]
                        })
                    }));
                }).catch(function (error) {
                console.log(error)
                loaderHide()
                notificationToast(error.response.data.message, 'warning')
            })
        }
    },
    autoFocus: true,
    select: function (event, ui) {
        $(this).val(ui.item.name);
        getUpdateBookingModal(ui.item.booking_id)
    },
}).data("ui-autocomplete")._renderItem = function (ul, item) {
    var table = document.createElement('table');
    table.className = 'tblautocomplete ui-menu-item-wrapper table mb-0';
    table.id = 'ui-id-8';
    table.tabIndex = '-1';

    var tbody = document.createElement('tbody');
    table.appendChild(tbody);

    var tr = document.createElement('tr');
    tbody.appendChild(tr);

    var headers = item.headers;
    var data = [
        item.name ? item.name : "-",
        item.route_name ? item.route_name : "-",
        item.contact ? item.contact : "-",
        item.travel_date ? item.travel_date : "-",
        item.passport_no ? item.passport_no : "-",
        item.national_no ? item.national_no : "-"
    ];

    for (var i = 0; i < headers.length; i++) {
        var td = document.createElement('td');
        td.setAttribute('data-em-header', headers[i]);
        // td.style.border = '1px solid rgb(214, 217, 219)';
        if (i === 0) {
            td.innerHTML = '&nbsp;' + data[i];
        } else if (i === 1) {
            td.innerHTML = '&nbsp;' + data[i];
        } else if (i === 2) {
            td.innerHTML = '&nbsp;' + data[i];
        } else if (i === 3) {
            td.innerHTML = '&nbsp;' + data[i];
        } else if (i === 4) {
            td.innerHTML = '&nbsp;' + data[i];
        }
        tr.appendChild(td);
    }
    return $("<li>")
        .append(table)
        .appendTo(ul);
};

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    let $form = $('#booking_add_form')
    $(document).on('click', '#form_submit', function (e) {
        // $form.on('submit', function (e) {
        var sub_route_id = $('#trip_id').val()
        var route_id = $('#route_id').val()
        var travel_date = $('#travel_date').val()
        e.preventDefault()
        if ($("#block_unblock_seat").is(":checked")) {
            blockUnlockseat(travel_date, route_id, sub_route_id, block_unblock_object)
        } else {
            loaderView()
            let formData = new FormData($form[0])
            axios
                .post(APP_URL + form_url, formData)
                .then(function (response) {
                    if (response.data.success) {
                        getSeatings(route_id, sub_route_id, travel_date)
                        loaderHide()
                        notificationToast(response.data.message, 'success')
                        if (response.data.is_update === 0) {
                            var printWindow = window.open("", "", "width=2500,height=2500");
                            printWindow.document.write(response.data.print_preview);
                            printWindow.document.close();
                            printWindow.onload = function () {
                                printWindow.print();
                            };
                        }
                        $('#booking_update_modal').modal('hide')
                    } else {
                        if (response.data.timing_error) {
                            notificationToast(response.data.message, 'warning')
                        }
                        getSeatings(route_id, sub_route_id, travel_date)
                        loaderHide()
                    }
                    clearReturnForm()
                })
                .catch(function (error) {
                    console.log(error)
                    notificationToast(error.response.data.message, 'warning')
                    loaderHide()
                })
        }
    })
})

function getSeatings(route_id, sub_route_id, travel_date, is_return = 0) {
    loaderView()
    let is_update_seatings = false
    if (is_return === 0) {
        $('#add_booking_form').html('');
        $('#available_seats_render').html('')
        $('#return_ticket_data').addClass('d-none')
        $('#return_seats_render').html("")
    } else {
        $('#return_seats_render').html("")
        is_update_seatings = true
    }
    var unique_timestamp = $('#unique_timestamp').val()

    axios
        .post(APP_URL + get_route_seating_url, {
            'route_id': route_id,
            'sub_route_id': sub_route_id,
            'travel_date': travel_date,
            'is_update_seatings': is_update_seatings,
            'unique_timestamp': unique_timestamp,
        })
        .then(function (response) {
            var route_charges = response.data.route_charges;
            var agent_route = response.data.agent_route;
            if (response.data.isTimeOver) {
                is_past = 1;
            } else {
                is_past = 0;
            }
            $('#is_international').val(response.data.is_international)
            console.log(response.data.is_max_count)
            if (response.data.is_max_count) {
                $('#is_max_count').val(1)
            } else {
                $('#is_max_count').val(0)
            }

            if (is_return === 0) {
                if (is_agent === "1") {
                    $('#region_1_charge').val(agent_route.omr_price)
                    $('#region_2_charge').val(agent_route.aed_price)
                    $('#region_1_charge_below_10').val(agent_route.omr_price)
                    $('#region_2_charge_below_10').val(agent_route.aed_price)
                } else {
                    $('#region_1_charge').val(route_charges.region_1_charge)
                    $('#region_2_charge').val(route_charges.region_2_charge)
                    $('#region_1_charge_below_10').val(route_charges.region_1_charge_below_10)
                    $('#region_2_charge_below_10').val(route_charges.region_2_charge_below_10)
                }
                // $('#region_1_charge').val(route_charges.region_1_charge)
                // $('#region_2_charge').val(route_charges.region_2_charge)
                // $('#region_1_charge_below_10').val(route_charges.region_1_charge_below_10)
                // $('#region_2_charge_below_10').val(route_charges.region_2_charge_below_10)
                $('#seats_render').html(response.data.view)
                $('#seats_render').removeClass('d-none')
                multiple_seat_array = [];
                unblock_id_array = [];
                block_unblock_object = {};
                is_main_international = response.data.is_international
            } else {
                $('#return_region_1_charge').val(route_charges.region_1_charge)
                $('#return_region_2_charge').val(route_charges.region_2_charge)
                $('#return_region_1_charge_below_10').val(route_charges.region_1_charge_below_10)
                $('#return_region_2_charge_below_10').val(route_charges.region_2_charge_below_10)
                $('#return_seats_render').html(response.data.view)
                $('#return_seats_render').removeClass('d-none')
                is_retun_international = response.data.is_international
            }
            loaderHide()
        })
        .catch(function (error) {
            console.log(error)
            loaderHide()
            // notificationToast(error.response.data.message, 'warning')
        })
}

function modelReset() {
    $('#seat_number').val('')
    $('#first_name').val('')
    $('#last_name').val('')
    $('#dob').val('')
    $('#age').val('')
    $('#contact').val('')
    nationality_choices_element.removeActiveItems()
    gender_choices_element.setValue('')
    $('#email').val('')
    $('#passport_no').val('')
    $('#national_no').val('')
    $('#passport_exp').val('')
    $('#national_exp').val('')
    $('#remarks').val('')
}

function getbookintg(seatNumber) {
    loaderView()
    var sub_route_id = $('#trip_id').val()
    var route_id = $('#route_id').val()
    var travel_date = $('#travel_date').val()
    var old_region_1_charge = $('#region_1_charge').val()
    var old_region_2_charge = $('#region_2_charge').val()
    axios
        .get(APP_URL + form_url + '/' + seatNumber)
        .then(function (response) {
            $('#viewBookingModalBody').html(response.data.view)
            $('.region_1_charge').val(old_region_1_charge)
            $('.region_2_charge').val(old_region_2_charge)
            $('#viewBookingModal').modal('show');
            $('#update_dob').flatpickr({
                minDate: "1992-01-01",
                dateFormat: 'Y-m-d',
                maxDate: 'today',
            })
            loaderHide()

        })
        .catch(function (error) {
            console.log(error)
            loaderHide()
            notificationToast(error.response.data.message, 'warning')
        })
}

function handleKeyPress(event) {
    if (event.keyCode === 13) {
        event.preventDefault(); // Prevent the default Enter key behavior (e.g., form submission)
        document.getElementById("print_booking").click(); // Trigger the button click event
    }
}

function gendercheck(seat_number) {
    var gender = $('#gender\\[' + seat_number + '\\]').val()
    if ($('#seat_number\\[' + seat_number + '\\]').val() <= 16 && (gender === 'male' || gender === 'other')) {
        gender_choices_element[seat_number].setChoiceByValue('');
        return notificationToast('Please select other seat this seat is for family or female', 'warning')
    }
}

function getAddBookingForms(seat_number, is_update) {
    loaderView()
    var travel_date = $('#travel_date').val()
    var route_id = $('#route_id').val()
    var trip_id = $('#trip_id').val()
    var unique_timestamp = $('#unique_timestamp').val()
    axios
        .post(APP_URL + get_booking_add_form, {
            'seat_number': seat_number,
            'is_update': is_update,
            'route_id': route_id,
            'travel_date': travel_date,
            'trip_id': trip_id,
            'unique_timestamp': unique_timestamp,
        })
        .then(function (response) {
            console.log(response.data.is_max_count)
            if (response.data.is_max_count) {
                $('#is_max_count').val(1)
            } else {
                $('#is_max_count').val(0)
            }
            $('#add_booking_form').append(response.data.view)
            if (is_update) {
                if (is_admin == '1' && is_past == 0) {
                    removeReadOnly(response.data.booking_detail_ids)
                }
            } else {
                removeReadOnly(response.data.booking_detail_ids)
            }
            if (response.data.timing_error) {

            }
            $('#seat_number_' + seat_number).data("selected_no", response.data.booking_id);
            $('#seat_number_' + seat_number).attr("data-selected_no", response.data.booking_id);
            loaderHide()
        })
        .catch(function (error) {
            console.log(error)
            loaderHide()
            console.log(error.response.data)
            if (error.response.data.timing_error) {
                console.log('#seat_number_' + seat_number)
                $('#seat_number_' + seat_number).removeClass('multiple_selected');
                const index = multiple_seat_array.indexOf(seat_number);
                console.log(multiple_seat_array)
                if (index > -1) {
                    multiple_seat_array.splice(index, 1);
                }
                if (multiple_seat_array.length === 0) {
                    $('#submit_part').addClass('d-none')
                }
            }
            notificationToast(error.response.data.message, 'warning')
        })
}

function removeAddBookingForms(seat_number) {
    $('#is_max_count').val(0)
    $('.add_form_seat_number_' + seat_number).remove();
}

function setSeatDataName(old_name, new_name) {
    if (new_name === 'block_unblock_seat') {
        $('.blocked_seat').each(function () {
            $(this).addClass('book-seat');
        })
    }
    if (old_name === 'block_unblock_seat') {
        $('.blocked_seat').each(function () {
            $(this).removeClass('book-seat');
        })
    }
    $('.book-seat[data-name="' + old_name + '"]').each(function () {
        $(this).attr('data-name', new_name);
        $(this).data('name', new_name);
        removeAddBookingForms($(this).data('seat-number'))
    });
}

function printTicket(array) {
    loaderView()
    axios
        .post(APP_URL + get_print_booking, {'booking_ids': array})
        .then(function (response) {
            loaderHide()
            $('#ticket_print_modal').modal('hide')
            var printWindow = window.open("", "", "width=2500,height=2500");
            printWindow.document.write(response.data.print_preview);
            printWindow.document.close();
            printWindow.onload = function () {
                printWindow.print();
            };
        })
        .catch(function (error) {
            notificationToast(error.response.data.message, 'warning')
            loaderHide()
        })
}

function hasWhiteSpace(s) {
    const whitespaceChars = [' ', '\t', '\n'];
    return whitespaceChars.some(char => s.includes(char));
}

function getUpdateBookingModal(booking_id) {
    loaderView()
    axios
        .get(APP_URL + form_url + '/' + booking_id)
        .then(function (response) {
            $('#booking_update_modal_body').html(response.data.view)
            if (is_admin == '1') {
                removeReadOnly(response.data.seat_number)
            }

            $('#booking_update_modal').modal('show')
            console.log(document.activeElement)
            setTimeout(function () {
                $('#seat_number\\[' + booking_id + '\\]').focus();
                console.log(document.activeElement)
            }, 500);
            loaderHide()
        })
        .catch(function (error) {
            console.log(error)
            loaderHide()
            notificationToast(error.response.data.message, 'warning')
        })
}

function blockUnlockseat(travel_date, route_id, trip_id, block_unblock_values) {
    loaderView()
    axios
        .post(APP_URL + block_unblock_url, {
            travel_date: travel_date,
            route_id: route_id,
            trip_id: trip_id,
            block_unblock_object: block_unblock_values,
        })
        .then(function (response) {
            getSeatings(route_id, trip_id, travel_date)
            loaderHide()
            notificationToast(response.data.message, 'success')
        })
        .catch(function (error) {
            console.log(error)
            notificationToast(error.response.data.message, 'warning')
            loaderHide()
        })
}

function updateDOB(date, seat_number) {
    const currentDate = new Date();
    var formattedDate = parseDate(date);
    var age = currentDate.getFullYear() - formattedDate.getFullYear();
    if (currentDate < new Date(formattedDate.setFullYear(currentDate.getFullYear()))) {
        age--;
    }
    $('#age\\[' + seat_number + '\\]').val(age)
}

function parseDate(input) {
    var parts = input.split('/');
    if (parts.length === 3) {
        var day = parseInt(parts[0], 10);
        var month = parseInt(parts[1], 10) - 1;
        var year = parseInt(parts[2], 10);

        return new Date(year, month, day);
    }
    return null;
}

function removeReadOnly(seat_number) {
    $.each(seat_number, function (index, seat_number) {
        console.log('#first_name\\[' + seat_number + '\\]')
        $('#first_name\\[' + seat_number + '\\]').attr('readonly', false);
        $('#last_name\\[' + seat_number + '\\]').attr('readonly', false);
        $('#dob\\[' + seat_number + '\\]').attr('readonly', false);
        $('#contact\\[' + seat_number + '\\]').attr('readonly', false);
        $('#gender\\[' + seat_number + '\\]').attr('disabled', false);
        $('#nationality\\[' + seat_number + '\\]').attr('disabled', false);
        $('#nationality\\[' + seat_number + '\\]').attr('disabled', false);
        $('#passport_no\\[' + seat_number + '\\]').attr('readonly', false);
        $('#national_no\\[' + seat_number + '\\]').attr('readonly', false);
        $('#passport_exp\\[' + seat_number + '\\]').attr('readonly', false);
        $('#national_exp\\[' + seat_number + '\\]').attr('readonly', false);

        gender_choices_element[seat_number] = new Choices($('#gender\\[' + seat_number + '\\]')[0]);
        nationality_choices_element = new Choices($('#nationality\\[' + seat_number + '\\]')[0]);


        $('#passport_exp\\[' + seat_number + '\\]').daterangepicker({
            minDate: moment().toDate(),
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function (start, end, label) {
            $('#passport_exp\\[' + seat_number + '\\]').val(start.format('DD/MM/YYYY'));
        });

        $('#national_exp\\[' + seat_number + '\\]').daterangepicker({
            minDate: moment().toDate(),
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function (start, end, label) {
            // Update the input value with the selected date
            $('#national_exp\\[' + seat_number + '\\]').val(start.format('DD/MM/YYYY'));
        });

        $('#dob\\[' + seat_number + '\\]').daterangepicker({
            maxDate: moment().toDate(),
            singleDatePicker: true,
            showDropdowns: true,
            autoUpdateInput: false,
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function (start, end, label) {
            // Update the input value with the selected date
            $('#dob\\[' + seat_number + '\\]').val(start.format('DD/MM/YYYY'));
            console.log(seat_number);
            updateDOB(start.format('DD/MM/YYYY'), seat_number)
        });
    })
    $('#submit_part').removeClass('d-none')
}

function chageDate(oldBookingId, newTravelDate, seatNumber, newRoute, newTrip) {
    loaderView()
    axios
        .post(APP_URL + update_travel_date, {
            oldBookingId: oldBookingId,
            newTravelDate: newTravelDate,
            seatNumber: seatNumber,
            newRoute: newRoute,
            newTrip: newTrip,
        })
        .then(function (response) {
            printTicket([response.data.booking_id])
            getSeatings($('#route_id').val(), $('#trip_id').val(), $('#travel_date').val())
            loaderHide()
            notificationToast(response.data.message, 'success')
        })
        .catch(function (error) {
            console.log(error)
            loaderHide()
            notificationToast(error.response.data.message, 'warning')
        })
}

function tripRender(route_id, choices_element, travel_date) {
    return new Promise(function (resolve, reject) {

        choices_element
        choices_element.disable();
        choices_element.clearStore();
        loaderView()
        axios
            .post(APP_URL + get_sub_route_url + route_id)
            .then(function (response) {
                var trips = response.data.trips;
                if (trips.length > 0) {
                    const choicesOptions = [
                        {value: '', label: select_trip, selected: true, disabled: true}
                    ];
                    trips.forEach(function (value) {
                        choicesOptions.push({
                            value: value.id,
                            label: value.start_location_name + ' - ' + value.end_location_name
                        });
                    });
                    choices_element.setChoices(choicesOptions, 'value', 'label', {sorting: false});
                    choices_element.enable();
                    console.log('Inside Function')
                    resolve();
                } else {
                    getSeatings(route_id, 0, travel_date)
                }
                loaderHide()
            })
            .catch(function (error) {
                console.log(error)
                loaderHide()
                notificationToast(error.response.data.message, 'warning')
            })
    });
}

function returnRoutes(route_id, choices_element, travel_date) {
    return new Promise(function (resolve, reject) {

        choices_element
        choices_element.clearStore();
        choices_element.disable();

        loaderView()
        axios
            .post(APP_URL + get_route_url + route_id)
            .then(function (response) {

                var routes = response.data.routes;
                const choicesOptions = [
                    {value: '', label: select_route, selected: true, disabled: true}
                ];
                if (routes.length > 0) {
                    routes.forEach(function (value) {
                        choicesOptions.push({
                            value: value.id,
                            label: value.name + ' (' + value.start_location_name + ' - ' + value.end_location_name + ') - ' + value.formatted_route_time
                        });
                    });
                }
                choices_element.setChoices(choicesOptions, 'value', 'label', {sorting: false});
                choices_element.enable();
                console.log('Inside Function')
                resolve();
                loaderHide()

                // var routes = response.data.return_route_id;
                // choices_element.destroy()
                // const selectElement = document.getElementById('return_route_id');
                // selectElement.selectedIndex = -1;
                // document.querySelectorAll("#return_route_id option").forEach(opt => {
                //     opt.disabled = false;
                // });
                // if (routes.length > 0) {
                //     console.log(routes)
                //     document.querySelectorAll("#return_route_id option").forEach(opt => {
                //         if (opt.value === "") {
                //             opt.selected = true;
                //         }
                //         if (routes.includes(parseInt(opt.value))) {
                //             opt.disabled = false;
                //         } else {
                //             opt.disabled = true;
                //         }
                //     });
                //     console.log('Inside Function')
                // }
                // return_route_id_choices_element = new Choices(document.querySelector('#return_route_id'), {
                //     maxItemCount: Infinity,
                //     shouldSort: false
                // });
                // resolve();
                // loaderHide()
            })
            .catch(function (error) {
                console.log(error)
                loaderHide()
                notificationToast(error.response.data.message, 'warning')
            })
    });
}

function clearReturnForm() {
    var currentDate = new Date();
    $('#return_travel_date').flatpickr().setDate(currentDate, false, 'd/m/Y');
    $('#return_travel_date').flatpickr().set('dateFormat', 'd/m/Y');
    return_route_id_choices_element.setChoiceByValue("");
    return_trip_id_choices_element.clearStore();
    $('#return_region_1_charge').val(0)
    $('#return_region_2_charge').val(0)
    $('#return_region_1_charge_below_10').val(0)
    $('#return_region_2_charge_below_10').val(0)
    $('#return_seats_render').html("")
    $('.return_seat_number').remove();
    returnSeatArray = []
    $('#return_ticket_data').addClass('d-none')
    var return_ticket = $('#return_ticket')
    if (return_ticket.prop('checked')) {
        return_ticket.prop('checked', !return_ticket.prop('checked'));
    }
}

function disselectSeat(booking_id) {
    loaderView()
    axios
        .get(APP_URL + removeSelectedSeatUrl + '/' + booking_id)
        .then(function (response) {
            loaderHide()
        })
        .catch(function (error) {
            console.log(error)
            loaderHide()
        })
}
