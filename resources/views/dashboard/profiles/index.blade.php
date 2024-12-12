@extends('dashboard.layouts.main')

@section('breadcrumb')
    <x-breadcrumb title="Profile" page="Account Page" active="Profile" />
@endsection

@section('title', 'Profile')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-12">
            <div class="card card-body" id="profile">
                <div class="row justify-content-center align-items-center">
                    <div class="col-sm-auto col-4">
                        <div class="position-relative">
                            @if($user->image !== 'default.png')
                                @php
                                    $dataImage = explode("/", $user->image);
                                    $imageUrl = ($dataImage[0] == 'users') ? asset('img/' . $user->image) : asset('storage/' . $user->image);
                                @endphp
                            @else
                                @php $imageUrl = asset('img/' . $user->image); @endphp
                            @endif
                            <img src="{{ $imageUrl }}" class="avatar avatar-xl w-100 border-radius-lg shadow-sm"
                                 alt="image-profile-user">
                        </div>
                    </div>
                    <div class="col-sm-auto col-8 my-auto">
                        <div class="h-100">
                            <div class="d-flex align-items-center gap-2">
                                <h5 class="mb-1 font-weight-bolder">
                                    {{ $user->name ?? '' }}
                                </h5>
                                @if(!empty($user->is_anonymous) && $user->is_anonymous == 1)
                                    <span class="badge badge-sm bg-gradient-info text-xxs">Anonymous</span>
                                @endif
                            </div>
                            <p class="mb-0 font-weight-bold text-sm">
                                <span class="badge badge-sm {{ $user->role->name == 'Administrator' ? 'bg-gradient-primary' : 'bg-gradient-info' }}">{{ $user->role->name }}</span>
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-auto ms-sm-auto mt-3 mt-lg-0 d-grid">
                        <a href="javascript:void(0);" class="btn btn-sm bg-gradient-primary mb-0" data-bs-toggle="modal" data-bs-target="#edit-profile-user-modal-form-{{ $user->id }}">
                            <i class="fas fa-user-edit"></i> &nbsp; Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-12">
            <div class="card mt-4 shadow" id="basic-info">
                <div class="card-header pb-0">
                    <h6>Informasi User</h6>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name">Nama Lengkap</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" id="name" name="name" value="{{ $user->name ?? '-' }}" readonly />
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="email">Email</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" id="email" name="email" value="{{ $user->email ?? '-' }}" readonly />
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12 col-md-6 mt-2 mt-lg-0">
                            <label class="form-label" for="gender">Jenis Kelamin</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" id="gender" name="gender" value="{{ ucfirst($user->gender ?? '-') }}" readonly />
                            </div>
                        </div>
                        <div class="col-12 col-md-6 mt-2 mt-lg-0">
                            <label class="form-label" for="phone">No Handphone</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" id="phone" name="phone" value="{{ $user->phone ?? '-' }}" readonly />
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <label class="form-label" for="address">Alamat</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" id="address" name="address" value="{{ $user->address ?? '-' }}" readonly />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dashboard.profiles.modals.edit')
@endsection

@section('scripts')
    @if ($errors->any())
        @php
            $sessionKey = session('update_profile_error') ? 'update_profile_error' : null;
            $errorMessages = $errors->all();
            $modalId = null;
            $errorTitle = null;

            if (session('update_profile_error')) {
                $updateProfileId = session('update_profile_id');
                $modalId = 'edit-profile-user-modal-form-' . $updateProfileId;
                $errorTitle = 'Edit Profile Error';
            }
        @endphp

        @if ($modalId && $errorTitle)
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    var errorMessages = @json($errorMessages);
                    handleModalWithErrors('{{ $modalId }}', '{{ $sessionKey }}', '{{ $errorTitle }}', errorMessages, true);
                });
            </script>
        @endif

        @php
            $sessionKey = session('update_profile_error') ? 'update_profile_error' : null;
            if ($sessionKey) {
                session()->forget($sessionKey);
            }
        @endphp
    @endif
@endsection
