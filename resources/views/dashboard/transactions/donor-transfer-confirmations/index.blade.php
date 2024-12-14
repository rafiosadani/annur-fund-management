@extends('dashboard.layouts.main')

@section('title', 'Data Konfirmasi Transfer Donatur')

@section('breadcrumb')
    <x-breadcrumb title="Data Konfirmasi Transfer Donatur" page="Transaksi" active="Konfirmasi Transfer Donatur"/>
@endsection

@section('content')
    <div class="row">
        <div class="row mt-4 mt-lg-0">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header mb-0 pb-0">
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <h6>Data Konfirmasi Transfer Donatur</h6>
                            </div>
{{--                            <div class="col-lg-8 col-12 parent-button">--}}
{{--                                <div>--}}
{{--                                    <a href="javascript:void(0);"--}}
{{--                                       class="btn bg-gradient-primary btn-sm mb-0 btn-action" data-bs-toggle="modal"--}}
{{--                                       data-bs-target="#create-offline-donation-modal-form">--}}
{{--                                        +&nbsp; Tambah Donasi Offline--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                        <div class="row mt-2 pb-0">
                            <div class="{{ request()->has('donationRejected') ? 'col-md-9' : 'col-md-10' }} pb-0">
                                @php
                                    $actionUrl = request()->has('donationRejected') ? route('transaction.donor-transfer-confirmations.index', ['donationRejected' => 'donationRejected']) : route('transaction.donor-transfer-confirmations.index');
                                @endphp
                                <form action="{{ $actionUrl }}" method="get"
                                      class="pb-0 m-0">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-text" id="basic-addon1">
                                                        <i class="fa fa-search fa-xs opacity-7"></i>
                                                    </span>
                                                    @if(request()->has('donationRejected'))
                                                        <input type="hidden" name="donationRejected" value="donationRejected">
                                                    @endif
                                                    <input type="text" class="form-control form-control-sm" name="search"
                                                           id="search" value="{{ request('search') }}" placeholder="Search...">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="filterAnonymous"
                                                class="form-control form-control-sm dropdown-select2 mb-3" onchange="this.form.submit()">
                                                <option value="">-- Semua Donatur --</option>
                                                <option value="1" {{ request('filterAnonymous') == '1' ? 'selected' : '' }}>Anonymous</option>
                                                <option value="0" {{ request('filterAnonymous') == '0' ? 'selected' : '' }}>Tidak Anonymous</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="{{ request()->has('donationRejected') ? 'col-md-3' : 'col-md-2' }} pb-0">
                                @if(request()->has('donationRejected'))
                                    <a href="{{ route('transaction.donor-transfer-confirmations.index') }}"
                                       class="btn bg-gradient-info btn-sm mb-0 btn-action w-100">
                                        <i class="fas fa-list"></i> &nbsp; View Konfirmasi Donasi
                                    </a>
                                @else
                                    <a href="{{ route('transaction.donor-transfer-confirmations.index', ['donationRejected' => 'donationRejected']) }}"
                                       class="btn bg-gradient-warning btn-sm mb-0 btn-action w-100">
                                        <i class="fas fa-trash-restore"></i> &nbsp; View Tolak Donasi
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive pt-0 px-4">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr style="border-top-width: 1px;">
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2">
                                        No
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Kode Donasi
                                    </th>
                                    <th style="width: 15%" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Donatur
                                    </th>
                                    <th style="width: 25%"
                                        class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Program
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Status
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Jumlah Donasi
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Dibuat
                                    </th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($donorTransferConfirmations->total() < 1)
                                    <tr style="border-bottom: 1px solid #ccdddd;">
                                        <td colspan="7">
                                            <p class="text-center text-xs mb-0 py-1">Data tidak ditemukan.</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($donorTransferConfirmations as $donorTransferConfirmation)
                                        <tr style="border-bottom: 1px solid #ccdddd;">
                                            <td>
                                                <p class="text-center text-xs mb-0">{{ $loop->iteration + ($donorTransferConfirmations->currentPage() - 1) * $donorTransferConfirmations->perPage() }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <p class="text-xs text-secondary mb-0">{{ $donorTransferConfirmation->donation_code }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <p class="text-xs text-secondary mb-0">{{ isset($donorTransferConfirmation->user) ? ($donorTransferConfirmation->user->is_anonymous == 1 ? 'Anonymous' : $donorTransferConfirmation->user->name) : (isset($donorTransferConfirmation->donorProfile) ? ($donorTransferConfirmation->donorProfile->is_anonymous == 1 ? 'Anonymous' : $donorTransferConfirmation->donorProfile->name) : '') }}</p>
                                            </td>
                                            <td class="align-middle text-wrap text-justify">
                                                <p class="text-xs text-secondary mb-0">{{ $donorTransferConfirmation->fundraisingProgram->title }}</p>
                                            </td>
                                            <td class="align-middle text-center text-xs">
                                                <span class="badge d-inline-flex align-items-center {{ $donorTransferConfirmation->status == 'pending' ? 'bg-soft-warning' : 'bg-soft-danger' }}">
                                                    <i class="fas {{ $donorTransferConfirmation->status == 'pending' ? 'fa-solid fa-clock' : 'fa-solid fa-ban' }} me-1"></i>
                                                    {{ $donorTransferConfirmation->status ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <p class="text-xs text-secondary mb-0">@currency($donorTransferConfirmation->amount ?? 0)</p>
                                            </td>
                                            <td class="align-middle">
                                                <p class="text-xs font-weight-bold mb-0">{{ $donorTransferConfirmation->dibuat->name ?? 'Administrator' }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $donorTransferConfirmation->created_at }}</p>
                                            </td>
                                            <td class="align-middle text-xs text-end action">
                                                <a href="javascript:void(0)"
                                                   class="badge bg-gradient-info" data-bs-toggle="modal"
                                                   data-bs-target="#detail-donor-transfer-confirmation-modal-form-{{ $donorTransferConfirmation->id }}">
                                                    <i class="fas fa-eye text-white"></i> &nbsp; Detail
                                                </a>
                                                @if(!request()->has('donationRejected'))
                                                    <form action="{{ route('transaction.donor-transfer-confirmation.rejection', $donorTransferConfirmation->id) }}"
                                                          method="post" class="d-inline">
                                                        @csrf
                                                        @method('put')
                                                        <button type="submit"
                                                                class="badge bg-gradient-danger border-0 show-reject-donor-transfer">
                                                            <i class="fas fa-ban text-white"></i> &nbsp; Tolak
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('transaction.donor-transfer-confirmation.update', $donorTransferConfirmation->id) }}"
                                                          method="post" class="d-inline">
                                                        @csrf
                                                        @method('put')
                                                        <button type="submit"
                                                                class="badge bg-gradient-success border-0 show-confirm-donor-transfer">
                                                            <i class="fas fa-check-circle text-white"></i> &nbsp; Konfirmasi
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                        @include('dashboard.transactions.donor-transfer-confirmations.modals.show')
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end pt-3 pe-4">
                            {{ $donorTransferConfirmations->links() }}
                        </div>
                    </div>
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
                $modalId = 'create-offline-donation-modal-form';
                $errorTitle = 'Tambah Donasi Offline Error';
            } elseif (session('edit_error')) {
                $donationOfflineId = session('edit_donation_offline_id');
                $modalId = 'edit-offline-donation-modal-form-' . $donationOfflineId;
                $errorTitle = 'Edit Donasi Offline Error';
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
