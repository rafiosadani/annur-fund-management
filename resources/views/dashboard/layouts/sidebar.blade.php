<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 text-center d-flex align-items-center justify-content-center" href=" https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html " target="_blank">
{{--            <img src="{{ asset('img/logo-ct-dark.png') }}" class="navbar-brand-img h-100" alt="main_logo">--}}
{{--            <span class="ms-1 font-weight-bold">Masjid Raya An Nur</span>--}}
            <img src="{{ asset('img/logo/logo3.png') }}" class="navbar-brand-img h-100 w-100" alt="main_logo">
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav navbar-sidebar">
            <li class="nav-item mt-0">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Dashboard</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                    <div
                        class="border-radius-md text-center ms-3 me-2 align-items-center justify-content-center">
                        <i class="fa fa-tachometer-alt fa-sm text-primary" style="margin-left: -8px;"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            @if(auth()->user()->hasRole('Administrator'))
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Master Data</h6>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#masterData"
                       class="nav-link {{ Request::is('master*') ? 'active' : '' }}" aria-controls="masterData"
                       role="button" aria-expanded="false">
                        <div
                            class="border-radius-md text-center ms-2 me-3 align-items-center justify-content-center">
                            <i class="fa fa-database text-warning" aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text">Master Data</span>
                    </a>
                    <div class="collapse" id="masterData">
                        <ul class="nav ms-4">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('master/goods*') ? 'active' : '' }}"
                                   href="{{ route('good-inventories.index') }}">
                                    <span class="sidenav-normal">Barang</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('master/donors*') ? 'active' : '' }}"
                                   href="{{ route('donors.index') }}">
                                    <span class="sidenav-normal">Donatur</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('master/infaq*') ? 'active' : '' }}"
                                   href="{{ route('infaq.index') }}">
                                    <span class="sidenav-normal">Infaq</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('master/fundraising-programs*') ? 'active' : '' }}"
                                   href="{{ route('fundraising-programs.index') }}">
                                    <span class="sidenav-normal">Program</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('master/roles*') ? 'active' : '' }}"
                                   href="{{ route('roles.index') }}">
                                    <span class="sidenav-normal">Role</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('master/users*') ? 'active' : '' }}"
                                   href="{{ route('users.index') }}">
                                    <span class="sidenav-normal">User</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Transaksi</h6>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#incomeTransactions"
                       class="nav-link" aria-controls="incomeTransactions"
                       role="button" aria-expanded="false">
                        <div
                            class="border-radius-md text-center ms-2 me-3 d-flex align-items-center justify-content-center">
                            <i class="fa fa-money-bill-alt text-success" aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text">Transaksi Pemasukan</span>
                    </a>
                    <div class="collapse" id="incomeTransactions">
                        <ul class="nav ms-4">
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('transactions/donations/donation-offline*') ? 'active' : '' }}"
                                   href="{{ route('transaction.donations.offline-donation.index') }}">
                                    <span class="sidenav-normal">Donasi Offline</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="#">
                                    <span class="sidenav-normal">Infaq</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Request::is('transactions/donor-transfer-confirmations*') ? 'active' : '' }}"
                                   href="{{ route('transaction.donor-transfer-confirmations.index') }}">
                                    <span class="sidenav-normal">Konfirmasi Transfer Donatur</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#expendTransactions"
                       class="nav-link" aria-controls="expendTransactions"
                       role="button" aria-expanded="false">
                        <div
                            class="border-radius-md text-center ms-2 me-3 d-flex align-items-center justify-content-center">
                            <i class="fa fa-exchange-alt text-danger" aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text">Transaksi Pengeluaran</span>
                    </a>
                    <div class="collapse" id="expendTransactions">
                        <ul class="nav ms-4">
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="#">
                                    <span class="sidenav-normal">Pengeluaran Umum</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="{{ route('transaction.expenses.program-expenses.index') }}">
                                    <span class="sidenav-normal">Pengeluaran Program</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('transactions/donations/good-donations*') ? 'active' : '' }}" 
                        href="{{ route('good-donations.index') }}">
                        <div
                            class="border-radius-md text-center ms-3 me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-gift text-info" style="margin-left: -6px;"></i>
                        </div>
                        <span class="nav-link-text ms-2">Donasi Barang</span>
                    </a>
                </li>
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Laporan</h6>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#reports"
                       class="nav-link" aria-controls="reports"
                       role="button" aria-expanded="false">
                        <div
                            class="border-radius-md text-center ms-2 me-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-file text-primary" style="margin-left: 4px;" aria-hidden="true"></i>
                        </div>
                        <span class="nav-link-text ms-1">Laporan</span>
                    </a>
                    <div class="collapse" id="reports">
                        <ul class="nav ms-4">
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="#">
                                    <span class="sidenav-normal">Pemasukan</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="#">
                                    <span class="sidenav-normal">Pengeluaran</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="#">
                                    <span class="sidenav-normal">Donasi Barang</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="#">
                                    <span class="sidenav-normal">Program Penggalangan Dana</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
            @if(auth()->user()->hasRole('Administrator') || auth()->user()->hasRole('Donatur'))
                <li class="nav-item mt-3">
                    <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Account pages</h6>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('profile*') ? 'active' : '' }}" href="{{ route('profile') }}">
                        <div
                            class="border-radius-md text-center ms-3 me-2 align-items-center justify-content-center">
                            <i class="fa fa-user-alt fa-sm text-info" style="margin-left: -4px;"></i>
                        </div>
                        <span class="nav-link-text ms-2">Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('change-password') ? 'active' : '' }}" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#change-password-user-modal-form">
                        <div
                            class="border-radius-md text-center ms-3 me-2 align-items-center justify-content-center">
                            <i class="fa fa-solid fa-key fa-sm text-success" style="margin-left: -6px;"></i>
                        </div>
                        <span class="nav-link-text ms-2">Ubah Password</span>
                    </a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <a class="nav-link show-logout-sidebar" href="javascript:void(0);">
                            <div
                                class="border-radius-md text-center ms-3 me-2 d-flex align-items-center justify-content-center">
                                <i class="fa fa-sign-out-alt text-danger" style="margin-left: -4px;"></i>
                            </div>
                            <span class="nav-link-text ms-2">Logout</span>
                        </a>
                        <button type="submit" class="d-none"></button>
                    </form>
                </li>
            @endif
        </ul>
    </div>
{{--    <div class="sidenav-footer mx-3 ">--}}
{{--        <div class="card card-plain shadow-none" id="sidenavCard">--}}
{{--            <img class="w-50 mx-auto" src="{{ asset('img/illustrations/icon-documentation.svg') }}" alt="sidebar_illustration">--}}
{{--            <div class="card-body text-center p-3 w-100 pt-0">--}}
{{--                <div class="docs-info">--}}
{{--                    <h6 class="mb-0">Need help?</h6>--}}
{{--                    <p class="text-xs font-weight-bold mb-0">Please check our docs</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <a href="https://www.creative-tim.com/learning-lab/bootstrap/license/argon-dashboard" target="_blank" class="btn btn-dark btn-sm w-100 mb-3">Documentation</a>--}}
{{--        <a class="btn btn-primary btn-sm mb-0 w-100" href="https://www.creative-tim.com/product/argon-dashboard-pro?ref=sidebarfree" type="button">Upgrade to pro</a>--}}
{{--    </div>--}}
</aside>
