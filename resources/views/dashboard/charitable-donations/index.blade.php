@extends('dashboard.layouts.main')

@section('breadcrumb')
    <x-breadcrumb title="Data Jenis Infaq" page="Master Data" active="Jenis Infaq"/>
@endsection

@section('content')
<div class="row">
    <div class="row mt-4 mt-lg-0">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header mb-0 pb-0">
                    <div class="row">
                        <div class="col-lg-4 col-12">
                            <h6>Data Jenis Infaq</h6>
                        </div>
                        <div class="col-lg-8 col-12 parent-button">
                            <div>
                                <button class="btn bg-gradient-primary btn-sm mb-0 btn-action" data-bs-toggle="modal" data-bs-target="#create-infaq-modal-form">
                                    +&nbsp; Tambah Data
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Search Form -->
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

                <!-- Table -->
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive pt-0 px-4">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr style="border-top-width: 1px;">
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deskripsi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($infaqTypes as $infaqType)
                                    <tr>
                                        <td class="text-xs ps-4">{{ $infaqType->type_name }}</td>
                                        <td class="text-xs ps-4">{{ $infaqType->description }}</td>
                                        <td class="text-xs ps-4">
                                            <a href="#" class="badge bg-gradient-info"><i class="fas fa-eye text-white"></i> &nbsp; Detail</a>
                                            <a href="javascript:void(0);" class="mx-1 badge bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#edit-infaq-modal-form{{ $infaqType->id }}">
                                                <i class="fas fa-edit text-white"></i> &nbsp; Edit
                                            </a>
                                            <form action="{{ route('infaq.destroy', $infaqType->id) }}"
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
                                     <!-- Include Modal for Adding Data -->
                                    @include('dashboard.charitable-donations.modals.create')
                                    @include('dashboard.charitable-donations.modals.edit')
                                @endforeach
                                @if($infaqTypes->isEmpty())
                                    <tr>
                                        <td colspan="4">
                                            <p class="text-center text-xs mb-0 py-1">Data tidak ditemukan.</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <!-- Pagination -->
                        {{ $infaqTypes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
