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
    var ctx1 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx1.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
    gradientStroke1.addColorStop(0, 'rgba(94, 114, 228, 0)');
    new Chart(ctx1, {
        type: "line",
        data: {
            labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Mobile apps",
                tension: 0.4,
                borderWidth: 0,
                pointRadius: 0,
                borderColor: "#5e72e4",
                backgroundColor: gradientStroke1,
                borderWidth: 3,
                fill: true,
                data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                maxBarThickness: 6

            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false,
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            scales: {
                y: {
                    grid: {
                        drawBorder: false,
                        display: true,
                        drawOnChartArea: true,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        padding: 10,
                        color: '#fbfbfb',
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
                x: {
                    grid: {
                        drawBorder: false,
                        display: false,
                        drawOnChartArea: false,
                        drawTicks: false,
                        borderDash: [5, 5]
                    },
                    ticks: {
                        display: true,
                        color: '#ccc',
                        padding: 20,
                        font: {
                            size: 11,
                            family: "Open Sans",
                            style: 'normal',
                            lineHeight: 2
                        },
                    }
                },
            },
        },
    });
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
        }, 100);
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
</script>
