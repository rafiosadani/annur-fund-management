@extends('dashboard.layouts.main')

@section('title', 'Data Pengeluaran Program')

@section('breadcrumb')
    <x-breadcrumb title="Data Pengeluaran Program" page="Transaksi" active="Pengeluaran Program"/>
@endsection

@section('content')
    <div class="row mt-4 mt-lg-0">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header mb-0 pb-2">
                    <div class="row">
                        <div class="col-lg-4 col-12">
                            <h6>Data Pengeluaran Program</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <form action="" method="get" class="pb-0 m-0">
                        <div class="row pb-0">
                            <div class="col-md-10 pb-0">
                                <div class="row">
                                    <div class="col-md-12">
                                        <select name="m_fundraising_program_id"
                                                class="form-control form-control-sm dropdown-select2 mb-3">
                                            <option value="">-- Semua Program Penggalangan Dana --</option>
                                            @foreach($fundraisingPrograms as $fundraisingProgram)
                                                <option value="{{ $fundraisingProgram->id }}" {{ request('m_fundraising_program_id') == $fundraisingProgram->id ? 'selected' : '' }}>
                                                    {{ $fundraisingProgram->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 pb-0">
                                <button type="submit" class="btn bg-gradient-info btn-sm mb-0 btn-action w-100">
                                    <i class="fas fa-search"></i> &nbsp; Search Program
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if($selectedFundraisingProgram)
        <div class="row">
            <div class="col-4">
                <div class="card mb-4">
                    <div class="card-header mb-0 pb-2">
                        <div class="row">
                            <div class="col-lg-12 col-12">
                                <h6 class="text-sm">Detail Data Program</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="mt-3 mt-lg-0 required">Nama Program</label>
                                        <input type="text" class="form-control form-control-sm" name="title" value="{{ $selectedFundraisingProgram->title }}" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label class="mt-3 mt-lg-3 required">Target Donasi</label>
                                        <input type="text" class="form-control form-control-sm" name="target_amount" value="@currency($selectedFundraisingProgram->target_amount)" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="start_date" class="mt-3 mt-lg-3 required">Tanggal Mulai</label>
                                        <input type="text" id="start_date" class="form-control form-control-sm" name="start_date" value="{{ \Carbon\Carbon::parse($selectedFundraisingProgram->start_date)->translatedFormat('d F Y') }}" readonly>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="end_date" class="mt-3 mt-lg-3 required">Tanggal Selesai</label>
                                        <input type="text" id="end_date" class="form-control form-control-sm" name="end_date" value="{{ \Carbon\Carbon::parse($selectedFundraisingProgram->end_date)->translatedFormat('d F Y') }}" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label class="mt-3 mt-lg-3 required">Status</label>
                                        <p class="text-xs ms-1 mb-0">
                                        <span class="badge d-inline-flex align-items-center {{ $selectedFundraisingProgram->status == 'completed' ? 'bg-soft-completed' : ($selectedFundraisingProgram->status == 'active' ? 'bg-soft-active' : 'bg-soft-cancelled') }}">
                                            <i class="fas {{ $selectedFundraisingProgram->status == 'completed' ? 'fa-check-circle' : ($selectedFundraisingProgram->status == 'active' ? 'fa-sync-alt' : 'fa-times-circle') }} me-1"></i>
                                            {{ $selectedFundraisingProgram->status ?? '-' }}
                                        </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <label class="mt-3 mt-lg-3 required" for="description">Keterangan</label>
                                        <textarea style="resize: none;" class="form-control form-control-sm text-justify" id="description" name="description" rows="3" readonly>{{ $selectedFundraisingProgram->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="mt-3 mt-lg-3" for="">Gambar</label>
                                <div id="image-previews-container-detail" class="d-flex flex-wrap justify-content-center gap-2 mb-3" style="gap: 0.8rem !important; overflow-x: auto;">
                                    @if($selectedFundraisingProgram->images->isEmpty())
                                        <div id="default-preview-detail" class="text-center">
                                            <img src="{{ asset('img/preview-user.png') }}" alt="Preview" style="width: 100px; height: 100px;" class="img-thumbnail">
                                            <p class="text-muted text-xs ps-1 mt-1 mb-0">Belum ada gambar</p>
                                        </div>
                                    @else
                                        @foreach($selectedFundraisingProgram->images as $image)
                                            <img src="{{ asset('storage/' . $image->image) }}" alt="Preview" style="width: 100px; height: 100px;" class="img-thumbnail">
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="row">
                    <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-uppercase text-dark font-weight-bold">Donasi Terkumpul</p>
                                            <h5 class="font-weight-bolder text-gradient text-success">
                                                @currency($selectedFundraisingProgram->total_donated)
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end menu-counts">
                                        <div class="icon icon-shape bg-gradient-success shadow-primary text-center rounded-circle">
                                            <i class="fas fa-donate text-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-uppercase text-dark font-weight-bold">Donasi Keluar</p>
                                            <h5 class="font-weight-bolder text-danger">
                                                @currency($selectedFundraisingProgram->total_expense)
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end menu-counts">
                                        <div class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                            <i class="fas fa-hand-holding-usd text-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="numbers">
                                            <p class="text-sm mb-0 text-uppercase text-dark font-weight-bold">Sisa Donasi</p>
                                            <h5 class="font-weight-bolder text-info">
                                                @currency($selectedFundraisingProgram->remaining_donations)
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="col-4 text-end menu-counts">
                                        <div class="icon icon-shape bg-gradient-info shadow-success text-center rounded-circle">
                                            <i class="fas fa-dollar-sign text-lg"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body pb-2">
                                <div class="col-12">
                                    <h6 class="text-sm mt-1">Data Transaksi Pengeluaran Program</h6>
                                    <div class="table-responsive pt-1">
                                        <table class="table align-items-center mb-0">
                                            <thead>
                                            <tr style="border-top-width: 1px;">
                                                <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-3"
                                                    style="width: 10px;">
                                                    No
                                                </th>
                                                <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Kode Pengeluaran
                                                </th>
                                                <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Tanggal
                                                </th>
                                                <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2"
                                                    style="width: 93%">
                                                    Nama Pengeluaran
                                                </th>
                                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                    style="width: 7%">
                                                    Jumlah
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if($selectedFundraisingProgram->expenses->total() < 1)
                                                <tr style="border-bottom: 1px solid #ccdddd;">
                                                    <td colspan="5">
                                                        <p class="text-center text-xs mb-0 py-1">Data tidak ditemukan.</p>
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach($selectedFundraisingProgram->expenses as $expense)
                                                    <tr>
                                                        <td>
                                                            <p class="text-center text-xs mb-0">{{ $loop->iteration + ($selectedFundraisingProgram->expenses->currentPage() - 1) * $selectedFundraisingProgram->expenses->perPage() }}</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-start text-xs mb-0">
                                                                {{ $expense->expense_code }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="text-start text-xs mb-0">
                                                                {{ \Carbon\Carbon::parse($expense->created_at)->translatedFormat('d F Y') }}
                                                            </p>
                                                        </td>
                                                        <td class="align-middle text-center text-xs">
                                                            <p class="text-start text-xs mb-0">
                                                                {{ $expense->title }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            <p class="text-center text-xs mb-0">@currency($expense->amount)</p>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                        <hr class="mt-0" style="border: 1px solid #ccdddd">
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        {!! $selectedFundraisingProgram->expenses->appends(['m_fundraising_program_id' => $selectedFundraisingProgram->id])->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body pb-2">
                                <div class="col-12">
                                    <h6 class="text-sm mt-1">Transaksi Pengeluaran Program</h6>
                                    <form action="{{ route('transaction.expenses.program-expenses.store') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="selectedFundraisingProgramId" value="{{ $selectedFundraisingProgram->id }}">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label class="mt-3 mt-lg-0 required">Nama Pengeluaran</label>
                                                <input type="text" class="form-control form-control-sm @error('title') is-invalid @enderror" placeholder="Nama pengeluaran" name="title" value="{{ old('title') }}">
                                                @error('title')
                                                <div class="invalid-feedback text-xxs ms-1">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label class="mt-3 mt-lg-0 required">Jumlah</label>
                                                <input type="text" class="form-control form-control-sm @error('amount') is-invalid @enderror @if(session('error_amount')) is-invalid @endif inputRupiah" placeholder="Jumlah" name="amount" value="{{ old('originalAmount', session('originalAmount')) }}">
                                                @error('amount')
                                                <div class="invalid-feedback text-xxs ms-1">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                                @if(session('error_amount'))
                                                    <div class="invalid-feedback text-xxs ms-1">
                                                        {{ session('error_amount') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <label class="mt-3 mt-lg-3 required" for="description">Keterangan</label>
                                                <textarea style="resize: none;" class="form-control form-control-sm @error('description') is-invalid @enderror"
                                                          id="description" name="description" rows="2" >{{ old('description') }}</textarea>
                                                @error('description')
                                                <div class="invalid-feedback text-xxs ms-1">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <button type="submit" class="btn btn-sm bg-gradient-info w-100">Simpan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
