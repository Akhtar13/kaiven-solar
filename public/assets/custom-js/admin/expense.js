$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    let $form = $('#addEditForm')
    $form.on('submit', function (e) {
        e.preventDefault()
        loaderView()
        let formData = new FormData($form[0])
        axios
            .post(APP_URL + form_url, formData)
            .then(function (response) {
                if ($('#form-method').val() === 'add') {
                    $form[0].reset()
                }
                setTimeout(function () {
                    window.location.href = APP_URL + redirect_url
                    loaderHide()
                }, 1000)
                loaderHide()
                notificationToast(response.data.message, 'success')
            })
            .catch(function (error) {
                notificationToast(error.response.data.message, 'warning')
                loaderHide()
            })
    })
    $(document).on('change', '.expense_type', function () {
        let type = $(this).val()
        let row = $(this).data('row')
        if (type === "") {
            const selectElement = document.getElementById("expense_category_id_" + row);
            const firstOption = selectElement.options[0];
            while (selectElement.options.length > 1) {
                selectElement.remove(1);
            }
            selectElement.value = "";
            loaderHide()
            return false
        }
        getCategoryByType(type, row)
        // axios
        //     .get(APP_URL + '/get-expanse-category-by-type/' + type)
        //     .then(function (response) {
        //         $("#expense_category_id_" + row).html(response.data.data)
        //         loaderHide()
        //     })
        //     .catch(function (error) {
        //         notificationToast(error.response.data.message, 'warning')
        //         loaderHide()
        //     })
    })
})
$(document).on('keyup', ".item-quantity", function () {
    let row = $(this).data('row')
    updateTotalPrice(row)
    calc()
})
$(document).on('keyup', ".item-price", function () {
    let row = $(this).data('row')
    updateTotalPrice(row)
    calc()
})
document.addEventListener("DOMContentLoaded", function () {
    const fileInput = document.getElementById("medias");
    const previewDiv = document.getElementById("preview");
    fileInput.addEventListener("change", function () {
        previewDiv.innerHTML = '';
        for (const file of fileInput.files) {
            const fileContainer = document.createElement("div");
            fileContainer.className = "shadow me-2 image-area";
            if (file.type.startsWith("image/")) {
                const imgElement = document.createElement("img");
                imgElement.src = URL.createObjectURL(file);
                imgElement.style.maxWidth = "100%";
                imgElement.style.height = "100px";
                imgElement.style.width = "80px";
                const deleteIcon = document.createElement("i");
                deleteIcon.className = "fa fa-trash delete-icon";
                deleteIcon.addEventListener("click", function () {
                    previewDiv.removeChild(fileContainer);
                });
                fileContainer.appendChild(deleteIcon);
                fileContainer.appendChild(imgElement);
            } else if (file.type === "application/pdf") {
                const pdfImage = document.createElement("img");
                pdfImage.src = pdf_path;
                pdfImage.height = 100;
                pdfImage.width = 80;
                pdfImage.style.cursor = "pointer";
                pdfImage.addEventListener("click", function () {
                    window.open(URL.createObjectURL(file), "_blank");
                });
                const deleteIcon = document.createElement("i");
                deleteIcon.className = "fa fa-trash delete-icon";
                deleteIcon.addEventListener("click", function () {
                    previewDiv.removeChild(fileContainer);
                });
                fileContainer.appendChild(deleteIcon);
                fileContainer.appendChild(pdfImage);
            }
            previewDiv.appendChild(fileContainer);
        }
    });
});
$(document).on('click', '.remove-image', function () {
    var id = $(this).data('id');
    $(this).parent().remove();
    var hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'remove_image[]';
    hiddenInput.value = id;
    document.getElementById('addEditForm').appendChild(hiddenInput);
})

function calc() {
    let total = 0;
    $(".total_price").each(function () {
        if ($(this).val() != '') {
            total = parseFloat(total) + parseFloat($(this).val())
        }
    })
    $("#total").val(total)
    $("#total_text").text(total)
}

function updateTotalPrice(row) {
    let price = $('#price_' + row).val()
    let quantity = $('#quantity_' + row).val()
    console.log(price)
    console.log(quantity)
    if (price != '' && quantity != '') {
        let total_price = price * quantity;
        $("#total_price_" + row).val(total_price)
    }
}

