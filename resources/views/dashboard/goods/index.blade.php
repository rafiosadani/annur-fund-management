@extends('dashboard.layouts.main')

@section('title', 'Data Barang')

@section('breadcrumb')
    <x-breadcrumb title="Data Barang" page="Master Data" active="Barang"/>
@endsection

@section('content')
    <div class="row">
        <div class="row mt-4 mt-lg-0">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header mb-0 pb-0">
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <h6>Data Barang</h6>
                            </div>
                            <div class="col-lg-8 col-12 parent-button">
                                <div>
                                    @if(request()->has('view_deleted'))
                                        <a href="{{ route('good-inventories.index') }}"
                                           class="btn bg-gradient-info btn-sm mb-0 btn-action">
                                            <i class="fa fa-list"></i> &nbsp; View All Barang
                                        </a>
                                        @if($goods->total() < 1)
                                            <a href="{{ route('goods.restore.all') }}"
                                               class="btn bg-gradient-primary btn-sm mb-0 disabled btn-action show-confirm-restore-all">
                                                <i class="fa fa-undo"></i> &nbsp; Restore All
                                            </a>
                                        @else
                                            <a href="{{ route('goods.restore.all') }}"
                                               class="btn bg-gradient-primary btn-sm mb-0 btn-action show-confirm-restore-all">
                                                <i class="fa fa-undo"></i> &nbsp; Restore All
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('good-inventories.index', ['view_deleted' => 'DeletedRecords']) }}"
                                           class="btn bg-gradient-info btn-sm mb-0 btn-action">
                                            <i class="fas fa-trash-restore"></i> &nbsp; View Delete Records
                                        </a>
                                        <a href="javascript:void(0);"
                                           class="btn bg-gradient-primary btn-sm mb-0 btn-action" data-bs-toggle="modal" data-bs-target="#create-good-modal-form">
                                            +&nbsp; Tambah Barang
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @php
                            $actionUrl = request()->has('view_deleted') ? route('good-inventories.index', ['view_deleted' => 'DeletedRecords']) : route('good-inventories.index');
                        @endphp
                        <div class="row mt-2 pb-0">
                            <form action="{{ $actionUrl }}" method="get" class="pb-0 m-0">
                                <div class="col-md-12 pb-0">
                                    <div class="form-group">
                                        <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fa fa-search fa-xs opacity-7"></i>
                                        </span>
                                            @if(request()->has('view_deleted'))
                                                <input type="hidden" name="view_deleted" value="DeletedRecords">
                                            @endif
                                            <input type="text" class="form-control form-control-sm" name="search"
                                                   id="search" value="{{ request('search') }}" placeholder="Search...">
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
                                        Kode Barang
                                    </th>
                                    <th style="width: 15%;" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Nama Barang
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Merk
                                    </th>
                                    <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7">
                                        Jumlah
                                    </th>
                                    <th style="width: 30%;" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Deskripsi
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Dibuat
                                    </th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($goods->total() < 1)
                                    <tr style="border-bottom: 1px solid #ccdddd;">
                                        <td colspan="8">
                                            <p class="text-center text-xs mb-0 py-1">Data tidak ditemukan.</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($goods as $good)
                                        <tr style="border-bottom: 1px solid #ccdddd;">
                                            <td>
                                                <p class="text-center text-xs mb-0">{{ $loop->iteration + ($goods->currentPage() - 1) * $goods->perPage() }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <p class="text-xs text-secondary mb-0">{{ $good->good_inventory_code }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <p class="text-xs text-secondary mb-0">{{ $good->item_name ?? '-' }}</p>
                                            </td>
                                            <td class="align-middle text-wrap text-justify">
                                                <p class="text-xs text-secondary mb-0">{{ $good->merk ?? '-' }}</p>
                                            </td>
                                            <td class="align-middle text-center">
                                                <p class="text-xs text-secondary mb-0">{{ $good->quantity }}</p>
                                            </td>
                                            <td class="text-xs text-wrap text-justify">
                                                <p class="text-xs mb-0"> {{ $good->description }}</p>
                                            </td>
                                            <td class="align-middle text-wrap">
                                                <p class="text-xs font-weight-bold mb-0">{{ $good->dibuat->name ?? 'Administrator' }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $good->created_at }}</p>
                                            </td>
                                            <td class="align-middle text-xs text-end action">
                                                @if(request()->has('view_deleted'))
                                                    <a href="{{ route('goods.restore', $good->id) }}"
                                                       class="mx-1 badge bg-gradient-success show-confirm-restore">
                                                        <i class="fa fa-check text-white"></i> &nbsp; Restore
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0)"
                                                       class="badge bg-gradient-info" data-bs-toggle="modal" data-bs-target="#detail-good-modal-form-{{ $good->id }}">
                                                        <i class="fas fa-eye text-white"></i> &nbsp; Detail
                                                    </a>
                                                    <a href="javascript:void(0);"
                                                       class="mx-1 badge bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#edit-good-modal-form-{{ $good->id }}">
                                                        <i class="fas fa-edit text-white"></i> &nbsp; Edit
                                                    </a>
                                                    <form action="{{ route('good-inventories.destroy', $good->id) }}"
                                                          method="post" class="d-inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit"
                                                                class="badge bg-gradient-danger border-0 show-confirm-delete">
                                                            <i class="fas fa-trash text-white"></i> &nbsp; Hapus
                                                        </button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                        @include('dashboard.goods.modals.show')
                                        @include('dashboard.goods.modals.edit')
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end pt-3 pe-4">
                            {{ $goods->links() }}
                        </div>
                    </div>
                    @include('dashboard.goods.modals.create')
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
                $modalId = 'create-good-modal-form';
                $errorTitle = 'Tambah Barang Error';
            } elseif (session('edit_error')) {
                $goodId = session('edit_good_id');
                $modalId = 'edit-good-modal-form-' . $goodId;
                $errorTitle = 'Edit Barang Error';
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
