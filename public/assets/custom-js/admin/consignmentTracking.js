// const sig = $('#sig').signature({syncField: '#signature64', syncFormat: 'PNG'});
let sig;
$('#enter_manually').change(function () {
    // Toggle the visibility of #cargo_label based on checkbox state
    if ($(this).is(':checked')) {
        $('#cargo_label').removeClass('d-none');
    } else {
        $('#cargo_label').addClass('d-none');
    }
});

function clearSignature() {
    sig.signature('clear');
    $('#signature64').val('');
}

// $(document).on('keyup', '#consignment_number', function () {
//     $(this).val($(this).val().toUpperCase());
// });

$(document).on('click', '#get_consignment_detail', function () {
    getConsigmentDetails()
})

$(document).on('click', '.change-status', function () {
    var item_id = $(this).data('id')
    var status = $(this).data('status')
    $('#enter_qty_modal_title').text('')
    $('#status').val(status)
    $('#item_id').val(item_id)
    if (status === 'transit') {
        $('#enter_qty_modal_title').text(transit_modal_qty_title)
    }
    if (status === 'delivered') {
        $('#enter_qty_modal_title').text(delivered_modal_qty_title)
    }
    $('#enter_qty_modal').modal('show')
})

let $qty_save_form = $('#qty_save_form')
$qty_save_form.on('submit', function (e) {
    e.preventDefault()
    loaderView()
    let formData = new FormData($qty_save_form[0])
    axios
        .post(APP_URL + form_url, formData)
        .then(function (response) {
            $('#enter_qty_modal').modal('hide')
            getConsigmentDetails()
            loaderHide()
            notificationToast(response.data.message, 'success')
        })
        .catch(function (error) {
            console.log(error)
            loaderHide()
            notificationToast(error.response.data.message, 'warning')
        })
})

let $signature_save_form = $('#signature_save_form')
$signature_save_form.on('submit', function (e) {
    e.preventDefault()
    loaderView()
    let formData = new FormData($signature_save_form[0])
    axios
        .post(APP_URL + signature_save_url, formData)
        .then(function (response) {
            $('#signature_modal').modal('hide')
            getConsigmentDetails()
            loaderHide()
            notificationToast(response.data.message, 'success')
        })
        .catch(function (error) {
            console.log(error)
            loaderHide()
            notificationToast(error.response.data.message, 'warning')
        })
})

$('#signature_modal').on('hidden.bs.modal', function () {
    // $('#sig').signature('destroy');
    $('#signature64').val('');
    $('#signature_consignment_id').val(0)
})

$(document).on('click', '.change-status-consignment', function () {
    captureFromSTU()
    // captureFromCanvas()
    // sig = $('#sig').signature({
    //     syncField: '#signature64',
    //     syncFormat: 'PNG'
    // });
    $('#signature64').val('');
    // $('#signature_modal').modal('show')
    $('#signature_consignment_id').val($(this).data('id'))
})
$(document).on('click', '.get-history', function () {
    var item_id = $(this).data('id')
    $('#status_history_modal_body').html("")
    loaderView()
    axios
        .get(APP_URL + getHistoryURL + '/' + item_id)
        .then(function (response) {
            $('#status_history_modal_body').html(response.data.data)
            $('#status_history_modal').modal('show');
            loaderHide()
        })
        .catch(function (error) {
            console.log(error)
            notificationToast(error.response.data.message, 'warning')
            loaderHide()
        })
})

$("#consignment_number").on("propertychange change paste input", function () {
    if (!($("#enter_manually").is(":checked"))) {
        // interval = setTimeout(function () {
        //     console.log($(this).val())
        //     // getConsigmentDetails()
        // }, 1000)
        timeoutId = setTimeout(getConsigmentDetails, 1000);
       // getConsigmentDetails()
    }
});

$('#enter_qty_modal').on('hidden.bs.modal', function () {
    $('#qty').val('')
})

function getConsigmentDetails() {
    var consignment_number = $('#consignment_number').val()
    if (consignment_number === "") {
        return false;
    }
    $('#render_details').html("")
    loaderView()
    axios
        .get(APP_URL + form_url + '/' + consignment_number)
        .then(function (response) {
            // clearTimeout(timeoutId);
            $('#render_details').html(response.data.data)
            loaderHide()
        })
        .catch(function (error) {
            console.log(error)
            notificationToast(error.response.data.message, 'warning')
            loaderHide()
        })
}