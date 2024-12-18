@extends('dashboard.layouts.main')

@section('title', 'Transaksi Donasi Barang')

@section('breadcrumb')
    <x-breadcrumb title="Transaksi Donasi Barang" page="Transaksi" active="Donasi Barang"/>
@endsection

@section('content')
    <div class="row">
        <div class="row mt-4 mt-lg-0">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header mb-0 pb-0">
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <h6>Transaksi Donasi Barang</h6>
                            </div>
                            <div class="col-lg-8 col-12 parent-button">
                                <div>
                                    <a href="javascript:void(0);"
                                       class="btn bg-gradient-primary btn-sm mb-0 btn-action" data-bs-toggle="modal" data-bs-target="#create-good-donation-modal-form">
                                        +&nbsp; Transaksi Donasi Barang
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2 pb-0">
                            <form action="" method="get" class="pb-0 m-0">
                                <div class="col-md-12 pb-0">
                                    <div class="form-group">
                                        <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fa fa-search fa-xs opacity-7"></i>
                                        </span>
                                            <input type="text" class="form-control form-control-sm" name="search" id="search" value="{{ request('search') }}" placeholder="Search...">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive pt-0 px-4">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr style="border-top-width: 1px;">
                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7 px-2">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Kode Donasi Barang
                                    </th>
                                    <th style="width: 10%;" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama Barang
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama Donatur
                                    </th>
                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                        Jumlah
                                    </th>
                                    <th style="width: 22%;" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Keterangan
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Dibuat
                                    </th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($goodDonations->total() < 1)
                                    <tr style="border-bottom: 1px solid #ccdddd;">
                                        <td colspan="8">
                                            <p class="text-center text-xs mb-0 py-1">Data tidak ditemukan.</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($goodDonations as $goodDonation)
                                        <tr style="border-bottom: 1px solid #ccdddd;">
                                            <td>
                                                <p class="text-center text-xs mb-0">{{ $loop->iteration + ($goodDonations->currentPage() - 1) * $goodDonations->perPage() }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <p class="text-xs text-secondary mb-0">{{ $goodDonation->good_donation_code }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <p class="text-xs text-secondary mb-0">{{ $goodDonation->good->item_name ?? '-' }}</p>
                                            </td>
                                            <td class="align-middle text-wrap text-justify">
                                                <p class="text-xs text-secondary mb-0">{{ $goodDonation->user->name ?? '-' }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <p class="text-xs text-secondary mb-0">{{ $goodDonation->quantity }}</p>
                                            </td>
                                            <td class="text-xs text-wrap text-justify">
                                                <p class="text-xs mb-0"> {{ $goodDonation->note }}</p>
                                            </td>
                                            <td class="align-middle text-wrap">
                                                <p class="text-xs font-weight-bold mb-0">{{ $goodDonation->dibuat->name ?? 'Administrator' }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $goodDonation->created_at }}</p>
                                            </td>
                                            <td class="align-middle text-xs text-end action">
                                                <a href="javascript:void(0)"
                                                   class="badge bg-gradient-info" data-bs-toggle="modal" data-bs-target="#detail-good-donation-modal-form-{{ $goodDonation->id }}">
                                                    <i class="fas fa-eye text-white"></i> &nbsp; Detail
                                                </a>
                                                <a href="javascript:void(0);"
                                                   class="mx-1 badge bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#edit-good-donation-modal-form-{{ $goodDonation->id }}">
                                                    <i class="fas fa-edit text-white"></i> &nbsp; Edit
                                                </a>
                                                <form action="{{ route('good-donations.destroy', $goodDonation->id) }}"
                                                      method="post" class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit"
                                                            class="badge bg-gradient-danger border-0 show-confirm-delete">
                                                        <i class="fas fa-trash text-white"></i> &nbsp; Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
{{--                                        @include('dashboard.goods.modals.show')--}}
                                        @include('dashboard.transactions.goods-transaction.modals.edit')
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end pt-3 pe-4">
                            {{ $goodDonations->links() }}
                        </div>
                    </div>
                    @include('dashboard.transactions.goods-transaction.modals.create')
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Trigger page refresh when any modal is closed
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function () {
                    location.reload(); // This will refresh the page
                });
            });
        });
    </script>
    @if ($errors->any())
        @php
            $sessionKey = session('create_error') ? 'create_error' : (session('edit_error') ? 'edit_error' : null);
            $errorMessages = $errors->all();
            $modalId = null;
            $errorTitle = null;

            if (session('create_error')) {
                $modalId = 'create-good-donation-modal-form';
                $errorTitle = 'Tambah Transaksi Donasi Barang Error';
            } elseif (session('edit_error')) {
                $goodId = session('edit_good_donation_id');
                $modalId = 'edit-good-donation-modal-form-' . $goodId;
                $errorTitle = 'Edit Transaksi Donasi Barang Error';
            }
        @endphp

        @if ($modalId && $errorTitle)
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var errorMessages = @json($errorMessages);
                    handleModalWithErrors('{{ $modalId }}', '{{ $sessionKey }}', '{{ $errorTitle }}', errorMessages, true);
                });
            </script>
        @endif

        @php
            $sessionKey = session('create_error') ? 'create_error' : (session('edit_error') ? 'edit_error' : null);
            if ($sessionKey) {
                session()->forget($sessionKey);
            }
        @endphp
    @endif
@endsection
