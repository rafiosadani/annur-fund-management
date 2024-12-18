<div class="modal fade" id="edit-general-expense-modal-form-{{ $generalExpense->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Edit Transaksi Pengeluaran Umum - {{ $generalExpense->title }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" action="{{ route('transaction.expenses.general-expenses.update', $generalExpense->id) }}" method="post">
                @csrf
                @method('put')
                <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="mt-3 mt-lg-0 required" for="title">Nama Pengeluaran</label>
                                            <input type="text" class="form-control form-control-sm @error('title') is-invalid @enderror" placeholder="Nama Pengeluaran" name="title" value="{{ old('title', $generalExpense->title) }}">
                                            @error('title')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="mt-3 mt-lg-3 required" for="amount">Jumlah Dana</label>
                                            <input type="text" class="form-control form-control-sm @error('amount') is-invalid @enderror inputRupiah" name="amount" value="{{ old('originalAmount', isset($generalExpense->amount) ? number_format($generalExpense->amount, 0, ',', '.') : session('originalAmount')) }}">
                                            @error('amount')
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
                                                name="description" rows="3" >{{ old('description', $generalExpense->description) }}</textarea>
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
