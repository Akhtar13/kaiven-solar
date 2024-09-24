const sender_depot_select =new Choices(document.querySelector('#sender_depot'), {
    maxItemCount: Infinity,
    shouldSort: false
});


$(document).ready(function ($) {
    let $add_consignment_form = $('#add_consignment_form')
    $(document).on('click', '#consignment_form_submit', function (e) {
        var itemName = $('#add_item_name').val();
        var consignmentQty = $('#add_consignment_qty').val();
        var consignmentWeight = $('#add_consignment_weight').val();
        var consignmentPrice = $('#add_consignment_price').val();
        if (itemName == '' || consignmentQty == '' || consignmentWeight == '' || ($('.payment_status:checked').val() != 'foc' && consignmentPrice == '')) {
            notificationToast(please_enter_all_details, 'warning')
            return false
        }
        consignmentPrice = (consignmentPrice === '') ? '0' : consignmentPrice;

        var newRow = `
        <tr>
            <td class="index-column">1</td>
            <td>
                <input type="hidden" name="item_name[]" value="${itemName}">
                ${itemName}
            </td>
            <td>
                <input type="hidden" name="consignment_qty[]" value="${consignmentQty}">
                ${consignmentQty}
            </td>
            <td>
                <input type="hidden" name="consignment_weight[]" value="${consignmentWeight}">
                ${consignmentWeight}
            </td>
            <td>
                <input type="hidden" name="consignment_price[]" class="consignment_price" value="${consignmentPrice}">
                ${consignmentPrice}
            </td>
            <td class="small-column">
                <button type="button" data-id="1" class="delete-row-btn btn btn-sm btn-danger"
                        data-toggle="tooltip" data-placement="top" title="Delete">
                    <i class="ri-delete-bin-6-line"></i>
                </button>
            </td>
        </tr>
    `;

        // Insert the new row before the existing tbody
        $('#consignment_table tbody').prepend(newRow);

        // Update index column numbers
        $('#consignment_table tbody tr').each(function (index) {
            $(this).find('.index-column').text(index + 1);
        });

        // Calculate and update the grand total
        var grandTotal = 0;
        $('#consignment_table tbody tr').each(function () {
            var price = parseFloat($(this).find('[name="consignment_price[]"]').val());
            grandTotal += isNaN(price) ? 0 : price;
        });
        $('#grand_total_cell').text(currency + ' ' + grandTotal.toFixed(2));
        $('#add_item_name').val('')
        $('#add_consignment_qty').val('')
        $('#add_consignment_weight').val('')
        $('#add_consignment_price').val('')
        $("#add_item_name").focus();
    })
})

$(document).on('click', '.delete-row-btn', function () {
    var row = $(this).closest('tr');
    var price = parseFloat(row.find('[name="consignment_price[]"]').val());
    row.remove();
    $('#consignment_table tbody tr').each(function (index) {
        $(this).find('.index-column').text(index + 1);
    });
    var grandTotal = parseFloat($('#grand_total_cell').text().replace(currency + ' ', ''));
    grandTotal -= isNaN(price) ? 0 : price;
    $('#grand_total_cell').text(currency + ' ' + grandTotal.toFixed(2));
});

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    let $form = $('#consignmentAddEditForm')
    $form.on('submit', function (e) {
        e.preventDefault()
        // $form.parsley().validate()
        // if ($form.parsley().isValid()) {
        loaderView()
        let formData = new FormData($form[0])
        axios
            .post(APP_URL + form_url, formData)
            .then(function (response) {
                $form[0].reset()
                var printWindow = window.open("", "", "width=2500,height=2500");
                printWindow.document.write(response.data.print_preview);
                printWindow.document.close();
                printWindow.onload = function () {
                    printWindow.print();
                };
                setTimeout(function () {
                    window.location.reload()
                    loaderHide()
                }, 1000)
                loaderHide()
                notificationToast(response.data.message, 'success')
            })
            .catch(function (error) {
                notificationToast(error.response.data.message, 'warning')
                loaderHide()
            })
        // }
    })
})

$('input[name="payment_status"]').change(function () {
    var selectedValue = $(this).val();
    $('#add_consignment_price').val("")
    if (selectedValue === 'foc') {
        $('.consignment_price').parent().addClass('d-none')
        $('.consignment-price-header').addClass('d-none')
        $('#add_consignment_price').parent().parent().addClass('d-none')
    } else {
        $('.consignment_price').parent().removeClass('d-none')
        $('.consignment-price-header').removeClass('d-none')
        $('#add_consignment_price').parent().parent().removeClass('d-none')
    }
})
function hasWhiteSpace(s) {
    const whitespaceChars = [' ', '\t', '\n'];
    return whitespaceChars.some(char => s.includes(char));
}
//AutoComplete
$('#consignment_search').autocomplete({
    delay: 0,
    minLength: 0,
    appendTo: "#autocomplete-suggestions",
    source: function (request, response) {
        if (!hasWhiteSpace($("#consignment_search").val())) {
            return false;
        } else if ($('#consignment_search').val() != '') {
            var data = {};
            data.search_value = $('#consignment_search').val().trim();
            axios
                .post(APP_URL + consignmentAutocomplete, {'search_value': $('#consignment_search').val().trim()})
                .then(function (data) {
                    response($.map(data.data.consignments, function (item) {
                        return ({
                            ColCount: 'FOURCONSIGNMENTS',
                            sender_name: item.sender_name,
                            sender_contact: item.sender_contact,
                            sender_id_pass: item.sender_id_pass,
                            sender_depot_id: item.sender_depot_id,
                            sender_depot: item.sender_depot,
                            headers: ["Senders Name", "Senders Contact", "Senders ID/Passport", "Senders Depot"]
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
        // $(this).val(ui.item.name);
        console.log(ui.item)
        $('#sender_name').val(ui.item.sender_name)
        $('#sender_contact').val(ui.item.sender_contact)
        $('#sender_id_pass').val(ui.item.sender_id_pass)
        sender_depot_select.setChoiceByValue(ui.item.sender_depot_id.toString())

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
        item.sender_name ? item.sender_name : "-",
        item.sender_contact ? item.sender_contact : "-",
        item.sender_id_pass ? item.sender_id_pass : "-",
        item.sender_depot ? item.sender_depot : "-",
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