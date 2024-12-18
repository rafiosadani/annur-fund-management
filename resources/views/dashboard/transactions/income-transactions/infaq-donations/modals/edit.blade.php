<div class="modal fade" id="edit-infaq-donation-modal-form-{{ $infaqDonation->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Edit Transaksi Donasi Barang</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" action="{{ route('transaction.infaq-donations.update', $infaqDonation->id) }}" method="post">
                @csrf
                @method('put')
                <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="mt-3 mt-lg-0 required" for="name">Nama Infaq</label>
                                            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="Nama Infaq" name="name" value="{{ old('name', $infaqDonation) }}">
                                            @error('name')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label class="mt-3 mt-lg-3 required" for="m_infaq_type_id">Jenis Infaq</label>
                                            <select name="m_infaq_type_id"
                                                    class="form-control form-control-sm modal-dropdown-select2 mb-3 @error('m_infaq_type_id') is-invalid border border-danger @enderror">
                                                <option value="">-- Pilih Jenis Infaq --</option>
                                                @foreach($infaqTypes as $infaqType)
                                                    @if(old('m_infaq_type_id', $infaqDonation->m_infaq_type_id) == $infaqType->id)
                                                        <option value="{{ $infaqType->id }}" selected>{{ $infaqType->type_name }}</option>
                                                    @else
                                                        <option value="{{ $infaqType->id }}">{{ $infaqType->type_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('m_infaq_type_id')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="mt-3 mt-lg-3 required" for="amount">Jumlah Infaq</label>
                                            <input type="text" class="form-control form-control-sm @error('amount') is-invalid @enderror inputRupiah" name="amount" value="{{ old('originalAmount', isset($infaqDonation->amount) ? number_format($infaqDonation->amount, 0, ',', '.') : session('originalAmount')) }}">
                                            @error('amount')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="mt-3 mt-lg-3 required" for="note">Keterangan</label>
                                            <textarea style="resize: none;" class="form-control form-control-sm @error('note') is-invalid @enderror"
                                                      id="note" name="note" rows="3" >{{ old('note', $infaqDonation->note) }}</textarea>
                                            @error('note')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
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