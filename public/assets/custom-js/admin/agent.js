$(document).on('change', '#region_id', function () {
    console.log($(this).val())
    region_id = $(this).val()
    var currency = $('#region_' + region_id + '_currency').val()
    $('#currency').val(currency)
    $('#agent_credit_currency').text(currency)
})

// $(document).on('change', '.route_id', function () {
//     let id = $(this).val()
//     let row = $(this).data('row')
//     if (id === "") {
//         const selectElement = document.getElementById("trip_id_" + row);
//         const firstOption = selectElement.options[0];
//         while (selectElement.options.length > 1) {
//             selectElement.remove(1);
//         }
//         selectElement.value = "";
//         loaderHide()
//         return false
//     }
//     axios
//         .post(APP_URL + '/get-sub-routes-by-route/' + id)
//         .then(function (response) {
//             var trips = response.data.trips;
//             const selectElement = document.getElementById('trip_id_' + row);
//             selectElement.innerHTML = '';
//             const defaultOption = document.createElement('option');
//             defaultOption.value = '';
//             defaultOption.textContent = select_trip_word;
//             selectElement.appendChild(defaultOption);
//             trips.forEach(function (optionData) {
//                 const option = document.createElement('option');
//                 option.value = optionData.id;
//                 option.textContent = optionData.start_location_name + ' - ' + optionData.end_location_name;
//                 selectElement.appendChild(option);
//             });
//             loaderHide()
//         })
//         .catch(function (error) {
//             console.log(error)
//             notificationToast(error.response.data.message, 'warning')
//             loaderHide()
//         })
// })

function addRow() {
    const table = document.getElementById('agent_routes');
    const newRow = createTableRow(rowNo);
    table.appendChild(newRow);
    rowNo = rowNo + 1
}
function removeRow(rowId) {
    $("#agent_route_row_" + rowId).remove()
    calc()
}

function createTableRow(rowId) {
    const tr = document.createElement('tr');
    tr.id = `agent_route_row_${rowId}`;

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
    const createPriceInput = (name, currency, class_name = '') => {
        const td = document.createElement('td');
        const inputGroup = document.createElement('div');
        inputGroup.className = 'input-group';

        const currencySpan = document.createElement('span');
        currencySpan.className = 'input-group-text';
        currencySpan.textContent = currency;

        const input = document.createElement('input');
        input.type = 'number';
        input.className = 'form-control ' + class_name;
        input.setAttribute('data-row', rowId);
        input.step = '0.001';
        input.id = name + '_' + rowId;
        input.name = `${name}[${rowId}]`;
        input.placeholder = `Agent ${currency} Price`;

        inputGroup.appendChild(currencySpan);
        inputGroup.appendChild(input);
        td.appendChild(inputGroup);

        return td;
    };
    const createRouteSelect = (name, class_name = '', routesData) => {
        const td = document.createElement('td');
        const select = document.createElement('select');
        select.className = 'form-control ' + class_name;
        select.id = name + '_' + rowId;
        select.name = `${name}[${rowId}]`;
        select.setAttribute('data-row', rowId);
        select.required = true;

        const defaultOption = document.createElement("option");
        defaultOption.value = "";
        defaultOption.textContent = select_routes_word;
        select.appendChild(defaultOption);

        // Loop through the routesData and create options
        routes.forEach(route => {
            const option = document.createElement("option");
            option.value = route.id;
            option.setAttribute('data-location', route.start_location_name);
            const timeComponents = route.route_time.split(':');
            const hours = parseInt(timeComponents[0]);
            const minutes = parseInt(timeComponents[1]);
            const ampm = hours >= 12 ? 'PM' : 'AM';
            const formattedHours = hours % 12 === 0 ? 12 : hours % 12;
            option.textContent = `${route.name} (${route.start_location_name} - ${route.end_location_name}) - ${formattedHours}:${minutes.toString().padStart(2, '0')} ${ampm}`;
            select.appendChild(option);
        });

        td.appendChild(select);

        return td;
    }

    const createTripSelect = (name, class_name = '') => {
        const td = document.createElement('td');
        const select = document.createElement('select');
        select.className = 'form-control ' + class_name;
        select.id = name + '_' + rowId;
        select.name = `${name}[${rowId}]`;
        select.setAttribute('data-row', rowId);

        const expenseTypeOption1 = document.createElement("option");
        expenseTypeOption1.value = "";
        expenseTypeOption1.textContent = select_trip_word;

        select.appendChild(expenseTypeOption1);

        td.appendChild(select);
        return td;
    }

    tr.appendChild(createRouteSelect('route_id', 'route_id'));
    // tr.appendChild(createTripSelect('trip_id', 'trip_id'));
    tr.appendChild(createInput('agent_seat_count', agent_seat_count_word, 'agent_seat_count'));
    tr.appendChild(createPriceInput('agent_aed_price', 'AED', 'integer'));
    tr.appendChild(createPriceInput('agent_omr_price', 'OMR', 'integer'));

    const actionTd = document.createElement('td');
    actionTd.className = 'text-center';
    const addButton = document.createElement('button');
    addButton.type = 'button';
    addButton.className = 'btn btn-danger btn-sm';
    addButton.onclick = () => removeRow(rowId);
    addButton.innerHTML = '<i class="la la-minus"></i>';
    actionTd.appendChild(addButton);
    tr.appendChild(actionTd);

    return tr;
}

// function removeRow(rowId) {
//     $("#agent_route_row_" + rowId).remove()
// }

function getAgentRoute(type, row, selected_id = 0) {
    loaderView()
    axios
        .get(APP_URL + get_agent_routes_url + route_id)
        .then(function (response) {
            $("#route_id_" + row).html(response.data.data)
            if (selected_id !== 0) {
                $("#route_id_" + row).val(selected_id)
            }
            loaderHide()
        })
        .catch(function (error) {
            notificationToast(error.response.data.message, 'warning')
            loaderHide()
        })
}
// route_id_
