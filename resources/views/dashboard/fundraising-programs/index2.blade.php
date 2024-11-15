@extends('dashboard.layouts.main')

@section('title', 'Data Program Penggalangan Dana')

@section('breadcrumb')
    <x-breadcrumb title="Data Program Penggalangan Dana" page="Master Data" active="Program Penggalangan Dana"/>
@endsection

@section('content')
    <form action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
            <script>
                setTimeout(function () {
                    Swal.fire({
                        title: 'Error',
                        icon: 'error',
                        html: `
                        @foreach ($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                        @endforeach
                        `
                    });
                }, 100);
            </script>
        @endif

        <!-- Input Nama Lengkap -->
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" id="name" required>
        </div>

        <!-- Input Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>

        <!-- Input Gambar -->
        <div class="mb-3">
            <label for="images-user-create" class="form-label">Foto User</label>
            <div id="image-previews-container" class="d-flex flex-wrap gap-3 mb-3" style="gap: 10px; overflow-x: auto;">
                <!-- Dynamic image previews will appear here -->
            </div>
            <input type="file" name="images[]" id="images-user-create" accept="image/png, image/jpeg" max-size="2000000" multiple
                   class="form-control form-control-sm"
                   onchange="previewImages('images-user-create', 'image-previews-container')">
            <p class="text-xs mt-2 mb-0">*png, jpg, jpeg (maxsize: 2MB per file)</p>
            <p class="text-xs mt-2 mb-0">*ratio 1:1</p>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
@section('scripts')
    <script>
        let selectedFiles = [];

        function previewImages(inputId, containerId) {
            const input = document.getElementById(inputId);
            const container = document.getElementById(containerId);

            if (input.files) {
                Array.from(input.files).forEach(file => {
                    if (file.size > 2000000) { // Batas 2MB
                        alert('Ukuran gambar ' + file.name + ' terlalu besar. Maksimal 2MB per file.');
                        return;
                    }

                    // Tambahkan file ke array selectedFiles untuk ditampilkan dan dihapus
                    selectedFiles.push(file);

                    const reader = new FileReader();
                    reader.onload = function (e) {
                        // Buat elemen wrapper untuk gambar dan tombol close
                        const wrapper = document.createElement('div');
                        wrapper.classList.add('position-relative', 'd-inline-block', 'mt-2');

                        // Elemen gambar pratinjau
                        const imgElement = document.createElement('img');
                        imgElement.src = e.target.result;
                        imgElement.classList.add('border', 'shadow-sm', 'rounded', 'img-thumbnail');
                        imgElement.style.width = '140px';
                        imgElement.style.height = '140px';
                        imgElement.style.objectFit = 'cover';

                        // Tombol close dengan gaya khusus
                        const closeButton = document.createElement('button');
                        closeButton.innerHTML = 'x';
                        closeButton.classList.add('btn', 'btn-xs', 'btn-danger', 'position-absolute');
                        closeButton.style.padding = '2px 8px';
                        closeButton.style.top = '-8px';
                        closeButton.style.right = '-10px';
                        closeButton.style.border = '1px solid white'; // Menambahkan border
                        // closeButton.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.2)'; // Menambahkan shadow
                        closeButton.onclick = function () {
                            removeImage(wrapper, file);
                        };

                        // Menambahkan elemen gambar dan tombol close ke wrapper
                        wrapper.appendChild(imgElement);
                        wrapper.appendChild(closeButton);
                        container.appendChild(wrapper);
                    };
                    reader.readAsDataURL(file);
                });

                // Reset input file agar bisa mengunggah file lain satu per satu
                input.value = "";
            }
        }

        function removeImage(wrapper, file) {
            const index = selectedFiles.indexOf(file);
            if (index > -1) {
                selectedFiles.splice(index, 1); // Hapus file dari array selectedFiles
            }
            wrapper.remove(); // Hapus elemen pratinjau dari tampilan
        }
    </script>
@endsection