function addRow() {
    const table = document.getElementById('expanse_item');
    const newRow = createTableRow(rowNo);
    table.appendChild(newRow);
    rowNo = rowNo + 1
}

function createTableRow(rowId) {
    const tr = document.createElement('tr');
    tr.id = `expanse_row_${rowId}`;

    const createInput = (name, placeholder, class_name = '') => {
        const td = document.createElement('td');
        const input = document.createElement('input');
        input.type = 'text';
        input.className = 'form-control ' + class_name;
        input.id = name + '_' + rowId;
        input.name = `${name}[${rowId}]`;
        input.placeholder = placeholder;
        input.setAttribute('data-row', rowId);
        td.appendChild(input);
        return td;
    };
    const createTypeSelect = (name, class_name = '') => {
        const td = document.createElement('td');
        const select = document.createElement('select');
        select.className = 'form-control ' + class_name;
        select.id = name + '_' + rowId;
        select.name = `${name}[${rowId}]`;
        select.setAttribute('data-row', rowId);

        const expenseTypeOption1 = document.createElement("option");
        expenseTypeOption1.value = "";
        expenseTypeOption1.textContent = select_expense_category_type;

        const expenseTypeOption2 = document.createElement("option");
        expenseTypeOption2.value = "direct";
        expenseTypeOption2.textContent = direct_title;

        const expenseTypeOption3 = document.createElement("option");
        expenseTypeOption3.value = "indirect";
        expenseTypeOption3.textContent = inDirect_title;

        select.appendChild(expenseTypeOption1);
        select.appendChild(expenseTypeOption2);
        select.appendChild(expenseTypeOption3);

        td.appendChild(select);
        return td;
    }

    const createCategorySelect = (name, class_name = '') => {
        const td = document.createElement('td');
        const select = document.createElement('select');
        select.className = 'form-control ' + class_name;
        select.id = name + '_' + rowId;
        select.name = `${name}[${rowId}]`;
        select.setAttribute('data-row', rowId);

        const expenseTypeOption1 = document.createElement("option");
        expenseTypeOption1.value = "";
        expenseTypeOption1.textContent = expense_category_title;

        select.appendChild(expenseTypeOption1);

        td.appendChild(select);
        return td;
    }

    tr.appendChild(createInput('item', item_title));
    tr.appendChild(createTypeSelect('expense_type', 'expense_type'));
    tr.appendChild(createCategorySelect('expense_category_id', 'expense_category_id'));
    tr.appendChild(createInput('description', description_title));
    tr.appendChild(createInput('quantity', quantity_title, 'item-quantity'));
    tr.appendChild(createInput('price', price_title, 'item-price'));

    const totalTd = document.createElement('td');
    const totalInput = document.createElement('input');
    totalInput.type = 'text';
    totalInput.className = 'form-control total_price bg-light float';
    totalInput.readOnly = true;
    totalInput.id = 'total_price_' + rowId;
    ;
    totalInput.name = `total_price[${rowId}]`;
    totalInput.placeholder = total_price_title;
    totalTd.appendChild(totalInput);
    tr.appendChild(totalTd);

    const actionTd = document.createElement('td');
    const addButton = document.createElement('button');
    addButton.type = 'button';
    addButton.className = 'btn btn-danger btn-sm';
    addButton.onclick = () => removeRow(rowId);
    addButton.innerHTML = '<i class="la la-minus"></i>';
    actionTd.appendChild(addButton);
    tr.appendChild(actionTd);

    return tr;
}

function removeRow(rowId) {
    $("#expanse_row_" + rowId).remove()
    calc()
}

function getCategoryByType(type, row, selected_id = 0) {
    loaderView()
    axios
        .get(APP_URL + '/get-expanse-category-by-type/' + type)
        .then(function (response) {
            $("#expense_category_id_" + row).html(response.data.data)
            if (selected_id !== 0) {
                $("#expense_category_id_" + row).val(selected_id)
            }
            loaderHide()
        })
        .catch(function (error) {
            notificationToast(error.response.data.message, 'warning')
            loaderHide()
        })
}
