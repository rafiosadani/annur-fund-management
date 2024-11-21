@extends('dashboard.layouts.main')

@section('breadcrumb')
    <x-breadcrumb title="Charitable Donations Data" page="Master Data" active="Charitable Donations"/>
@endsection

@section('content')
<div class="row">
    <div class="row mt-4 mt-lg-0">
        <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header mb-0 pb-0">
                        <div class="row">
                            <div class="col-lg-4 col-12">
                            <h6>Charitable Donations Data</h6>
                            </div>
                        <div class="col-lg-8 col-12 parent-button">
                            <div>
                        <button class="btn bg-gradient-primary btn-sm mb-0 btn-action" data-bs-toggle="modal" data-bs-target="#addModal">
                            +&nbsp; Tambah Data</button>
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
                                    <input type="text" class="form-control form-control-sm" name="search"
                                           id="search" value="{{ request('search') }}" placeholder="Search...">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive pt-0 px-4">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr style="border-top-width: 1px;">
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    No
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Nama
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Jenis Kelamin
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Alamat
                                </th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    No HP
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-bottom: 1px solid #ccdddd;">
                                <td colspan="6">
                                    <p class="text-center text-xs mb-0 py-1">Data tidak ditemukan.</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div></div>
                                <td>
                                <td align-middle text-xs text-end action>
                                    <a href="#"
                                        class="badge bg-gradient-info">
                                         <i class="fas fa-eye text-white"></i> &nbsp; Detail
                                     </a>
                                     <a href="#"
                                        class="mx-1 badge bg-gradient-warning">
                                         <i class="fas fa-edit text-white"></i> &nbsp; Edit
                                     </a>
                                    <button type="submit"
                                    class="badge bg-gradient-danger border-0 show-confirm-delete">
                                    <i class="fas fa-trash text-white"></i> &nbsp; Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding Data -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">3
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addForm">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="addForm">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

