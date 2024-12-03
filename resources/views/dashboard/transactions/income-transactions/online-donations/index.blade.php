<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Donasi Online {{ $title }} | {{ config('app.name', 'Masjid Raya An Nur Politeknik Negeri Malang') }}
    </title>
    {{-- Fonts and icons --}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet"/>

    {{-- Nucleo Icons --}}
    <link href="{{ asset('css/nucleo-icons.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet"/>

    {{-- Font Awesome Icons --}}
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('css/nucleo-svg.css') }}" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    {{-- CSS Files --}}
    <link id="pagestyle" href="{{ asset('css/argon-dashboard.css?v=2.0.4') }}" rel="stylesheet"/>

    {{-- Select 2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    {{-- Datepicker --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    {{-- Magnific Popup --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">

    {{--  My CSS --}}
    <link id="pagestyle" href="{{ asset('css/style.css') }}" rel="stylesheet"/>
</head>

<body class="bg-gray-100">
    <div class="row justify-content-center py-4 py-md-5 px-4 px-md-0">
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header p-5 position-relative z-index-1" style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/signin-ill.jpg'); background-position: center; background-size: cover;">
                </div>
                <form action="{{ route('donations.online.store', $fundraisingProgram->id) }}" method="post" enctype="multipart/form-data">
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
                    <div class="card-body">
                        <div class="heading mb-lg-4">
                            <h3 class="mb-0">Form Donasi</h3>
                            <h5>{{ $fundraisingProgram->title }}</h5>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label class="mt-3 mt-lg-0 required">Nama Lengkap</label>
                                <input type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" placeholder="Nama lengkap" name="name" value="{{ old('name') }}">
                                @error('name')
                                <div class="invalid-feedback text-xxs ms-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="mt-3 mt-lg-0 required">Email</label>
                                <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}">
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
                                        class="form-control form-control-sm dropdown-select2 @error('gender') is-invalid border border-danger @enderror">
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="laki-laki" {{ old('gender') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="perempuan" {{ old('gender') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                <div class="invalid-feedback text-xxs ms-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="mt-3 mt-lg-3 required">No Handphone</label>
                                <input type="text" class="form-control form-control-sm @error('phone') is-invalid @enderror inputNumberOnly" placeholder="No hp" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                <div class="invalid-feedback text-xxs ms-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label class="mt-3 mt-lg-3 required" for="address">Alamat</label>
{{--                                <textarea style="resize: none;" class="form-control form-control-sm @error('address') is-invalid @enderror"--}}
{{--                                          id="address" name="address" rows="2" >{{ old('address') }}</textarea>--}}
                                <input type="text" class="form-control form-control-sm @error('address') is-invalid @enderror" placeholder="Alamat" name="address" value="{{ old('address') }}">
                                @error('address')
                                <div class="invalid-feedback text-xxs ms-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="mt-3 mt-lg-3 required">Jumlah Donasi</label>
                                <input type="text" class="form-control form-control-sm @error('amount') is-invalid @enderror inputRupiah" name="amount" value="{{ old('originalAmount', session('originalAmount')) }}">
                                @error('amount')
                                <div class="invalid-feedback text-xxs ms-1">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label class="mt-3 mt-lg-3">Anonymous</label>
                                <div>
                                    <div class="form-check form-switch form-switch-donation-online d-inline-block align-middle">
                                        <input class="form-check-input" type="checkbox" name="is_anonymous" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-3">
                                <label class="mt-3 mt-lg-3 required" for="image-proof-of-payment-create">Bukti Transfer</label>
                                <div class="col-6 col-md-12">
                                    <img class="w-100 border-radius-lg shadow-lg image-preview-proof-of-payment"
                                         src="{{ asset('img/preview-user.png') }}" alt="user_image"/>
                                </div>
                                <div class="col-6 col-md-12 mt-2">
                                    <input type="file" name="proof_of_payment" id="image-proof-of-payment-create"
                                           class="form-control form-control-sm mb-2" style="display: none;" onchange="previewImage('image-proof-of-payment-create', 'image-preview-proof-of-payment', '{{ asset('img/preview-user.png') }}')">
                                    <div class="d-grid">
                                        <button class="btn bg-gradient-primary btn-sm mb-0" type="button"
                                                onclick="document.getElementById('image-proof-of-payment-create').click();">
                                            {{ old('image') ? 'Change Image' : 'Upload Image' }}
                                        </button>
                                    </div>
                                    <p class="text-xs mt-2 mb-0">*png, jpg, jpeg (maxsize: 2MB)</p>
                                    @error('proof_of_payment')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center mt-2 border-1 border-opacity-50">
                        <button type="submit" class="btn btn-sm bg-gradient-info mb-0 px-6">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@include('dashboard.layouts.script')
@yield('scripts')
</body>

</html>
