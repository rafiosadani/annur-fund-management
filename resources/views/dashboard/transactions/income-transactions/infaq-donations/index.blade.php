@extends('dashboard.layouts.main')

@section('title', 'Transaksi Dana Infaq')

@section('breadcrumb')
    <x-breadcrumb title="Transaksi Dana Infaq" page="Transaksi" active="Dana Infaq"/>
@endsection

@section('content')
    <div class="row">
        <div class="row mt-4 mt-lg-0">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header mb-0 pb-0">
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <h6>Transaksi Dana Infaq</h6>
                            </div>
                            <div class="col-lg-8 col-12 parent-button">
                                <div>
                                    <a href="javascript:void(0);"
                                       class="btn bg-gradient-primary btn-sm mb-0 btn-action" data-bs-toggle="modal" data-bs-target="#create-infaq-donation-modal-form">
                                        +&nbsp; Transaksi Dana Infaq
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
                                        Kode Dana Infaq
                                    </th>
                                    <th style="width: 25%;" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama Infaq - Jenis Infaq
                                    </th>
                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                        Jumlah
                                    </th>
                                    <th style="width: 20%;" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Keterangan
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Dibuat
                                    </th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($infaqDonations->total() < 1)
                                    <tr style="border-bottom: 1px solid #ccdddd;">
                                        <td colspan="7">
                                            <p class="text-center text-xs mb-0 py-1">Data tidak ditemukan.</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($infaqDonations as $infaqDonation)
                                        <tr style="border-bottom: 1px solid #ccdddd;">
                                            <td>
                                                <p class="text-center text-xs mb-0">{{ $loop->iteration + ($infaqDonations->currentPage() - 1) * $infaqDonations->perPage() }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <p class="text-xs text-secondary mb-0">{{ $infaqDonation->infaq_code }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <p class="text-xs text-secondary mb-0">{{ $infaqDonation->name ?? '-' }}</p>
                                                <p class="text-xs text-secondary font-weight-bold mb-0">Jenis Infaq : {{ $infaqDonation->infaqType->type_name ?? '-' }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <p class="text-xs text-secondary mb-0">@currency($infaqDonation->amount ?? 0)</p>
                                            </td>
                                            <td class="text-xs text-wrap text-justify">
                                                <p class="text-xs mb-0"> {{ $infaqDonation->note }}</p>
                                            </td>
                                            <td class="align-middle text-wrap">
                                                <p class="text-xs font-weight-bold mb-0">{{ $infaqDonation->dibuat->name ?? 'Administrator' }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $infaqDonation->created_at }}</p>
                                            </td>
                                            <td class="align-middle text-xs text-end action">
                                                <a href="javascript:void(0);"
                                                   class="mx-1 badge bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#edit-infaq-donation-modal-form-{{ $infaqDonation->id }}">
                                                    <i class="fas fa-edit text-white"></i> &nbsp; Edit
                                                </a>
                                                <form action="{{ route('transaction.infaq-donations.destroy', $infaqDonation->id) }}"
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
                                        @include('dashboard.transactions.income-transactions.infaq-donations.modals.edit')
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end pt-3 pe-4">
                            {{ $infaqDonations->links() }}
                        </div>
                    </div>
                    @include('dashboard.transactions.income-transactions.infaq-donations.modals.create')
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
                $modalId = 'create-infaq-donation-modal-form';
                $errorTitle = 'Tambah Transaksi Dana Infaq Error';
            } elseif (session('edit_error')) {
                $goodId = session('edit_infaq_donation_id');
                $modalId = 'edit-infaq-donation-modal-form-' . $goodId;
                $errorTitle = 'Edit Transaksi Dana Infaq Error';
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