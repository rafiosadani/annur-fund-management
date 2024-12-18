<div class="modal fade" id="create-good-modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Data Barang</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" action="{{ route('good-inventories.store') }}" method="post">
                @csrf
                <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="mt-3 mt-lg-0 required" for="item_name">Nama Barang</label>
                                            <input type="text" class="form-control form-control-sm @error('item_name') is-invalid @enderror" placeholder="Nama barang" name="item_name" value="{{ old('item_name') }}">
                                            @error('item_name')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label class="mt-3 mt-lg-3 required" for="merk">Merek</label>
                                            <input type="text" id="merk" class="form-control form-control-sm @error('merk') is-invalid @enderror" name="merk" value="{{ old('merk') }}">
                                            @error('merk')
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
                                            <label class="mt-3 mt-lg-3 required" for="description">Deskripsi</label>
                                            <textarea style="resize: none;" class="form-control form-control-sm @error('description') is-invalid @enderror"
                                                      id="description" name="description" rows="3" >{{ old('description') }}</textarea>
                                            @error('description')
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
