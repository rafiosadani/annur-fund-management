@extends('dashboard.layouts.main')

@section('title', 'Master Role')

@section('breadcrumb')
    <x-breadcrumb title="Data Role" page="Master Data" active="Role"/>
@endsection

@section('content')
    <div class="row">
        <div class="row mt-4 mt-lg-0">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header mb-0 pb-0">
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <h6>Data Role</h6>
                            </div>
                            <div class="col-lg-8 col-12 parent-button">
                                <div>
                                    @if(request()->has('view_deleted'))
                                        <a href="{{ route('roles.index') }}"
                                           class="btn bg-gradient-info btn-sm mb-0 btn-action">
                                            <i class="fa fa-list"></i> &nbsp; View All Role
                                        </a>
                                        @if($roles->total() < 1)
                                            <a href="{{ route('roles.restore.all') }}"
                                               class="btn bg-gradient-primary btn-sm mb-0 disabled btn-action show-confirm-restore-all">
                                                <i class="fa fa-undo"></i> &nbsp; Restore All
                                            </a>
                                        @else
                                            <a href="{{ route('roles.restore.all') }}"
                                               class="btn bg-gradient-primary btn-sm mb-0 btn-action show-confirm-restore-all">
                                                <i class="fa fa-undo"></i> &nbsp; Restore All
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('roles.index', ['view_deleted' => 'DeletedRecords']) }}"
                                           class="btn bg-gradient-info btn-sm mb-0 btn-action">
                                            <i class="fas fa-trash-restore"></i> &nbsp; View Delete Records
                                        </a>
                                        <a href="javascript:void(0);"
                                           class="btn bg-gradient-primary btn-sm mb-0 btn-action" data-bs-toggle="modal" data-bs-target="#create-role-modal-form">
                                            +&nbsp; Tambah Role
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @php
                            $actionUrl = request()->has('view_deleted') ? route('roles.index', ['view_deleted' => 'DeletedRecords']) : route('roles.index');
                        @endphp
                        <div class="row mt-2 pb-0">
                            <form action="" method="get" class="pb-0 m-0">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-2">
                                        No
                                    </th>
                                    <th style="width: 50%;" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Role
                                    </th>
                                    <th style="width: 20%;" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Guard Name
                                    </th>
                                    <th style="width: 17%;" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Dibuat
                                    </th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($roles->total() < 1)
                                    <tr style="border-bottom: 1px solid #ccdddd;">
                                        <td colspan="5">
                                            <p class="text-center text-xs mb-0 py-1">Data tidak ditemukan.</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($roles as $role)
                                        <tr style="border-bottom: 1px solid #ccdddd;">
                                            <td>
                                                <p class="text-center text-xs mb-0">{{ $loop->iteration + ($roles->currentPage() - 1) * $roles->perPage() }}</p>
                                            </td>
                                            <td>
                                                <p class="text-xs text-secondary ps-3 mb-0">{{ $role->name }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <p class="text-xs text-secondary mb-0">{{ $role->guard_name }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <p class="text-xs font-weight-bold mb-0">{{ $role->dibuat->name ?? 'Administrator' }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $role->created_at }}</p>
                                            </td>
                                            <td class="align-middle text-xs text-end action">
                                                @if(request()->has('view_deleted'))
                                                    <a href="{{ route('roles.restore', $role->id) }}"
                                                       class="mx-1 badge bg-gradient-success show-confirm-restore">
                                                        <i class="fa fa-check text-white"></i> &nbsp; Restore
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#detail-role-modal-form{{$role->id}}"
                                                       class="badge bg-gradient-info">
                                                        <i class="fas fa-eye text-white"></i> &nbsp; Detail
                                                    </a>
                                                    <a href="javascript:void(0);"
                                                       class="mx-1 badge bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#edit-role-modal-form{{$role->id}}">
                                                        <i class="fas fa-edit text-white"></i> &nbsp; Edit
                                                    </a>
                                                    <form action="{{ route('roles.destroy', $role->id) }}"
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
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end pt-3 pe-4">
                            {{ $roles->links() }}
                        </div>
                    </div>
                    @include('dashboard.roles.modals.create')
                    @foreach($roles as $role)
                        @include('dashboard.roles.modals.show')
                        @include('dashboard.roles.modals.edit')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Trigger page refresh when any modal is closed
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function () {
                    location.reload(); // This will refresh the page
                });
            });

            @if ($errors->any())
                @if(session('create_error'))
                    // Show Create Form Modal
                    var myModal = new bootstrap.Modal(document.getElementById('create-role-modal-form'));
                    myModal.show();

                    // Show SweetAlert for Create Form Errors
                    setTimeout(function () {
                        Swal.fire({
                            title: 'Create Form Error',
                            icon: 'error',
                            html: `
                                    @foreach ($errors->all() as $error)
                                        <p class="mb-0">{{ $error }}</p>
                                    @endforeach
                            `
                        });
                    }, 100);
                @elseif(session('edit_error'))
                    // Show Edit Form Modal for specific role
                    var roleId = '{{ session('edit_role_id') }}';
                    var myModalEdit = new bootstrap.Modal(document.getElementById('edit-role-modal-form' + roleId));
                    myModalEdit.show();

                    // Show SweetAlert for Edit Form Errors
                    setTimeout(function () {
                        Swal.fire({
                            title: 'Edit Form Error',
                            icon: 'error',
                            html: `
                                    @foreach ($errors->all() as $error)
                                        <p class="mb-0">{{ $error }}</p>
                                    @endforeach
                            `
                        });
                    }, 100);
                @endif
            @elseif (session('create_error') && session('error'))
                var createModal = new bootstrap.Modal(document.getElementById('create-role-modal-form'));
                createModal.show();

                setTimeout(function () {
                    Swal.fire({
                        title: 'Error',
                        icon: 'error',
                        html: `<p class="mb-0">{{ session('error') }}</p>`
                    }).then(() => {
                        // Remove the session after showing the modal
                        @php session()->forget('create_error'); @endphp
                    });
                }, 100);
            @elseif (session('edit_error') && session('error'))
                var roleId = '{{ session('edit_role_id') }}';
                var myModalEdit = new bootstrap.Modal(document.getElementById('edit-role-modal-form' + roleId));
                myModalEdit.show();

                setTimeout(function () {
                    Swal.fire({
                        title: 'Error',
                        icon: 'error',
                        html: `<p class="mb-0">{{ session('error') }}</p>`
                    }).then(() => {
                        // Remove the session after showing the modal
                        @php session()->forget('edit_error'); @endphp
                        @php session()->forget('edit_role_id'); @endphp
                    });
                }, 100)
            @endif
        });
    </script>
@endsection







