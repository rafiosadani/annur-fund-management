@extends('dashboard.layouts.main')

@section('title', 'Transaksi Pengeluaran Umum')

@section('breadcrumb')
    <x-breadcrumb title="Transaksi Pengeluaran Umum" page="Transaksi" active="Pengeluaran Umum"/>
@endsection

@section('content')
    <div class="row">
        <div class="row">
            <div class="col-xl-4 col-sm-4 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase text-dark font-weight-bold">Total Pemasukan</p>
                                    <h5 class="font-weight-bolder text-gradient text-success mb-0">
                                        @currency($totalInfaq ?? 0)
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
                                    <p class="text-sm mb-0 text-uppercase text-dark font-weight-bold">Total Pengeluaran</p>
                                    <h5 class="font-weight-bolder text-danger mb-0">
                                        @currency($totalGeneralExpenses)
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
                                    <p class="text-sm mb-0 text-uppercase text-dark font-weight-bold">Saldo Akhir</p>
                                    <h5 class="font-weight-bolder text-info mb-0">
                                        @currency($endingBalance ?? 0)
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
        <div class="row mt-4 mt-lg-3">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header mb-0 pb-0">
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <h6>Data Pengeluaran Umum</h6>
                            </div>
                            <div class="col-lg-8 col-12 parent-button">
                                <div>
                                    <a href="javascript:void(0);"
                                       class="btn bg-gradient-primary btn-sm mb-0 btn-action" data-bs-toggle="modal" data-bs-target="#create-general-expense-modal-form">
                                        +&nbsp; Transaksi Pengeluaran Umum
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
                                        Kode Pengeluaran
                                    </th>
                                    <th style="width: 25%;" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama Pengeluaran
                                    </th>
                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                        Jumlah
                                    </th>
                                    <th style="width: 20%;" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Deskripsi
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Dibuat
                                    </th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($generalExpenses->total() < 1)
                                    <tr style="border-bottom: 1px solid #ccdddd;">
                                        <td colspan="7">
                                            <p class="text-center text-xs mb-0 py-1">Data tidak ditemukan.</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($generalExpenses as $generalExpense)
                                        <tr style="border-bottom: 1px solid #ccdddd;">
                                            <td>
                                                <p class="text-center text-xs mb-0">{{ $loop->iteration + ($generalExpenses->currentPage() - 1) * $generalExpenses->perPage() }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <p class="text-xs text-secondary mb-0">{{ $generalExpense->expense_code }}</p>
                                            </td>
                                            <td class="align-middle text-wrap text-justify">
                                                <p class="text-xs text-secondary mb-0">{{ $generalExpense->title ?? '-' }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <p class="text-xs text-secondary mb-0">@currency($generalExpense->amount ?? 0)</p>
                                            </td>
                                            <td class="text-xs text-wrap text-justify">
                                                <p class="text-xs mb-0"> {{ $generalExpense->description }}</p>
                                            </td>
                                            <td class="align-middle text-wrap">
                                                <p class="text-xs font-weight-bold mb-0">{{ $generalExpense->dibuat->name ?? 'Administrator' }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $generalExpense->created_at }}</p>
                                            </td>
                                            <td class="align-middle text-xs text-end action">
                                                <a href="javascript:void(0);"
                                                   class="mx-1 badge bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#edit-general-expense-modal-form-{{ $generalExpense->id }}">
                                                    <i class="fas fa-edit text-white"></i> &nbsp; Edit
                                                </a>
                                                <form action="{{ route('transaction.expenses.general-expenses.destroy', $generalExpense->id) }}"
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
                                        @include('dashboard.transactions.expense-transactions.general-expenses.modals.edit')
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end pt-3 pe-4">
                            {{ $generalExpenses->links() }}
                        </div>
                    </div>
                    @include('dashboard.transactions.expense-transactions.general-expenses.modals.create')
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
    @if ($errors->any() || session('create_amount_error'))
        @php
//            $sessionKey = session('create_error') ? 'create_error' : (session('edit_error') ? 'edit_error' : null);
            $sessionKey = session('create_error') ? 'create_error': (session('create_amount_error') ? 'create_amount_error' : (session('edit_error') ? 'edit_error' : null));
            $errorMessages = $errors->all();
            $modalId = null;
            $errorTitle = null;

            if (session('create_error')) {
                $modalId = 'create-general-expense-modal-form';
                $errorTitle = 'Tambah Transaksi Pengeluaran Umum Error';
            } elseif (session('create_amount_error')) {
                if(session('edit_general_expense_id')) {
                    $generalExpenseId = session('edit_general_expense_id');
                    $modalId = 'edit-general-expense-modal-form-' . $generalExpenseId;
                    $errorTitle = 'Edit Transaksi Pengeluaran Umum Error';
                } else {
                    $modalId = 'create-general-expense-modal-form';
                    $errorTitle = 'Tambah Transaksi Pengeluaran Umum Error';
                }
            } elseif (session('edit_error')) {
                $generalExpenseId = session('edit_general_expense_id');
                $modalId = 'edit-general-expense-modal-form-' . $generalExpenseId;
                $errorTitle = 'Edit Transaksi Pengeluaran Umum Error';
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
//            $sessionKey = session('create_error') ? 'create_error' : (session('edit_error') ? 'edit_error' : null);
            $sessionKey = session('create_error') ? 'create_error': (session('create_amount_error') ? 'create_amount_error' : (session('edit_error') ? 'edit_error' : null));
            if ($sessionKey) {
                session()->forget($sessionKey);
            }
        @endphp
    @endif
@endsection
