<div class="modal fade" id="detail-donor-transfer-confirmation-modal-form-{{ $donorTransferConfirmation->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Detail Data Konfirmasi Transfer Donatur {{ $donorTransferConfirmation->fundraisingProgram->title }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label class="mt-3 mt-lg-0 required">Nama Program</label>
                                                <input type="text" class="form-control form-control-sm" name="title" value="{{ $fundraisingProgram->title }}" readonly>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="mt-3 mt-lg-0 required">Target Donasi</label>
                                                <input type="text" class="form-control form-control-sm" name="target_amount" value="@currency($fundraisingProgram->target_amount)" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="start_date" class="mt-3 mt-lg-3 required">Tanggal Mulai</label>
                                                <input type="text" id="start_date" class="form-control form-control-sm" name="start_date" value="{{ \Carbon\Carbon::parse($fundraisingProgram->start_date)->translatedFormat('d F Y') }}" readonly>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="end_date" class="mt-3 mt-lg-3 required">Tanggal Selesai</label>
                                                <input type="text" id="end_date" class="form-control form-control-sm" name="end_date" value="{{ \Carbon\Carbon::parse($fundraisingProgram->end_date)->translatedFormat('d F Y') }}" readonly>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label class="mt-3 mt-lg-3 required">Status</label>
                                                <select name="status"
                                                        class="form-control form-control-sm modal-dropdown-select2 mb-3" disabled>
                                                    <option value="">-- Pilih Status --</option>
                                                    <option value="active" {{ $fundraisingProgram->status == 'active' ? 'selected' : '' }}>Aktif</option>
                                                    <option value="completed" {{ $fundraisingProgram->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="cancelled" {{ $fundraisingProgram->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label class="mt-3 mt-lg-3 required" for="description">Keterangan</label>
                                                <textarea style="resize: none;" class="form-control form-control-sm" id="description" name="description" rows="3" readonly>{{ $fundraisingProgram->description }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="mt-3 mt-lg-3" for="">Gambar</label>
                                        <div id="image-previews-container-detail" class="d-flex flex-wrap justify-content-center gap-2 mb-3" style="gap: 0.8rem !important; overflow-x: auto;">
                                            @if($fundraisingProgram->images->isEmpty())
                                                <div id="default-preview-detail" class="text-center">
                                                    <img src="{{ asset('img/preview-user.png') }}" alt="Preview" style="width: 140px; height: 140px;" class="img-thumbnail">
                                                    <p class="text-muted text-xs ps-1 mt-1 mb-0">Belum ada gambar</p>
                                                </div>
                                            @else
                                                @foreach($fundraisingProgram->images as $image)
                                                    <img src="{{ asset('storage/' . $image->image) }}" alt="Preview" style="width: 140px; height: 140px;" class="img-thumbnail">
                                                @endforeach
                                            @endif
                                        </div>
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
