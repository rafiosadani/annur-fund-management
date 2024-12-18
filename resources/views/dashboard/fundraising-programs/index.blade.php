@extends('dashboard.layouts.main')

@section('title', 'Data Program Penggalangan Dana')

@section('breadcrumb')
    <x-breadcrumb title="Data Program Penggalangan Dana" page="Master Data" active="Program Penggalangan Dana"/>
@endsection

@section('content')
    <div class="row">
        <div class="row mt-4 mt-lg-0">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header mb-0 pb-0">
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <h6>Data Program Penggalangan Dana</h6>
                            </div>
                            <div class="col-lg-8 col-12 parent-button">
                                <div>
                                    @if(request()->has('view_deleted'))
                                        <a href="{{ route('fundraising-programs.index') }}"
                                           class="btn bg-gradient-info btn-sm mb-0 btn-action">
                                            <i class="fa fa-list"></i> &nbsp; View All Program
                                        </a>
                                        @if($fundraisingPrograms->total() < 1)
                                            <a href="{{ route('fundraising-programs.restore.all') }}"
                                               class="btn bg-gradient-primary btn-sm mb-0 disabled btn-action show-confirm-restore-all">
                                                <i class="fa fa-undo"></i> &nbsp; Restore All
                                            </a>
                                        @else
                                            <a href="{{ route('fundraising-programs.restore.all') }}"
                                               class="btn bg-gradient-primary btn-sm mb-0 btn-action show-confirm-restore-all">
                                                <i class="fa fa-undo"></i> &nbsp; Restore All
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('fundraising-programs.index', ['view_deleted' => 'DeletedRecords']) }}"
                                           class="btn bg-gradient-info btn-sm mb-0 btn-action">
                                            <i class="fas fa-trash-restore"></i> &nbsp; View Delete Records
                                        </a>
                                        <a href="javascript:void(0);"
                                           class="btn bg-gradient-primary btn-sm mb-0 btn-action" data-bs-toggle="modal" data-bs-target="#create-fundraising-program-modal-form">
                                            +&nbsp; Tambah Program
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @php
                            $actionUrl = request()->has('view_deleted') ? route('fundraising-programs.index', ['view_deleted' => 'DeletedRecords']) : route('fundraising-programs.index');
                        @endphp
                        <div class="row mt-2 pb-0">
                            <form action="" method="get" class="pb-0 m-0 d-inline-flex">
                                <div class="col-md-9 pb-0 pe-2">
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
                                <div class="col-md-3">
                                    <select name="program_status"
                                            class="form-control form-control-sm dropdown-select2 mb-3" onchange="this.form.submit()">
                                        <option value="">-- Status --</option>
                                        <option value="active" {{ request('program_status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="completed" {{ request('program_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ request('program_status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Program
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2 pe-2">
                                        Kode Program
                                    </th>
                                    <th style="width: 25%;" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Keterangan
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 px-5">
                                        Status
                                    </th>
                                    <th style="width: 15%;" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Dibuat
                                    </th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($fundraisingPrograms->total() < 1)
                                    <tr style="border-bottom: 1px solid #ccdddd;">
                                        <td colspan="7">
                                            <p class="text-center text-xs mb-0 py-1">Data tidak ditemukan.</p>
                                        </td>
                                    </tr>
                                @else
                                    @foreach($fundraisingPrograms as $fundraisingProgram)
                                        <tr style="border-bottom: 1px solid #ccdddd;">
                                            <td>
                                                <p class="text-center text-xs mb-0">{{ $loop->iteration + ($fundraisingPrograms->currentPage() - 1) * $fundraisingPrograms->perPage() }}</p>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-column justify-content-center px-3">
                                                    <p class="mb-0 text-sm text-bold" style="cursor: pointer" onclick="window.location.href='{{ route('fundraising-programs.show', $fundraisingProgram->id) }}'">{{ $fundraisingProgram->title }}</p>
                                                    <p class="text-xs text-secondary mb-0">{{ \Carbon\Carbon::parse($fundraisingProgram->start_date)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($fundraisingProgram->end_date)->translatedFormat('d F Y') }}</p>
                                                    <div class="progress-wrapper">
                                                        <div class="progress w-100 my-2" style="height: 8px;">
                                                            <div class="progress-bar bg-gradient-primary text-bold text-center"
                                                                 role="progressbar"
                                                                 aria-valuenow="{{ $fundraisingProgram->donation_percentage ?? 0 }}"
                                                                 aria-valuemin="0"
                                                                 aria-valuemax="100"
                                                                 style="width: {{ $fundraisingProgram->donation_percentage ?? 0 }}%; font-size: 8px;">{{ $fundraisingProgram->donation_percentage ?? 0 }}%</div>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="d-flex flex-column text-start">
                                                                <span class="me-2 text-xs font-weight-bold text-capitalize">@currency($fundraisingProgram->total_donated ?? 0)</span>
                                                                <span class="text-xxs">Terkumpul</span>
                                                            </div>
                                                            <div class="d-flex flex-column ms-auto text-end">
                                                                <span class="ms-auto text-xs font-weight-bold">@currency($fundraisingProgram->target_amount)</span>
                                                                <span class="text-xxs">Target Dana</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle">
                                                <p class="text-xs text-secondary mb-0">{{ $fundraisingProgram->fundraising_program_code }}</p>
                                            </td>
                                            <td class="align-middle text-wrap text-justify">
                                                <p class="text-xs text-secondary mb-0">{{ $fundraisingProgram->description ?? '-' }}</p>
                                            </td>
                                            <td class="align-middle text-center text-xs">
                                                <span class="badge d-inline-flex align-items-center {{ $fundraisingProgram->status == 'completed' ? 'bg-soft-completed' : ($fundraisingProgram->status == 'active' ? 'bg-soft-active' : 'bg-soft-cancelled') }}">
                                                    <i class="fas {{ $fundraisingProgram->status == 'completed' ? 'fa-check-circle' : ($fundraisingProgram->status == 'active' ? 'fa-sync-alt' : 'fa-times-circle') }} me-1"></i>
                                                    {{ $fundraisingProgram->status ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-wrap text-justify">
                                                <p class="text-xs font-weight-bold mb-0">{{ $fundraisingProgram->dibuat->name ?? 'Administrator' }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $fundraisingProgram->created_at }}</p>
                                            </td>
                                            <td class="align-middle text-xs text-end action">
                                                @if(request()->has('view_deleted'))
                                                    <a href="{{ route('fundraising-programs.restore', $fundraisingProgram->id) }}"
                                                       class="mx-1 badge bg-gradient-success show-confirm-restore">
                                                        <i class="fa fa-check text-white"></i> &nbsp; Restore
                                                    </a>
                                                @else
                                                    <input type="hidden" id="donationUrl{{ $fundraisingProgram->id }}" value="{{ url('transactions/donations/online/' . $fundraisingProgram->id) }}">
                                                    <button
                                                       class="badge bg-gradient-secondary border-0 me-1" onclick="copyData('donationUrl{{ $fundraisingProgram->id }}')">
                                                        <i class="fas fa-copy text-white"></i> &nbsp; Copy
                                                    </button>
                                                    <a href="javascript:void(0)"
                                                       class="badge bg-gradient-info" data-bs-toggle="modal" data-bs-target="#detail-fundraising-program-modal-form-{{ $fundraisingProgram->id }}">
                                                        <i class="fas fa-eye text-white"></i> &nbsp; Detail
                                                    </a>
                                                    <a href="javascript:void(0);"
                                                       class="mx-1 badge bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#edit-fundraising-program-modal-form{{ $fundraisingProgram->id }}">
                                                        <i class="fas fa-edit text-white"></i> &nbsp; Edit
                                                    </a>
                                                    <form action="{{ route('fundraising-programs.destroy', $fundraisingProgram->id) }}"
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
                            {{ $fundraisingPrograms->links() }}
                        </div>
                    </div>
                    @include('dashboard.fundraising-programs.modals.create')
                    @foreach($fundraisingPrograms as $fundraisingProgram)
                        @include('dashboard.fundraising-programs.modals.show')
                        @include('dashboard.fundraising-programs.modals.edit')
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@if ($openModal)
    <script>
        window.onload = function() {
            const modalId = 'detail-fundraising-program-modal-form-{{ $openModal }}';
            const modal = new bootstrap.Modal(document.getElementById(modalId));
            modal.show();
        };
    </script>
@endif
@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Trigger page refresh when any modal is closed
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function () {
                    const url = new URL(window.location.href);
                    url.searchParams.delete('openModal');
                    url.searchParams.delete('page_donations');
                    window.history.replaceState(null, '', url.toString());
                    location.reload();
                });
            });


            @if ($errors->any())
                @if (session('create_error'))
                    // Show Create Form Modal
                    var myModal = new bootstrap.Modal(document.getElementById('create-fundraising-program-modal-form'));
                    myModal.show();

                    // Show SweetAlert for Create Form Errors
                    setTimeout(function () {
                        Swal.fire({
                            title: 'Tambah Data Program Error',
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
                    var fundraisingProgramId = '{{ session('edit_fundraising_program_id') }}';
                    var myModalEdit = new bootstrap.Modal(document.getElementById('edit-fundraising-program-modal-form' + fundraisingProgramId));
                    myModalEdit.show();

                    // Show SweetAlert for Edit Form Errors
                    setTimeout(function () {
                        Swal.fire({
                            title: 'Edit Data Program Error',
                            icon: 'error',
                            html: `
                                @foreach ($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            `
                        }).then(() => {
                            @php session()->forget('edit_fundraising_program_id'); @endphp
                            @php session()->forget('edit_error'); @endphp
                        });
                    }, 100);
               @endif
            @endif
        });

        let imagesToDelete = [];
        let fileList = [];

        function markForDeletion(imageId, imageToDeleteId, containerId, defaultPreviewId, buttonUploadImageId) {
            if (!imagesToDelete.includes(imageId)) {
                imagesToDelete.push(imageId);
            }
            document.getElementById(imageToDeleteId).value = JSON.stringify(imagesToDelete);
            const imagePreview = document.querySelector(`.image-preview[data-image-id="${imageId}"]`);
            if (imagePreview) {
                imagePreview.style.display = 'none';
            }

            // Cek jika semua gambar database telah dihapus
            const remainingImages = document.querySelectorAll(`#${containerId} .image-preview:not([style*="display: none"])`);

            const defaultPreview = document.getElementById(defaultPreviewId);
            const uploadButton = document.getElementById(buttonUploadImageId);

            if (remainingImages.length === 0 && fileList.length === 0) {
                defaultPreview.style.display = 'block';
                uploadButton.innerHTML = 'Upload Image';
            } else if (remainingImages.length === 1 && fileList.length === 1) {
                defaultPreview.style.display = 'none';
                uploadButton.innerHTML = 'Change Image';
            } else {
                defaultPreview.style.display = 'none';
                uploadButton.innerHTML = 'Change Image(s)';
            }
        }

        // Fungsi untuk menampilkan pratinjau gambar yang diunggah
        function previewImages(input, containerId, defaultPreviewId, buttonUploadImageId) {
            const container = document.getElementById(containerId);
            const defaultPreview = document.getElementById(defaultPreviewId);
            const uploadButton = document.getElementById(buttonUploadImageId);

            // Jika ada file baru yang diunggah, sembunyikan pratinjau default
            if (input.files && input.files.length > 0) {
                defaultPreview.style.display = 'none';

                // Tambahkan file-file baru ke dalam daftar fileList
                Array.from(input.files).forEach(file => {
                    if (!fileList.includes(file)) {
                        fileList.push(file);
                    }
                });

                // Menampilkan pratinjau untuk setiap file yang dipilih
                Array.from(input.files).forEach(file => {
                    // Validasi ukuran gambar
                    if (file.size > 2000000) { // Batas 2MB per gambar
                        alert(`Ukuran gambar ${file.name} terlalu besar. Maksimal 2MB per file.`);
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const wrapper = document.createElement('div');
                        wrapper.classList.add('position-relative', 'd-inline-block', 'mt-2');

                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.classList.add('border', 'shadow-sm', 'rounded', 'img-thumbnail');
                        imgElement.style.width = '140px';
                        imgElement.style.height = '140px';
                        imgElement.style.objectFit = 'cover';

                        // Tombol untuk menghapus gambar dari pratinjau
                        const closeButton = document.createElement('button');
                        closeButton.innerHTML = 'x';
                        closeButton.classList.add('btn', 'btn-xs', 'btn-danger', 'position-absolute');
                        closeButton.style.padding = '2px 8px';
                        closeButton.style.top = '-8px';
                        closeButton.style.right = '-10px';

                        // Menghapus gambar dari pratinjau
                        closeButton.onclick = function () {
                            removeImage(wrapper, file, input, defaultPreviewId, buttonUploadImageId);
                        };

                        wrapper.appendChild(imgElement);
                        wrapper.appendChild(closeButton);
                        container.appendChild(wrapper);
                    };
                    reader.readAsDataURL(file);
                });

                // Update teks tombol
                uploadButton.innerHTML = 'Change Image(s)';
            } else {
                uploadButton.innerHTML = 'Upload Image';
            }

            // Update input files dengan file yang baru ditambahkan
            const updatedDataTransfer = new DataTransfer();
            fileList.forEach(f => updatedDataTransfer.items.add(f));
            input.files = updatedDataTransfer.files;
        }

        // Fungsi untuk menghapus gambar dari tampilan pratinjau
        function removeImage(wrapper, file, input, defaultPreviewId, buttonUploadImageId) {
            wrapper.remove();

            // Hapus file yang sesuai dari fileList
            fileList = fileList.filter(f => f !== file);

            // Update input file dengan daftar file yang tersisa
            const updatedDataTransfer = new DataTransfer();
            fileList.forEach(f => updatedDataTransfer.items.add(f));
            input.files = updatedDataTransfer.files;

            // Jika tidak ada gambar yang tersisa di fileList, tampilkan default preview kembali
            if (fileList.length === 0) {
                const defaultPreview = document.getElementById(defaultPreviewId);
                defaultPreview.style.display = 'block';

                const uploadButton = document.getElementById(buttonUploadImageId);
                uploadButton.innerHTML = 'Upload Image';
            }
        }
    </script>
@endsection




