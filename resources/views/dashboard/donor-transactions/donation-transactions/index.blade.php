@extends('dashboard.layouts.main')

@section('title', 'List Data Donasi')

@section('breadcrumb')
    <x-breadcrumb title="Data Donasi" page="Transaksi Donatur" active="List Data Donasi"/>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header mb-0 pb-0">
                    <div class="row">
                        <div class="col-lg-4 col-12">
                            <h6 class="mb-0">Data Donasi</h6>
                        </div>
{{--                        <div class="col-lg-8 col-12 parent-button">--}}
{{--                            <div>--}}
{{--                                <a href="{{ route('user.extend-books.generate.pdf') . '?' . http_build_query(request()->only('search', 'search_loan_date_range', 'search_return_date_range')) }}"--}}
{{--                                   class="btn bg-gradient-danger btn-sm mb-0 btn-action {{ $book_loans->total() < 1 ? 'disabled-link' : '' }}" target="_blank">--}}
{{--                                    <i class="fa fa-file-pdf-o" aria-hidden="true"></i>--}}
{{--                                    &nbsp; Export Pdf--}}
{{--                                </a>--}}
{{--                                <a href="{{ route('user.extend-books.export.excel') . '?' . http_build_query(request()->only('search', 'search_loan_date_range', 'search_return_date_range')) }}"--}}
{{--                                   class="btn bg-gradient-success btn-sm mb-0 btn-action {{ $book_loans->total() < 1 ? 'disabled-link' : '' }}" target="_blank">--}}
{{--                                    <i class="fa fa-file-excel-o" aria-hidden="true"></i>--}}
{{--                                    &nbsp; Export Excel--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    <div class="row mt-2 pb-0">
                        <form action="" method="get" class="pb-0 m-0">
                            <div class="row">
                                <div class="col-12 col-md-10 pb-2 pb-md-0">
                                    <div class="form-group mb-0">
                                        <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fa fa-search fa-sm opacity-7"></i>
                                        </span>
                                            <input type="text" class="form-control form-control-sm" name="search"
                                                   id="search" value="{{ request('search') }}" placeholder="Search..." autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-2 pb-2 pb-md-0">
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-sm text-xs bg-gradient-info">
                                            <i class="fa fa-search fa-sm"></i> &nbsp;
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-4">
                    <div class="table-responsive pt-0 px-4">
                        <table class="table align-items-center mb-0">
                            <thead>
                            <tr style="border-top: 1px solid #ccdddd;">
                                <th style="width: 3%;"
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-3">
                                    No
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 pe-0">
                                    Kode Donasi
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Tanggal Donasi
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Nama Program
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Metode
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Jumlah Donasi
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Status
                                </th>
{{--                                <th class="text-secondary opacity-7"></th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @if($donorDonations->total() < 1)
                                <tr style="border-bottom: 1px solid #ccdddd;">
                                    <td colspan="8">
                                        <p class="text-center text-xs mb-0 py-1">Data tidak ditemukan.</p>
                                    </td>
                                </tr>
                            @else
                                @foreach($donorDonations as $donorDonation)
                                    <tr style="border-bottom: 1px solid #ccdddd;">
                                        <td>
                                            <p class="text-center text-xs mb-0">{{ $loop->iteration + ($donorDonations->currentPage() - 1) * $donorDonations->perPage() }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs mb-0">{{ $donorDonation->donation_code ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs mb-0">{{ $donorDonation->created_at }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs mb-0">{{ $donorDonation->fundraisingProgram->title ?? '-' }}</p>
                                        </td>
                                        <td class="text-center text-xxs">
                                            <span class="badge d-inline-flex align-items-center {{ $donorDonation->payment_method == 'online' ? 'bg-soft-success' : ($donorDonation->payment_method == 'offline' ? 'bg-soft-info' : 'bg-soft-danger') }}">
                                                <i class="fas {{ $donorDonation->payment_method == 'online' ? 'fa-solid fa-globe' : ($donorDonation->payment_method == 'offline' ? 'fa-solid fa-handshake' : 'fa-solid fa-bomb') }} me-1"></i>
                                                {{ $donorDonation->payment_method }}
                                            </span>
                                        </td>
                                        <td>
                                            <p class="text-center text-xs mb-0">@currency($donorDonation->amount ?? 0)</p>
                                        </td>
                                        <td class="text-center text-xxs">
                                            <span class="badge d-inline-flex align-items-center {{ $donorDonation->status == 'confirmed' ? 'bg-soft-success' : ($donorDonation->status == 'pending' ? 'bg-soft-warning' : 'bg-soft-danger') }}">
                                                <i class="fas {{ $donorDonation->status == 'confirmed' ? 'fa-solid fa-check-circle' : ($donorDonation->status == 'pending' ? 'fa-solid fa-clock' : 'fa-solid fa-ban') }} me-1"></i>
                                                {{ $donorDonation->status }}
                                            </span>
                                        </td>
{{--                                        <td class="align-middle text-xs text-end action">--}}
{{--                                            <a href=""--}}
{{--                                               class="badge bg-gradient-info">--}}
{{--                                                <i class="fas fa-eye text-white"></i> &nbsp; Detail--}}
{{--                                            </a>--}}
{{--                                        </td>--}}
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end pe-4">
                        {{ $donorDonations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
