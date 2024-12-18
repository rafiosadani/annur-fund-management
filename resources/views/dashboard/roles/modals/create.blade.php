<div class="modal fade" id="create-role-modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Tambah Data Role</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" action="{{ route('roles.store') }}" method="post">
                @csrf
                <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-12 col-lg-12">
                                    <label for="name">Nama Role</label>
                                    <input type="text" name="name" id="name" class="form-control form-control-sm @error('name') is-invalid @enderror" value="{{ old('name') }}" />
                                    @error('name')
                                    <div class="invalid-feedback text-xxs ms-1">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 col-lg-12">
                                    <label>Permission</label>
                                </div>
                                <hr class="horizontal dark my-lg-2 m-0">
                                <div class="col-12 col-lg-12">
                                    <h6 class="font-weight-bolder text-xs ps-1">Dashboard</h6>
                                    <div class="row">
                                        <div class="table-responsive pt-0 px-3">
                                            <table class="table align-items-center mb-0">
                                                <thead>
                                                <tr style="border-top-width: 1px;">
                                                    <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-1"
                                                        style="width: 93%">
                                                        Fitur
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                        style="width: 7%">
                                                        Akses
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($dashboards as $key => $dashboardsPermissions)
                                                    <tr>
                                                        <td class="ps-1">
                                                            <p class="mb-0 text-xs text-dark text-start">{{ ucwords(str_replace('-', ' ', $key)) }}</p>
                                                        </td>
                                                        @foreach($dashboardsPermissions as $permission)
                                                            <td class="text-center">
                                                                <div class="form-check form-switch d-inline-block align-middle">
                                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <hr class="mt-0" style="border: 1px solid #ccdddd">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark my-lg-2 m-0">
                                <div class="col-12 col-lg-12">
                                    <h6 class="font-weight-bolder text-xs ms-1">User</h6>
                                    <div class="row">
                                        <div class="table-responsive pt-0 px-3">
                                            <table class="table align-items-center mb-0">
                                                <thead>
                                                <tr style="border-top-width: 1px;">
                                                    <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-1"
                                                        style="width: 86%">
                                                        Fitur
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                        style="width: 7%">
                                                        Akses
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                        style="width: 7%">
                                                        Update
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($users as $key => $usersPermissions)
                                                    <tr>
                                                        <td class="ps-1">
                                                            <p class="mb-0 text-xs text-dark text-start">{{ ucwords(str_replace('-', ' ', $key)) }}</p>
                                                        </td>
                                                        @foreach($usersPermissions as $permission)
                                                            <td class="text-center">
                                                                <div class="form-check form-switch d-inline-block align-middle">
                                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <hr class="mt-0" style="border: 1px solid #ccdddd">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark my-lg-2 m-0">
                                <div class="col-12 col-lg-12">
                                    <label class="font-weight-bolder text-xs">Master Data</label>
                                    <div class="row">
                                        <div class="table-responsive pt-0 px-3">
                                            <table class="table align-items-center mb-0">
                                                <thead>
                                                <tr style="border-top-width: 1px;">
                                                    <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-1" style="width: 72%">
                                                        Fitur
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 7%">
                                                        Akses
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 7%">
                                                        Create
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 7%">
                                                        Update
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" style="width: 7%">
                                                        Delete
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($masters as $key => $mastersPermission)
                                                    <tr>
                                                        <td class="ps-1">
                                                            <p class="mb-0 text-xs text-dark text-start">{{ ucwords(str_replace('-', ' ', $key)) }}</p>
                                                        </td>
                                                        @foreach($mastersPermission as $permission)
                                                            <td class="text-center">
                                                                <div class="form-check form-switch d-inline-block align-middle">
                                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <hr class="mt-0" style="border: 1px solid #ccdddd">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark my-lg-2 m-0">
                                <div class="col-12 col-lg-12">
                                    <h6 class="font-weight-bolder text-xs ms-1">Transaksi Pemasukan</h6>
                                    <div class="row">
                                        <div class="table-responsive pt-0 px-3">
                                            <table class="table align-items-center mb-0">
                                                <thead>
                                                <tr style="border-top-width: 1px;">
                                                    <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-1"
                                                        style="width: 86%">
                                                        Fitur
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                        style="width: 7%">
                                                        Akses
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                        style="width: 7%">
                                                        Create
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                        style="width: 7%">
                                                        Update
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                        style="width: 7%">
                                                        Delete
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($incomeTransaction as $key => $incomeTransactionPermissions)
                                                    <tr>
                                                        <td class="ps-1">
                                                            <p class="mb-0 text-xs text-dark text-start">{{ ucwords(str_replace('-', ' ', $key)) }}</p>
                                                        </td>
                                                        @foreach($incomeTransactionPermissions as $permission)
                                                            <td class="text-center">
                                                                <div class="form-check form-switch d-inline-block align-middle">
                                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <hr class="mt-0" style="border: 1px solid #ccdddd">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark my-lg-2 m-0">
                                <div class="col-12 col-lg-12">
                                    <h6 class="font-weight-bolder text-xs ms-1">Transaksi Pengeluaran</h6>
                                    <div class="row">
                                        <div class="table-responsive pt-0 px-3">
                                            <table class="table align-items-center mb-0">
                                                <thead>
                                                <tr style="border-top-width: 1px;">
                                                    <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-1"
                                                        style="width: 86%">
                                                        Fitur
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                        style="width: 7%">
                                                        Akses
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                        style="width: 7%">
                                                        Update
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($expenseTransaction as $key => $expenseTransactionPermissions)
                                                    <tr>
                                                        <td class="ps-1">
                                                            <p class="mb-0 text-xs text-dark text-start">{{ ucwords(str_replace('-', ' ', $key)) }}</p>
                                                        </td>
                                                        @foreach($expenseTransactionPermissions as $permission)
                                                            <td class="text-center">
                                                                <div class="form-check form-switch d-inline-block align-middle">
                                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <hr class="mt-0" style="border: 1px solid #ccdddd">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark my-lg-2 m-0">
                                <div class="col-12 col-lg-12">
                                    <h6 class="font-weight-bolder text-xs ms-1">Transaksi Barang</h6>
                                    <div class="row">
                                        <div class="table-responsive pt-0 px-3">
                                            <table class="table align-items-center mb-0">
                                                <thead>
                                                <tr style="border-top-width: 1px;">
                                                    <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-1"
                                                        style="width: 86%">
                                                        Fitur
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                        style="width: 7%">
                                                        Akses
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                        style="width: 7%">
                                                        Update
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($goodsTransaction as $key => $goodsTransactionPermissions)
                                                    <tr>
                                                        <td class="ps-1">
                                                            <p class="mb-0 text-xs text-dark text-start">{{ ucwords(str_replace('-', ' ', $key)) }}</p>
                                                        </td>
                                                        @foreach($goodsTransactionPermissions as $permission)
                                                            <td class="text-center">
                                                                <div class="form-check form-switch d-inline-block align-middle">
                                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <hr class="mt-0" style="border: 1px solid #ccdddd">
                                        </div>
                                    </div>
                                </div>
                                <hr class="horizontal dark my-lg-2 m-0">
                                <div class="col-12 col-lg-12">
                                    <h6 class="font-weight-bolder text-xs ms-1">Laporan</h6>
                                    <div class="row">
                                        <div class="table-responsive pt-0 px-3">
                                            <table class="table align-items-center mb-0">
                                                <thead>
                                                <tr style="border-top-width: 1px;">
                                                    <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-1"
                                                        style="width: 86%">
                                                        Fitur
                                                    </th>
                                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"
                                                        style="width: 7%">
                                                        Akses
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($reports as $key => $reportsPermissions)
                                                    <tr>
                                                        <td class="ps-1">
                                                            <p class="mb-0 text-xs text-dark text-start">{{ ucwords(str_replace('-', ' ', $key)) }}</p>
                                                        </td>
                                                        @foreach($reportsPermissions as $permission)
                                                            <td class="text-center">
                                                                <div class="form-check form-switch d-inline-block align-middle">
                                                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}">
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <hr class="mt-0" style="border: 1px solid #ccdddd">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-2">
                    <button type="button" class="btn btn-sm bg-gradient-danger mb-0" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-sm bg-gradient-info mb-0">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
