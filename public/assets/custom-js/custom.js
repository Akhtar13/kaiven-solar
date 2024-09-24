function funTooltip() {
    $('[data-toggle="tooltip"]').tooltip()
}

function notificationToast(message, type) {
    if (type === 'success') {
        Toastify({
            className: 'bg-success',
            text: message,
            gravity: "top",
            position: 'center',
            close: true,
        }).showToast();
    } else if (type === 'warning') {
        Toastify({
            className: 'bg-danger',
            text: message,
            gravity: "top",
            position: 'center',
            close: true,
        }).showToast();
    }
}

function floatOnly() {
    $('.float').keypress(function (event) {
        if ((event.which !== 46 || $(this).val().indexOf('.') !== -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
}

function integerOnly() {
    $('.integer').keypress(function (event) {
        if (event.which !== 8 && event.which !== 0 && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });
}

$('.integer').keypress(function (event) {
    if (event.which !== 8 && event.which !== 0 && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
});
$('.float').keypress(function (event) {
    if ((event.which !== 46 || $(this).val().indexOf('.') !== -1) && (event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
});


function loaderView() {
    $.blockUI({
        message: '<div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div>',
        css: {
            padding: 0,
            margin: 0,
            width: "25%",
            top: "40%",
            left: "35%",
            textAlign: "center",
            color: "#000",
            border: "none",
            backgroundColor: "transparent",
            cursor: "wait",
            "z-index": "99999999"
        }
    });
    $(".blockOverlay").css('z-index', 99999999999)
}

function loaderHide() {
    setTimeout(function () {
        $.unblockUI();
    }, 100)
}

$(document).on('click', '.edit-button', function () {
    window.location.href = $(this).data('href');
})

//$('.select2').select2();


function funDataTableCheck(class_name) {
    const $class_name = $('.' + class_name);
    const $table_head = $('#table_head');
    const $table_foot = $('#table_foot');

    $table_head.change(function () {
        if (this.checked) {
            $class_name.prop('checked', true);
            $table_foot.prop('checked', true);
        } else {
            $class_name.prop('checked', false);
            $table_foot.prop('checked', false);
        }
    });

    $table_foot.change(function () {
        if (this.checked) {
            $class_name.prop('checked', true);
            $table_head.prop('checked', true);
        } else {
            $class_name.prop('checked', false);
            $table_head.prop('checked', false);
        }
    });

    $class_name.change(function () {
        if (this.checked) {
            if ($class_name.filter(":checked").length === $class_name.length) {
                $table_head.prop('checked', true);
                $table_foot.prop('checked', true);
            }
        } else {
            $table_head.prop('checked', false);
            $table_foot.prop('checked', false);
        }
    });
}

function funDataTableUnCheck(class_name) {
    const $class_name = $('.' + class_name);
    const $table_head = $('#table_head');
    const $table_foot = $('#table_foot');
    $class_name.prop('checked', false);
    $table_head.prop('checked', false);
    $table_foot.prop('checked', false);
}

const $clock_picker = $('.clock-picker')
const $date_picker = $('.date-picker')
const $all_date_picker = $('.all-date-picker')
if ($clock_picker.length > 0) {
    $('.date-picker').flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: 'H:i',
        time_24hr: true
    })
}
if ($date_picker.length > 0) {
    $date_picker.flatpickr({
        enableTime: false,
        minDate: "today",
        dateFormat: 'Y-m-d'
    })
}
if ($all_date_picker.length > 0) {
    $all_date_picker.flatpickr({
        enableTime: false,
        dateFormat: 'Y-m-d'
    })
}

FilePond.registerPlugin(
    FilePondPluginImagePreview
);


const singleImage = (id) => {
    let image = document.querySelector(`#${id}`);
    FilePond.create(image, {
        allowMultiple: false,
        instantUpload: false,
        maxParallelUploads: '10',
        itemInsertInterval: '0',
        storeAsFile: true
    });
}

const singleImageWithImage = (id,file_url) => {
    let image = document.querySelector(`#${id}`);
    FilePond.create(image, {
        allowMultiple: false,
        instantUpload: false,
        maxParallelUploads: '10',
        itemInsertInterval: '0',
        storeAsFile: true,
        files: [
            {
                source: file_url, options: {type: 'image/*'}
            },
        ],
    });
}

const multipleImage = (id) => {
    let image = document.querySelector(`#${id}`);
    FilePond.create(image, {
        allowMultiple: true,
        instantUpload: false,
        maxParallelUploads: '10',
        itemInsertInterval: '0',
        storeAsFile: true,
    });
}
