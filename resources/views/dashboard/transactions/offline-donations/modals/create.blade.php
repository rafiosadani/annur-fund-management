<div class="modal fade" id="create-offline-donation-modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Donasi Offline</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" action="{{ route('transaction.donations.offline-donation.store') }}" method="post">
                @csrf
                @if ($errors->any())
                    <script>
                        setTimeout(function () {
                            Swal.fire({
                                title: 'Error',
                                icon: 'error',
                                html: `
                                    @foreach ($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                                    @endforeach
                                `
                            });
                        }, 100);
                    </script>
                @endif
                <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label class="mt-3 mt-lg-3 required">Nama Donatur</label>
                                    <select name="m_user_id"
                                            class="form-control form-control-sm modal-dropdown-select2 mb-3 @error('m_user_id') is-invalid border border-danger @enderror">
                                        <option value="">-- Pilih Donatur --</option>
                                        @foreach($donors as $donor)
                                            @if(old('m_user_id') == $donor->id)
                                                <option value="{{ $donor->id }}" selected>{{ $donor->name }}</option>
                                            @else
                                                <option value="{{ $donor->id }}">{{ $donor->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('m_user_id')
                                    <div class="invalid-feedback text-xxs ms-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="mt-3 mt-lg-3 required">Nama Program</label>
                                    <select name="m_fundraising_program_id"
                                            class="form-control form-control-sm modal-dropdown-select2 mb-3 @error('m_fundraising_program_id') is-invalid border border-danger @enderror">
                                        <option value="">-- Pilih Program --</option>
                                        @foreach($fundraisingPrograms as $fundraisingProgram)
                                            @if(old('m_fundraising_program_id') == $fundraisingProgram->id)
                                                <option value="{{ $fundraisingProgram->id }}" selected>{{ $fundraisingProgram->title }}</option>
                                            @else
                                                <option value="{{ $fundraisingProgram->id }}">{{ $fundraisingProgram->title }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('m_fundraising_program_id')
                                    <div class="invalid-feedback text-xxs ms-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <label class="mt-3 mt-lg-3 required">Jumlah Donasi</label>
                                    <input type="text" class="form-control form-control-sm @error('amount') is-invalid @enderror inputRupiah" name="amount" value="{{ old('amount') }}">
                                    @error('amount')
                                    <div class="invalid-feedback text-xxs ms-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-3">
                    <button type="button" class="btn btn-sm bg-gradient-danger mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm bg-gradient-info mb-0">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
