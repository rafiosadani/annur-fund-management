<div class="modal fade" id="detail-donor-transfer-confirmation-modal-form-{{ $donorTransferConfirmation->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Detail Data Konfirmasi Transfer Donatur - {{ $donorTransferConfirmation->fundraisingProgram->title }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="mt-3 mt-lg-0 mb-1">Kode Donasi</label>
                                        <p class="text-secondary text-xs text-bold ms-1">{{ $donorTransferConfirmation->donation_code ?? '-' }}</p>
                                    </div>
                                    <div class="col-12">
                                        <label class="mt-3 mt-lg-0 mb-1">Donatur</label>
                                        <p class="text-secondary text-xs text-bold ms-1">{{ isset($donorTransferConfirmation->user) ? ($donorTransferConfirmation->user->is_anonymous == 1 ? 'Anonymous' : $donorTransferConfirmation->user->name) : (isset($donorTransferConfirmation->donorProfile) ? ($donorTransferConfirmation->donorProfile->is_anonymous == 1 ? 'Anonymous' : $donorTransferConfirmation->donorProfile->name) : '') }}</p>
                                    </div>
                                    <div class="col-12">
                                        <label class="mt-3 mt-lg-0 mb-1">Email</label>
                                        <p class="text-secondary text-xs text-bold ms-1">{{ isset($donorTransferConfirmation->user) ? ($donorTransferConfirmation->user->is_anonymous == 1 ? 'Pengguna Anonymous' : $donorTransferConfirmation->user->email) : (isset($donorTransferConfirmation->donorProfile) ? ($donorTransferConfirmation->donorProfile->is_anonymous == 1 ? 'Pengguna Anonymous' : $donorTransferConfirmation->donorProfile->email) : '-') }}</p>
                                    </div>
                                    <div class="col-12">
                                        <label class="mt-3 mt-lg-0 mb-1">Jenis Kelamin</label>
                                        <p class="text-secondary text-xs text-bold ms-1">{{ isset($donorTransferConfirmation->user) ? ($donorTransferConfirmation->user->is_anonymous == 1 ? 'Tidak Ditentukan' : ucfirst($donorTransferConfirmation->user->gender)) : (isset($donorTransferConfirmation->donorProfile) ? ($donorTransferConfirmation->donorProfile->is_anonymous == 1 ? 'Tidak Ditentukan' : ucfirst($donorTransferConfirmation->donorProfile->gender)) : '-') }}</p>
                                    </div>
                                    <div class="col-12">
                                        <label class="mt-3 mt-lg-0 mb-1">No Handphone</label>
                                        <p class="text-secondary text-xs text-bold ms-1">{{ isset($donorTransferConfirmation->user) ? ($donorTransferConfirmation->user->is_anonymous == 1 ? 'Tidak Ditampilkan' : $donorTransferConfirmation->user->phone) : (isset($donorTransferConfirmation->donorProfile) ? ($donorTransferConfirmation->donorProfile->is_anonymous == 1 ? 'Tidak Ditampilkan' : $donorTransferConfirmation->donorProfile->phone) : '-') }}</p>
                                    </div>
                                    <div class="col-12">
                                        <label class="mt-3 mt-lg-0 mb-1">Alamat</label>
                                        <p class="text-secondary text-xs text-bold ms-1">{{ isset($donorTransferConfirmation->user) ? ($donorTransferConfirmation->user->is_anonymous == 1 ? 'Privasi Terjaga' : $donorTransferConfirmation->user->address) : (isset($donorTransferConfirmation->donorProfile) ? ($donorTransferConfirmation->donorProfile->is_anonymous == 1 ? 'Privasi Terjaga' : $donorTransferConfirmation->donorProfile->address) : '-') }}</p>
                                    </div>
                                    <div class="col-12">
                                        <label class="mt-3 mt-lg-0 mb-1">Program</label>
                                        <p class="text-secondary text-xs text-bold ms-1">{{ $donorTransferConfirmation->fundraisingProgram->title ?? '-' }}</p>
                                    </div>
                                    <div class="col-12">
                                        <label class="mt-3 mt-lg-0 mb-1">Jumlah Donasi</label>
                                        <p class="text-secondary text-xs text-bold ms-1">@currency($donorTransferConfirmation->amount ?? 0)</p>
                                    </div>
                                    <div class="col-12">
                                        <label class="mt-3 mt-lg-0 mb-1">Status</label>
                                        <p class="text-secondary text-xs text-bold ms-2 d-inline-flex">
                                            <span class="badge d-inline-flex align-items-center {{ $donorTransferConfirmation->status == 'pending' ? 'bg-soft-warning' : 'bg-soft-danger' }}">
                                                <i class="fas {{ $donorTransferConfirmation->status == 'pending' ? 'fa-solid fa-clock' : 'fa-solid fa-ban' }} me-1"></i>
                                                {{ $donorTransferConfirmation->status ?? '-' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="row">
                                    <label class="mt-3 mt-lg-0 mb-1" for="">Bukti Transfer</label>
                                    <div class="d-flex flex-wrap justify-content-center mb-3" style="gap: 0.8rem !important; overflow-x: auto;">
                                        @if(is_null($donorTransferConfirmation->proof_of_payment))
                                            <div class="text-center">
                                                <img src="{{ asset('img/preview-proof-of-payment.png') }}" alt="Preview" class="img-thumbnail ms-1">
                                                <p class="text-muted text-xs ps-1 mt-2 mb-0">Belum ada Bukti Transfer</p>
                                            </div>
                                        @else
                                            <img src="{{ asset('storage/' . $donorTransferConfirmation->proof_of_payment) }}" alt="Preview" class="img-thumbnail">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-2">
                <button type="button" class="btn btn-sm bg-gradient-danger mb-0" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
