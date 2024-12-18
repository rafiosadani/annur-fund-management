<div class="modal fade" id="edit-infaq-modal-form{{ $infaqType->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Edit Data Infaq</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" action="{{ route('infaq.update', $infaqType->id) }}" method="post">
                @csrf
                @method('PUT')
                @if ($errors->any())
                    <script>
                        setTimeout(function () {
                            Swal.fire({
                                title: 'Error',
                                icon: 'error',
                                html: `@foreach ($errors->all() as $error) <p class="mb-0">{{ $error }}</p> @endforeach`
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
                                        <div class="col-12">
                                            <label class="mt-3 mt-lg-0 required">Nama Tipe Infaq</label>
                                            <input type="text" class="form-control form-control-sm @error('type_name') is-invalid @enderror" placeholder="Nama tipe infaq" name="type_name" value="{{ old('type_name', $infaqType->type_name) }}">
                                            @error('type_name')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="mt-3 mt-lg-3 required">Deskripsi</label>
                                            <textarea style="resize: none;" class="form-control form-control-sm @error('description') is-invalid @enderror"
                                                      name="description" rows="3">{{ old('description', $infaqType->description) }}</textarea>
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
