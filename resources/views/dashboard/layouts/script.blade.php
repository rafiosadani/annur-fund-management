<!--   Core JS Files   -->
<script src="{{ asset('js/core/popper.min.js') }}"></script>
<script src="{{ asset('js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('js/plugins/smooth-scrollbar.min.js') }}"></script>
<script src="{{ asset('js/plugins/chartjs.min.js') }}"></script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
</script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('js/argon-dashboard.min.js?v=2.0.4') }}"></script>

{{-- JQuery --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
{{--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>--}}

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Select 2 JS --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- Datepicker --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

{{-- My JS --}}
<script src="{{ asset('js/script.js') }}"></script>

{{-- Custom SweetAlert Notifikasi --}}
@if(session('loginSuccess'))
    <script>
        setTimeout(function () {
            Swal.fire({
                title: "Berhasil!",
                text: "Anda berhasil login!",
                icon: "success",
                timer: 3000
            });
        }, 100);
    </script>
@endif

@if(session('success'))
    <script>
        setTimeout(function () {
            Swal.fire({
                title: "Berhasil!",
                text: "{{ session('success') }}",
                icon: "success",
                timer: 3000
            });
        }, 300);
    </script>
@endif

@if(session('error'))
    <script>
        setTimeout(function () {
            Swal.fire({
                title: "Error",
                text: "{{ session('error') }}",
                icon: "error",
                timer: 3000
            });
        }, 1000);
    </script>
@endif

<script type="text/javascript">
    $('.show-logout-header').click(function (event) {
        event.preventDefault();
        var form = $(this).closest("form");
        Swal.fire({
            title: "Apakah kamu yakin?",
            text: "Ingin keluar dari aplikasi ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#5e72e4",
            cancelButtonColor: "#f5365c",
            confirmButtonText: "Ya, saya yakin!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    $('.show-logout-sidebar').click(function (event) {
        event.preventDefault();
        var form = $(this).closest("form");
        Swal.fire({
            title: "Apakah kamu yakin?",
            text: "Ingin keluar dari aplikasi ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#5e72e4",
            cancelButtonColor: "#f5365c",
            confirmButtonText: "Ya, saya yakin!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    $('.show-confirm-delete').click(function (event) {
        event.preventDefault();
        var form = $(this).closest("form");
        Swal.fire({
            title: "Apakah kamu yakin?",
            text: "Ingin menghapus data ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#5e72e4",
            cancelButtonColor: "#f5365c",
            confirmButtonText: "Ya, hapus data!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    $('.show-confirm-restore').click(function (event) {
        event.preventDefault();
        var href = $(this).attr("href");
        Swal.fire({
            title: "Apakah kamu yakin?",
            text: "Ingin merestore data ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#5e72e4",
            cancelButtonColor: "#f5365c",
            confirmButtonText: "Ya, restore data!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = href;
            }
        });
    });

    $('.show-confirm-restore-all').click(function (event) {
        event.preventDefault();
        var href = $(this).attr("href");
        Swal.fire({
            title: "Apakah kamu yakin?",
            text: "Ingin merestore semua data ini?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#5e72e4",
            cancelButtonColor: "#f5365c",
            confirmButtonText: "Ya, restore data!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = href;
            }
        });
    });

    $('.show-confirm-donor-transfer').click(function (event) {
        event.preventDefault();
        var form = $(this).closest("form");
        Swal.fire({
            title: "Konfirmasi Transfer?",
            text: "Apakah anda yakin ingin mengonfirmasi transfer donasi ini? Pastikan bukti pembayaran sudah diperiksa.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#5e72e4",
            cancelButtonColor: "#f5365c",
            confirmButtonText: "Ya, Konfirmasi!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    $('.show-reject-donor-transfer').click(function (event) {
        event.preventDefault();
        var form = $(this).closest("form");
        Swal.fire({
            title: "Tolak Konfirmasi Transfer?",
            text: "Apakah anda yakin ingin menolak konfirmasi transfer donasi ini? Pastikan bukti pembayaran sudah diperiksa.",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#5e72e4",
            cancelButtonColor: "#f5365c",
            confirmButtonText: "Ya, Tolak!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
