@extends('auth.layouts.main')

@section('content')
    <div class="row">
        <div class="col-xl-6 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
            <div class="card card-plain">
                <div class="card-header pb-0 text-left">
                    <h4 class="font-weight-bolder">Sign Up</h4>
                    <p class="mb-0">
                        Enter your email and password to register
                    </p>
                </div>
                <div class="card-body pb-3">
                    <form role="form" action="{{ route('register') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <label for="name" class="required">Nama Lengkap</label>
                                <div class="mb-3">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama lengkap" value="{{ old('name') }}" />
                                    @error('name')
                                    <div class="invalid-feedback text-xs">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="email" class="required">Email</label>
                                <div class="mb-3">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email') }}" />
                                    @error('email')
                                    <div class="invalid-feedback text-xs">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="form-group">
                                    <label for="gender">Jenis Kelamin</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" name="gender" id="gender">
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        @if(old('gender') == "laki-laki")
                                            <option value="laki-laki" selected>Laki-laki</option>
                                            <option value="perempuan">Perempuan</option>
                                        @elseif(old('gender') == 'perempuan')
                                            <option value="laki-laki">Laki-laki</option>
                                            <option value="perempuan" selected>Perempuan</option>
                                        @else
                                            <option value="laki-laki">Laki-laki</option>
                                            <option value="perempuan">Perempuan</option>
                                        @endif
                                    </select>
                                    @error('gender')
                                    <div class="invalid-feedback text-xs">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="phone" class="required">No Hp</label>
                                <div class="mb-3">
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror inputNumberOnly" id="phone" name="phone" placeholder="No Hp" />
                                    @error('phone')
                                    <div class="invalid-feedback text-xs">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="address" class="required">Alamat</label>
                                <div class="mb-3">
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Alamat" />
                                    @error('address')
                                    <div class="invalid-feedback text-xs">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <label for="password" class="required">Password</label>
                                <div class="mb-3">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" />
                                    @error('password')
                                    <div class="invalid-feedback text-xs">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <label for="confirm_password" class="required">Konfirmasi Password</label>
                                <div class="mb-3">
                                    <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password" />
                                    @error('confirm_password')
                                    <div class="invalid-feedback text-xs">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary text-white opacity-9 w-100 mt-3 mb-0">
                                Sign up
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center pt-0 px-sm-4 px-1">
                    <p class="mb-4 text-sm mx-auto">
                        Already have an account? <a href="{{ route('web.login') }}" class="text-primary opacity-9 font-weight-bold">Sign in</a >
                    </p>
                </div>
            </div>
        </div>
        <div class="col-5 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signup-ill.jpg'); background-size: cover;">
                <span class="mask bg-primary opacity-4"></span>
                {{--                <img src="{{ asset('img/logo/logo-vocational-reading-room-dark.png') }}" class="z-index-3" alt="Logo Ruang Baca Vokasi UB">--}}
                <h4 class="mt-5 text-white font-weight-bolder position-relative">Your journey starts here</h4>
                <p class="text-white position-relative">Just as it takes a company to sustain a product, it takes a community to sustain a protocol.</p>
            </div>
        </div>
    </div>
@endsection
