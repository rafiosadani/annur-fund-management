<div class="modal fade" id="edit-donor-modal-form{{$donor->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Edit Data Donatur</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" action="{{ route('donors.update', $donor->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
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
                <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-12 col-lg-9">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label class="mt-3 mt-lg-0 required">Nama Lengkap</label>
                                            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="Nama lengkap" name="name" value="{{ old('name', $donor->name) }}">
                                            @error('name')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="mt-3 mt-lg-0 required">Email</label>
                                            <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email', $donor->email) }}">
                                            @error('email')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label class="mt-3 mt-lg-3 required">Jenis Kelamin</label>
                                            <select name="gender"
                                                    class="form-control form-control-sm modal-dropdown-select2 mb-3 @error('gender') is-invalid border border-danger @enderror">
                                                <option value="">-- Pilih Jenis Kelamin --</option>
                                                <option value="laki-laki" {{ old('gender', $donor->gender) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="perempuan" {{ old('gender', $donor->gender) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                            @error('gender')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="mt-3 mt-lg-3 required">No Handphone</label>
                                            <input type="text" class="form-control form-control-sm @error('phone') is-invalid @enderror inputNumberOnly" placeholder="No hp" name="phone" value="{{ old('phone', $donor->phone) }}">
                                            @error('phone')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="mt-3 mt-lg-3 required" for="address">Alamat</label>
                                            <textarea style="resize: none;" class="form-control form-control-sm @error('address') is-invalid @enderror"
                                                      id="address" name="address" rows="2" >{{ old('address', $donor->address) }}</textarea>
                                            @error('address')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <label class="mt-3 mt-lg-3 required">Password</label>
                                            <input type="text" class="form-control form-control-sm" name="password">
                                            <span class="text-xxs text-danger">*Kosongi jika tidak ingin mengubah password</span>
                                            {{--                                            <p class="text-xs text-danger mt-2 mb-0">*png, jpg, jpeg (maxsize: 2MB)</p>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label class="mt-3 mt-lg-0" for="">Foto Donatur</label>
                                    <input type="hidden" name="oldImage" value="{{ $donor->image }}">
                                    @if($donor->image !== 'default.png')
                                        @php
                                            $dataImage = explode("/", $donor->image);
                                            $imageUrl = ($dataImage[0] == 'users') ? asset('img/' . $donor->image) : asset('storage/' . $donor->image);
                                        @endphp
                                    @else
                                        @php $imageUrl = asset('img/' . $donor->image); @endphp
                                    @endif
                                    <div class="col-12">
                                        <img class="w-100 border-radius-lg shadow-lg image-preview-edit{{ $donor->id }}"
                                             src="{{ $imageUrl }}" alt="donor_image"/>
                                    </div>
                                    <div class="col-12 mt-2">
                                        <input type="file" name="image" id="image-user-edit{{ $donor->id }}"
                                               class="form-control form-control-sm mb-2" style="display: none;" onchange="previewImage('image-user-edit{{ $donor->id }}', 'image-preview-edit{{ $donor->id }}', '{{ $imageUrl }}')">
                                        <div class="d-grid">
                                            <button class="btn bg-gradient-primary btn-sm mb-0" type="button"
                                                    onclick="document.getElementById('image-user-edit{{$donor->id}}').click();">
                                                {{ $donor->image ? 'Change Image' : 'Upload Image' }}
                                            </button>
                                        </div>
                                        <p class="text-xs mt-2 mb-0">*png, jpg, jpeg (maxsize: 2MB)</p>
                                        <p class="text-xs mt-2 mb-0">*ratio 1:1</p>
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