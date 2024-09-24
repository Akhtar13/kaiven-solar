$(document).on('click', '.add_credit', function () {
    const value_id = $(this).data('id')

    console.log(value_id)
    loaderView()
    axios
        .get(APP_URL + '/add-credit-modal/' + value_id)
        .then(function (response) {
            console.log(response)
            $('#addCreditModal').modal('show')
            $('#agent_currency').html(response.data.user_agent.currency)
            $('#user_id').val(response.data.user_agent.user_id)
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
$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    let $form = $('#addCredit')
    $form.on('submit', function (e) {
        e.preventDefault()
        // $form.parsley().validate()
        // if ($form.parsley().isValid()) {
        loaderView()
        let formData = new FormData($form[0])
        axios
            .post(APP_URL + add_credit, formData)
            .then(function (response) {
                table.draw()
                notificationToast(response.data.message, 'success')
                $('#addCreditModal').modal('hide')
                loaderHide()
            })
            .catch(function (error) {
                notificationToast(error.response.data.message, 'warning')
                loaderHide()
            })
        // }
    })
})
$('#addCreditModal').on('hidden.bs.modal', function () {
    $('#addCredit')[ 0 ].reset()
    console.log('Modal is hidden');
});

