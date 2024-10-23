$(document).ready(function () {
    // Select 2
    // $(".dropdown-select2").select2();

    initializeSelect2InModal()

    // Input Number Only
    const inputs = document.getElementsByClassName('inputNumberOnly');
    for (let i = 0; i < inputs.length; i++) {
        inputs[i].addEventListener('input', function (e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
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

// Fungsi untuk menampilkan modal dan menginisialisasi Select2 jika ada error
function showModalWithErrors(modalId) {
    // Tampilkan modal
    $(modalId).modal('show');

    // Inisialisasi Select2 di dalam modal
    setTimeout(function() {
        $(modalId).find('.dropdown-select2').select2({
            dropdownParent: $(modalId),
            width: '100%' // Agar dropdown Select2 tampil penuh
        });
    }, 200); // Penundaan untuk layout stabil
}
