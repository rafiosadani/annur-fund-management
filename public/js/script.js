$(document).ready(function () {
    // Select 2
    $(".dropdown-select2").select2();

    // Select 2 Modal
    initializeSelect2InModal();

    // Datepicker
    initializeDatepicker('.datepicker-date');

    // $('.mfp-gallery').magnificPopup({type:'image'});

    // Input Number Only
    const inputs = document.getElementsByClassName('inputNumberOnly');
    for (let i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener('input', function (e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }

    // Input Rupiah Only
    const rupiahInputs = document.getElementsByClassName('inputRupiah');
    for (let i = 0; i < rupiahInputs.length; i++) {
        rupiahInputs[i].addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, ''); // Hanya angka
            this.value = formatRupiah(this.value, '');
        });

        // Atur default menjadi "Rp. "
        if (rupiahInputs[i].value === '') {
            rupiahInputs[i].value = '';
        }
    }
});

function previewImage(imageInputId, imagePreviewClass, defaultImageUrl) {
    const imageUser = document.querySelector(`#${imageInputId}`);
    const userImgPreview = document.querySelector(`.${imagePreviewClass}`);

    if (imageUser.files && imageUser.files[0]) {
        const oFReader = new FileReader();
        oFReader.readAsDataURL(imageUser.files[0]);

        oFReader.onload = function(oFREvent) {
            userImgPreview.src = oFREvent.target.result; // Update src to the selected image
        }
    } else {
        userImgPreview.src = defaultImageUrl; // Set back to default if no file is chosen
    }
}

function initializeSelect2InModal() {
    // Setiap kali modal terbuka, inisialisasi Select2 di dalam modal tersebut
    $('.modal').on('shown.bs.modal', function () {
        // Mencari semua dropdown-select2 dalam modal yang terbuka
        setTimeout(function() {
            $(this).find('.modal-dropdown-select2').select2({
                dropdownParent: $(this), // Gunakan modal yang terbuka sebagai parent
                width: '100%' // Agar dropdown Select2 tampil penuh
            });
        }.bind(this), 200); // Penundaan untuk layout stabil
    });
}

function initializeDatepicker(selector) {
    $(selector).datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        orientation: 'bottom auto'
    }).on('show', function(e) {
        var datepicker = $(this).data('datepicker').picker;
        var inputWidth = $(this).outerWidth();
        datepicker.css('width', inputWidth + 'px'); // Set the width of the datepicker dropdown
    }).on('keydown', function(e) {
        e.preventDefault();
    });
}

function formatRupiah(angka, prefix) {
    let numberString = angka.replace(/[^,\d]/g, '').toString();
    let split = numberString.split(',');
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/g);

    // Tambahkan titik jika ada ribuan
    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? rupiah : '');
}

function copyData(elementId) {
    var copyText = document.getElementById(elementId);

    // Membuat input sementara untuk menyalin URL
    var tempInput = document.createElement("input");
    tempInput.value = copyText.value;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);

    Swal.fire({
        title: 'Berhasil!',
        text: 'URL Donasi Online berhasil disalin!',
        icon: 'success',
        timer: 2000,
        timerProgressBar: true,
    });
}

function handleModalWithErrors(modalId, sessionKey, errorTitle, errorMessages, refreshOnClose = false) {
    // Check if there is a session key indicating an error
    if (sessionKey) {
        // Show the modal
        var myModal = new bootstrap.Modal(document.getElementById(modalId));
        myModal.show();

        if(sessionKey !== 'create_amount_error') {
            // Show SweetAlert for errors
            setTimeout(function () {
                Swal.fire({
                    title: errorTitle,
                    icon: 'error',
                    html: errorMessages.map(msg => `<p class="mb-0">${msg}</p>`).join(''),
                    timer: 3000,
                    timerProgressBar: true
                }).then(() => {
                    // Blade will handle the session forget on page reload or next action
                });
            }, 100);
        }
    }

    // If refresh on modal close is enabled, set up the event listener
    if (refreshOnClose) {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function () {
                location.reload(); // This will refresh the page
            });
        });
    }
}

