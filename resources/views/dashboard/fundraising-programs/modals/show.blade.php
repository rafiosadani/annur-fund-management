<div class="modal fade" id="detail-fundraising-program-modal-form-{{ $fundraisingProgram->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Detail Data Program {{ $fundraisingProgram->title }}</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-12 col-md-5">
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
                            <div class="col-12 col-md-7 ps-md-4">
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="font-weight-bolder text-xs mt-1">Transaksi Pemasukan</h6>
                                        <div class="table-responsive pt-1">
                                            <table class="table align-items-center mb-0">
                                                <thead>
                                                <tr style="border-top-width: 1px;">
                                                    <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-3"
                                                        style="width: 10px;">
                                                        No
                                                    </th>
                                                    <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        Tanggal
                                                    </th>
                                                    <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                                        style="width: 93%">
                                                        Nama
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                        Metode
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                        style="width: 7%">
                                                        Jumlah Donasi
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @if($fundraisingProgram->donations->total() < 1)
                                                        <tr style="border-bottom: 1px solid #ccdddd;">
                                                            <td colspan="4">
                                                                <p class="text-center text-xs mb-0 py-1">Data tidak ditemukan.</p>
                                                            </td>
                                                        </tr>
                                                    @else
                                                        @foreach($fundraisingProgram->donations as $donation)
                                                            <tr>
                                                                <td>
                                                                    <p class="text-center text-xs mb-0">{{ $loop->iteration + ($fundraisingProgram->donations->currentPage() - 1) * $fundraisingProgram->donations->perPage() }}</p>
                                                                </td>
                                                                <td>
                                                                    <p class="text-start text-xs mb-0">
                                                                        {{ $donation->payment_method == 'offline' ? $donation->created_at : $donation->updated_at }}
                                                                    </p>
                                                                </td>
                                                                <td>
                                                                    <p class="text-start text-xs mb-0">
                                                                        {{ isset($donation->user) ? ($donation->user->is_anonymous == 1 ? 'Anonymous' : $donation->user->name) : (isset($donation->donorProfile) ? ($donation->donorProfile->is_anonymous == 1 ? 'Anonymous' : $donation->donorProfile->name) : '') }}
                                                                    </p>
                                                                </td>
                                                                <td class="align-middle text-center text-xs">
                                                                    <span class="badge d-inline-flex align-items-center {{ $donation->payment_method == 'online' ? 'bg-soft-success' : ($donation->payment_method == 'offline' ? 'bg-soft-info' : 'bg-soft-danger') }}">
                                                                        <i class="fas {{ $donation->payment_method == 'online' ? 'fa-solid fa-globe' : ($donation->payment_method == 'offline' ? 'fa-solid fa-handshake' : 'fa-solid fa-bomb') }} me-1"></i>
                                                                        {{ $donation->payment_method }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <p class="text-center text-xs mb-0">@currency($donation->amount)</p>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                            <hr class="mt-0" style="border: 1px solid #ccdddd">
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            {!! $fundraisingProgram->donations->appends(['openModal' => $fundraisingProgram->id])->links() !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h6 class="font-weight-bolder text-xs mt-1">Transaksi Pengeluaran</h6>
                                        <div class="table-responsive pt-1">
                                            <table class="table align-items-center mb-0">
                                                <thead>
                                                <tr style="border-top-width: 1px;">
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-3">
                                                        No
                                                    </th>
                                                    <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                        Tanggal
                                                    </th>
                                                    <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                                        style="width: 93%">
                                                        Keterangan
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                        style="width: 7%">
                                                        Jumlah Dana
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        {{--                                                        <p class="text-center text-xs mb-0">{{ $loop->iteration + ($roles->currentPage() - 1) * $roles->perPage() }}</p>--}}
                                                        <p class="text-center text-xs mb-0">1</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-start text-xs mb-0">{{ \Carbon\Carbon::parse('2024-09-12')->translatedFormat('d F Y') }}</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-start text-xs mb-0">Pembelian bahan bangunan (semen, pasir, dll.)</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-center text-xs mb-0">@currency(5000000)</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="ps-3">
                                                        <p class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 mb-0">Total Pengeluaran</p>
                                                    </td>
                                                    <td>
                                                        <p class="text-center text-xs font-weight-bold mb-0">@currency(5000000)</p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <hr class="mt-0" style="border: 1px solid #ccdddd">
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
