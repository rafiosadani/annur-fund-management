<div class="modal fade" id="detail-good-modal-form-{{ $good->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Detail Data Barang</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form">
                <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="mt-3 mt-lg-0 required" for="item_name">Nama Barang</label>
                                            <input type="text" class="form-control form-control-sm" placeholder="Nama barang" name="item_name" value="{{ $good->item_name }}" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label class="mt-3 mt-lg-3 required" for="merk">Merek</label>
                                            <input type="text" class="form-control form-control-sm" name="merk" value="{{ $good->merk }}" disabled>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="mt-3 mt-lg-3 required" for="quantity">Jumlah</label>
                                            <input type="text" class="form-control form-control-sm" placeholder="Jumlah" name="quantity" value="{{ $good->quantity }}" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="mt-3 mt-lg-3 required" for="description">Deskripsi</label>
                                            <textarea style="resize: none;" class="form-control form-control-sm" name="description" rows="3" readonly>{{ $good->description }}</textarea>
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
            </form>
        </div>
    </div>
</div>
