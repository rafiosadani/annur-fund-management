$(document).ready(function () {
    // Select 2
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

function handleModalWithErrors(modalId, sessionKey, errorTitle, errorMessages, refreshOnClose = false) {
    // Check if there is a session key indicating an error
    if (sessionKey) {
        // Show the modal
        var myModal = new bootstrap.Modal(document.getElementById(modalId));
        myModal.show();

        // Show SweetAlert for errors
        setTimeout(function () {
            Swal.fire({
                title: errorTitle,
                icon: 'error',
                html: errorMessages.map(msg => `<p class="mb-0">${msg}</p>`).join('')
            }).then(() => {
                // Blade will handle the session forget on page reload or next action
            });
        }, 100);
    }

    console.log(refreshOnClose);

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

