<div class="modal fade" id="create-fundraising-program-modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Data Program Penggalangan Dana</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" action="{{ route('fundraising-programs.store') }}" method="post" enctype="multipart/form-data">
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
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label class="mt-3 mt-lg-0 required">Nama Program</label>
                                            <input type="text" class="form-control form-control-sm @error('title') is-invalid @enderror" placeholder="Nama program" name="title" value="{{ old('title') }}">
                                            @error('title')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="mt-3 mt-lg-0 required">Target Donasi</label>
                                            <input type="text" class="form-control form-control-sm @error('target_amount') is-invalid @enderror inputRupiah" placeholder="Target donasi" name="target_amount" value="{{ old('target_amount') }}">
                                            @error('target_amount')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label for="start_date" class="mt-3 mt-lg-3 required">Tanggal Mulai</label>
                                            <input type="text" id="start_date" class="form-control form-control-sm datepicker-date @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date') }}">
                                            @error('start_date')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="end_date" class="mt-3 mt-lg-3 required">Tanggal Selesai</label>
                                            <input type="text" id="end_date" class="form-control form-control-sm datepicker-date @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}">
                                            @error('end_date')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="mt-3 mt-lg-3 required">Status</label>
                                            <select name="status"
                                                    class="form-control form-control-sm modal-dropdown-select2 mb-3 @error('status') is-invalid border border-danger @enderror">
                                                <option value="">-- Pilih Status --</option>
                                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                            </select>
                                            @error('status')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="mt-3 mt-lg-3 required" for="description">Keterangan</label>
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
                                <div class="col-12">
                                    <label class="mt-3 mt-lg-3" for="">Foto User</label>
                                    <div id="image-previews-container" class="d-flex flex-wrap justify-content-center gap-2 mb-3" style="gap: 0.8rem !important; overflow-x: auto;">
                                        <div id="default-preview" class="text-center">
                                            <img src="{{ asset('img/preview-user.png') }}" alt="Preview" style="width: 140px; height: 140px;" class="img-thumbnail">
                                            <p class="text-muted text-xs ps-1 mt-1 mb-0">Belum ada gambar</p>
                                        </div>
                                        <!-- Dynamic image previews will appear here -->
                                    </div>
                                    <div class="col-12 mt-2">
                                        <input type="file" name="images[]" id="image-fundraising-program-create" accept="image/png, image/jpeg" max-size="2000000" multiple
                                               class="form-control form-control-sm mb-2" style="display: none;" onchange="previewImages(this, 'image-previews-container', 'default-preview', 'upload-image-button')">
                                        <div class="d-grid">
                                            <button class="btn bg-gradient-primary btn-sm mb-0" id="upload-image-button" type="button"
                                                    onclick="document.getElementById('image-fundraising-program-create').click();">
                                                    Upload Image
                                            </button>
                                        </div>
{{--                                        <input type="file" name="images[]" id="image-fundraising-program-create" accept="image/png, image/jpeg" max-size="2000000" multiple--}}
{{--                                               class="form-control form-control-sm"--}}
{{--                                               onchange="previewImages(this, 'image-previews-container')">--}}
                                        <p class="text-xs mt-2 mb-0">*png, jpg, jpeg (maxsize: 2MB), *ratio 1:1</p>
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
