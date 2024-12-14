<div class="modal fade" id="change-password-user-modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Ubah Password</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" action="{{ route('change-password') }}" method="post">
                @csrf
                <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="alert alert-info text-sm text-white px-0" role="alert">
                                        <ul class="mb-0 me-2">
                                            <li>Jika Anda lupa password saat ini atau password lama, harap segera hubungi
                                                administrator untuk bantuan lebih lanjut.
                                            </li>
                                            <li>Untuk mengubah password, pastikan password baru anda berbeda dengan password yang
                                                lama.
                                            </li>
                                            <li>Pastikan password baru anda memiliki setidaknya 8 karakter.</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="mt-3 mt-lg-3 required">Password Lama</label>
                                    <input type="password" class="form-control form-control-sm @error('current_password') is-invalid @enderror" placeholder="Password lama" name="current_password">
                                    @error('current_password')
                                    <div class="invalid-feedback text-xxs ms-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="mt-3 mt-lg-3 required">Password Baru</label>
                                    <input type="password" class="form-control form-control-sm @error('new_password') is-invalid @enderror" placeholder="Password lama" name="new_password">
                                    @error('new_password')
                                    <div class="invalid-feedback text-xxs ms-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="mt-3 mt-lg-3 required">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control form-control-sm @error('confirm_new_password') is-invalid @enderror" placeholder="Password lama" name="confirm_new_password">
                                    @error('confirm_new_password')
                                    <div class="invalid-feedback text-xxs ms-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-2">
                    <button type="button" class="btn btn-sm bg-gradient-danger mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm bg-gradient-info mb-0">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Trigger page refresh when any modal is closed
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function () {
                    location.reload(); // This will refresh the page
                });
            });

            @if ($errors->any())
                @if (session('change_password_error'))
                    // Show Create Form Modal
                    var myModalChangePassword = new bootstrap.Modal(document.getElementById('change-password-user-modal-form'));
                    myModalChangePassword.show();

                    // Show SweetAlert for Create Form Errors
                    setTimeout(function () {
                    Swal.fire({
                        title: 'Ubah Password Error',
                        icon: 'error',
                        html: `
                                @foreach ($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                        `
                    }).then(() => {
                        @php session()->forget('change_password_error'); @endphp
                    });
                }, 100);
               @endif
            @endif
        });
    </script>
@endsection
