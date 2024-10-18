<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
    <div class="container-fluid py-1 px-3">
        @yield('breadcrumb')
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
{{--            <div class="ms-md-auto pe-md-3 d-flex align-items-center">--}}
{{--                <div class="input-group">--}}
{{--                    <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>--}}
{{--                    <input type="text" class="form-control" placeholder="Type here...">--}}
{{--                </div>--}}
{{--            </div>--}}
            <ul class="navbar-nav ms-auto justify-content-end">
{{--                <li class="nav-item d-flex align-items-center">--}}
{{--                    <a href="javascript:;" class="nav-link text-white font-weight-bold px-0">--}}
{{--                        <i class="fa fa-user me-sm-1"></i>--}}
{{--                        <span class="d-sm-inline d-none">Sign In</span>--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <div class="dropdown dropdown-profile">
                        <div class="d-flex sm-shadow-radius" id="dropdownMenuButton" data-bs-toggle="dropdown"
                             aria-expanded="false">
                            <div>
                                @if(auth()->user()->image !== 'default.png')
                                    @php
                                        $dataImage = explode("/", auth()->user()->image);
                                        $imageUrl = ($dataImage[0] == 'users') ? asset('img/' . auth()->user()->image) : asset('storage/' . auth()->user()->image);
                                    @endphp
                                @else
                                    @php $imageUrl = asset('img/' . auth()->user()->image); @endphp
                                @endif
                                <img src="{{ $imageUrl }}" class="avatar-sm avatar me-2"
                                     alt="profile-user">
                            </div>
                            <div class="d-flex flex-column justify-content-center ms-1">
                                <h5 class="mb-0 text-xs text-white">{{ auth()->user()->name }}</h5>
                                <p class="text-xs text-white mb-0">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                            <li>
                                <a class="dropdown-item text-sm py-2 second" href="{{ url('/profile') }}">
                                    <i class="fa fa-user fa-sm me-2 opacity-7" aria-hidden="true"></i>
                                    Profile
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button class="dropdown-item text-sm py-2 show-logout-header" type="submit">
                                        <i class="fa fa-sign-out fa-sm me-2 opacity-7" aria-hidden="true"></i>
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->
