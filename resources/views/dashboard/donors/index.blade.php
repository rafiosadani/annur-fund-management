@extends('dashboard.layouts.main')

@section('title', 'Data Donatur')

@section('breadcrumb')
    <x-breadcrumb title="Data Donatur" page="Master Data" active="Data Donatur"/>
@endsection

@section('content')
    <div class="row">
        <div class="row mt-4 mt-lg-0">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header mb-0 pb-0">
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <h6>Data Donatur</h6>
                            </div>
                            <div class="col-lg-8 col-12 parent-button">
                                <div>
                                    <a href="javascript:void(0);"
                                       class="btn bg-gradient-primary btn-sm mb-0 btn-action" data-bs-toggle="modal" data-bs-target="#create-donor-modal-form">
                                        +&nbsp; Tambah Donatur
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2 pb-0">
                            <form action="{{ route('donors.index') }}" method="get" class="pb-0 m-0">
                                <div class="col-md-12 pb-0">
                                    <div class="form-group">
                                        <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fa fa-search fa-xs opacity-7"></i>
                                        </span>
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Nama
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Kode User
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        No Hp
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Alamat
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Dibuat
                                    </th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($donors->total() < 1)
                                    <tr style="border-bottom: 1px solid #ccdddd;">
                                        <td colspan="6">
                                            <p class="text-center text-xs mb-0 py-1">Data tidak ditemukan.</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($donors as $donor)
                                        <tr style="border-bottom: 1px solid #ccdddd;">
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div>
                                                        @if($donor->image !== 'default.png')
                                                            @php
                                                                $dataImage = explode("/", $donor->image);
                                                                $imageUrl = ($dataImage[0] == 'donors') ? asset('img/' . $donor->image) : asset('storage/' . $donor->image);
                                                            @endphp
                                                        @else
                                                            @php $imageUrl = asset('img/' . $donor->image); @endphp
                                                        @endif
                                                        <img src="{{ $imageUrl }}"
                                                             class="avatar avatar me-3 shadow"
                                                             alt="user-image-profile">
                                                    </div>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="mb-0 text-sm text-bold">{{ $donor->name }}</p>
                                                        <p class="text-xs text-secondary mb-0">{{ $donor->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <p class="text-xs text-secondary mb-0">{{ $donor->user_code }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <p class="text-xs text-secondary mb-0">{{ $donor->phone ?? '-' }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <p class="text-xs text-secondary mb-0">{{ $donor->address ?? '-' }}</p>
                                            </td>
                                            <td class="align-middle">
                                                <p class="text-xs font-weight-bold mb-0">{{ $donor->dibuat->name ?? 'Administrator' }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $donor->created_at }}</p>
                                            </td>
                                            <td class="align-middle text-xs text-end action">
                                                <a href="javascript:void(0)"
                                                   class="badge bg-gradient-info" data-bs-toggle="modal" data-bs-target="#detail-donor-modal-form{{ $donor->id }}">
                                                    <i class="fas fa-eye text-white"></i> &nbsp; Detail
                                                </a>
                                                <a href="javascript:void(0);"
                                                   class="mx-1 badge bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#edit-donor-modal-form{{ $donor->id }}">
                                                    <i class="fas fa-edit text-white"></i> &nbsp; Edit
                                                </a>
                                                <form action="{{ route('donors.destroy', $donor->id) }}"
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
                                        @include('dashboard.donors.modals.show')
                                        @include('dashboard.donors.modals.edit')
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end pt-3 pe-4">
                            {{ $donors->links() }}
                        </div>
                    </div>
                    @include('dashboard.donors.modals.create')
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
            @if (session('create_error'))
            // Show Create Form Modal
            var myModal = new bootstrap.Modal(document.getElementById('create-donor-modal-form'));
            myModal.show();

            // Show SweetAlert for Create Form Errors
            setTimeout(function () {
                Swal.fire({
                    title: 'Tambah Data Donatur Error',
                    icon: 'error',
                    html: `
                                @foreach ($errors->all() as $error)
                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                    `
                }).then(() => {
                    @php session()->forget('create_error'); @endphp
                });
            }, 100);
            @elseif (session('edit_error'))
            // Show Edit Form Modal for specific role
            var donorId = '{{ session('edit_donor_id') }}';
            var myModalEdit = new bootstrap.Modal(document.getElementById('edit-donor-modal-form' + donorId));
            myModalEdit.show();

            // Show SweetAlert for Edit Form Errors
            setTimeout(function () {
                Swal.fire({
                    title: 'Edit Data Donor Error',
                    icon: 'error',
                    html: `
                                @foreach ($errors->all() as $error)
                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                    `
                }).then(() => {
                    @php session()->forget('edit_donor_id'); @endphp
                    @php session()->forget('edit_error'); @endphp
                });
            }, 100);
            @endif
            @endif
        });
    </script>
@endsection
