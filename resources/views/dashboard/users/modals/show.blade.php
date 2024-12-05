<div class="modal fade" id="detail-user-modal-form{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Detail Data User</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-12 col-lg-9">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label class="mt-3 mt-lg-0 required">Nama Lengkap</label>
                                            <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="Nama lengkap" name="name" value="{{ old('name', $user->name) }}" readonly>
                                            @error('name')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="mt-3 mt-lg-0 required">Email</label>
                                            <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email', $user->email) }}" readonly>
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
                                                    class="form-control form-control-sm modal-dropdown-select2 mb-3 @error('gender') is-invalid border border-danger @enderror" disabled>
                                                <option value="">-- Pilih Jenis Kelamin --</option>
                                                <option value="laki-laki" {{ old('gender', $user->gender) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                <option value="perempuan" {{ old('gender', $user->gender) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                            @error('gender')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="mt-3 mt-lg-3 required">No Handphone</label>
                                            <input type="text" class="form-control form-control-sm @error('phone') is-invalid @enderror inputNumberOnly" placeholder="No hp" name="phone" value="{{ old('phone', $user->phone) }}" readonly>
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
                                                      id="address" name="address" rows="2" readonly>{{ old('address', $user->address) }}</textarea>
                                            @error('address')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="mt-3 mt-lg-3 required">Role</label>
                                            <select name="m_role_id"
                                                    class="form-control form-control-sm modal-dropdown-select2 @error('m_role_id') is-invalid border border-danger @enderror" disabled>
                                                <option value="">-- Pilih Role --</option>
                                                @foreach($roles as $role)
                                                    @if(old('m_role_id', $user->m_role_id) == $role->id)
                                                        <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                                                    @else
                                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @error('m_role_id')
                                            <div class="invalid-feedback text-xxs ms-1">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <label class="mt-3 mt-lg-0" for="">Foto User</label>
                                    <input type="hidden" name="oldImage" value="{{ $user->image }}">
                                    @if($user->image !== 'default.png')
                                        @php
                                            $dataImage = explode("/", $user->image);
                                            $imageUrl = ($dataImage[0] == 'users') ? asset('img/' . $user->image) : asset('storage/' . $user->image);
                                        @endphp
                                    @else
                                        @php $imageUrl = asset('img/' . $user->image); @endphp
                                    @endif
                                    <div class="col-12">
                                        <img class="w-100 border-radius-lg shadow-lg image-preview-edit{{ $user->id }}"
                                             src="{{ $imageUrl }}" alt="user_image"/>
                                    </div>
{{--                                    <div class="col-12 mt-2">--}}
{{--                                        <input type="file" name="image" id="image-user-edit{{ $user->id }}"--}}
{{--                                               class="form-control form-control-sm mb-2" style="display: none;" onchange="previewImage('image-user-edit{{ $user->id }}', 'image-preview-edit{{ $user->id }}', '{{ $imageUrl }}')">--}}
{{--                                        <div class="d-grid">--}}
{{--                                            <button class="btn bg-gradient-primary btn-sm mb-0" type="button"--}}
{{--                                                    onclick="document.getElementById('image-user-edit{{$user->id}}').click();">--}}
{{--                                                {{ $user->image ? 'Change Image' : 'Upload Image' }}--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
{{--                                        <p class="text-xs mt-2 mb-0">*png, jpg, jpeg (maxsize: 2MB)</p>--}}
{{--                                        <p class="text-xs mt-2 mb-0">*ratio 1:1</p>--}}
{{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-2">
                    <button type="button" class="btn btn-sm bg-gradient-danger mb-0" data-bs-dismiss="modal">Batal</button>
{{--                    <button type="submit" class="btn btn-sm bg-gradient-info mb-0">Simpan</button>--}}
                </div>
{{--            </form>--}}
        </div>
    </div>
</div>
