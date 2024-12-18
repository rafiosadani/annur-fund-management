<div class="modal fade" id="create-good-donation-modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Transaksi Donasi Barang</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" action="{{ route('good-donations.store') }}" method="post">
                @csrf
                <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="mt-3 mt-lg-0 required" for="item_name">Nama Barang</label>
                                            <select name="m_good_inventory_id"
                                                    class="form-control form-control-sm modal-dropdown-select2 mb-3 @error('m_good_inventory_id') is-invalid border border-danger @enderror">
                                                <option value="">-- Pilih Barang --</option>
                                                @foreach($goods as $good)
                                                    @if(old('m_good_inventory_id') == $good->id)
                                                        <option value="{{ $good->id }}" selected>{{ $good->good_inventory_code }} - {{ $good->item_name }}</option>
                                                    @else
                                                        <option value="{{ $good->id }}">{{ $good->good_inventory_code }} - {{ $good->item_name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('m_good_inventory_id')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label class="mt-3 mt-lg-3 required" for="m_user_id">Nama Donatur</label>
                                            <select name="m_user_id"
                                                    class="form-control form-control-sm modal-dropdown-select2 mb-3 @error('m_user_id') is-invalid border border-danger @enderror">
                                                <option value="">-- Pilih Donatur --</option>
                                                @foreach($users as $user)
                                                    @if(old('m_user_id') == $user->id)
                                                        <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                                    @else
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
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
                                            <label class="mt-3 mt-lg-3 required" for="quantity">Jumlah</label>
                                            <input type="text" class="form-control form-control-sm @error('quantity') is-invalid @enderror inputNumberOnly" placeholder="Jumlah" name="quantity" value="{{ old('quantity') }}">
                                            @error('quantity')
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
                                                      id="note" name="note" rows="3" >{{ old('note') }}</textarea>
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
