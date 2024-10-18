@extends('dashboard.layouts.main')

@section('breadcrumb')
    <x-breadcrumb title="Charitable Donations Data" page="Master Data" active="Charitable Donations"/>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- card2 Wrapper -->
        <div class="card2">
            <div class="card2-header">
                <h4>Charitable Donations Data</h4>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">Tambah</button>
            </div>
            <div class="card2-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>No HP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Indah</td>
                                <td>Perempuan</td>
                                <td>Medan</td>
                                <td>0811223344</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-warning btn-sm editBtn" 
                                        data-bs-toggle="modal" data-bs-target="#editModal"
                                        data-nama="Indah"
                                        data-jenis_kelamin="Perempuan"
                                        data-alamat="Medan"
                                        data-no_hp="0811223344">
                                        Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between">
                    <div>Showing 1 to 1 of 1 entries</div>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Adding Data -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
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

<!-- Modal for Editing Data -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <div class="mb-3">
                        <label for="edit_nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-control" id="edit_jenis_kelamin" name="jenis_kelamin" required>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="edit_alamat" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_no_hp" class="form-label">No HP</label>
                        <input type="text" class="form-control" id="edit_no_hp" name="no_hp" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="editForm">Update</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all edit buttons
        let editButtons = document.querySelectorAll('.editBtn');

        // Loop through edit buttons to add event listener
        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                // Get data from button attributes
                let nama = this.getAttribute('data-nama');
                let jenis_kelamin = this.getAttribute('data-jenis_kelamin');
                let alamat = this.getAttribute('data-alamat');
                let no_hp = this.getAttribute('data-no_hp');

                // Populate modal fields with data
                document.getElementById('edit_nama').value = nama;
                document.getElementById('edit_jenis_kelamin').value = jenis_kelamin;
                document.getElementById('edit_alamat').value = alamat;
                document.getElementById('edit_no_hp').value = no_hp;
            });
        });
    });
</script>
@endsection
