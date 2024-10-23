@extends('dashboard.layouts.main')

@section('breadcrumb')
    <x-breadcrumb title="Data Role" page="Master Data" active="Role"/>
@endsection

@section('content')
    <div class="row">
        <div class="row mt-4 mt-lg-0">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header mb-0 pb-0">
                        <div class="row">
                            <div class="col-lg-4 col-12">
                                <h6>Data Role</h6>
                            </div>
                            <div class="col-lg-8 col-12 parent-button">
                                <div>
                                    @if(request()->has('view_deleted'))
                                        <a href="{{ route('users.index') }}"
                                           class="btn bg-gradient-info btn-sm mb-0 btn-action">
                                            <i class="fa fa-list"></i> &nbsp; View All Role
                                        </a>
                                        @if($users->total() < 1)
                                            <a href="{{ route('users.restore.all') }}"
                                               class="btn bg-gradient-primary btn-sm mb-0 disabled btn-action show-confirm-restore-all">
                                                <i class="fa fa-undo"></i> &nbsp; Restore All
                                            </a>
                                        @else
                                            <a href="{{ route('users.restore.all') }}"
                                               class="btn bg-gradient-primary btn-sm mb-0 btn-action show-confirm-restore-all">
                                                <i class="fa fa-undo"></i> &nbsp; Restore All
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('users.index', ['view_deleted' => 'DeletedRecords']) }}"
                                           class="btn bg-gradient-info btn-sm mb-0 btn-action">
                                            <i class="fas fa-trash-restore"></i> &nbsp; View Delete Records
                                        </a>
                                        <a href="javascript:void(0);"
                                           class="btn bg-gradient-primary btn-sm mb-0 btn-action" data-bs-toggle="modal" data-bs-target="#create-user-modal-form">
                                            +&nbsp; Tambah Role
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @php
                            $actionUrl = request()->has('view_deleted') ? route('users.index', ['view_deleted' => 'DeletedRecords']) : route('users.index');
                        @endphp
                        <div class="row mt-2 pb-0">
                            <form action="" method="get" class="pb-0 m-0">
                                <div class="col-md-12 pb-0">
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
                            </form>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive pt-0 px-4">
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr style="border-top-width: 1px;">
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        No
                                    </th>
                                    <th style="width: 50%;" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Role
                                    </th>
                                    <th style="width: 25%;" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Guard Name
                                    </th>
                                    <th style="width: 12%;" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Dibuat
                                    </th>
                                    <th class="text-secondary opacity-7"></th>
                                </tr>
                                </thead>
                                <tbody>
{{--                                @if($users->total() < 1)--}}
{{--                                    <tr style="border-bottom: 1px solid #ccdddd;">--}}
{{--                                        <td colspan="6">--}}
{{--                                            <p class="text-center text-xs mb-0 py-1">Data tidak ditemukan.</p>--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
{{--                                @else--}}
{{--                                    @foreach($users as $user)--}}
{{--                                        <tr style="border-bottom: 1px solid #ccdddd;">--}}
{{--                                            <td>--}}
{{--                                                <div class="d-flex px-2 py-1">--}}
{{--                                                    <div>--}}
{{--                                                        @if($user->image !== 'default.png')--}}
{{--                                                            @php--}}
{{--                                                                $dataImage = explode("/", $user->image);--}}
{{--                                                                $imageUrl = ($dataImage[0] == 'users') ? asset('img/' . $user->image) : asset('storage/' . $user->image);--}}
{{--                                                            @endphp--}}
{{--                                                        @else--}}
{{--                                                            @php $imageUrl = asset('img/' . $user->image); @endphp--}}
{{--                                                        @endif--}}

{{--                                                        <img src="{{ $imageUrl }}"--}}
{{--                                                             class="avatar avatar me-3 shadow"--}}
{{--                                                             alt="user-image-profile">--}}
{{--                                                    </div>--}}
{{--                                                    <div class="d-flex flex-column justify-content-center">--}}
{{--                                                        <p class="mb-0 text-sm text-bold" style="cursor: pointer" onclick="window.location.href='{{ url('/master/users/' . $user->id) }}'">{{ $user->name }}</p>--}}
{{--                                                        <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </td>--}}
{{--                                            <td class="align-middle">--}}
{{--                                                <p class="text-xs text-secondary mb-0">{{ $user->user_code }}</p>--}}
{{--                                            </td>--}}
{{--                                            <td class="align-middle">--}}
{{--                                                <p class="text-xs text-secondary mb-0">{{ $user->phone ?? '-' }}</p>--}}
{{--                                            </td>--}}
{{--                                            <td class="align-middle">--}}
{{--                                                <p class="text-xs text-secondary mb-0">{{ $user->address ?? '-' }}</p>--}}
{{--                                            </td>--}}
{{--                                            --}}{{--                                            <td class="align-middle">--}}
{{--                                            --}}{{--                                                @if ($user->studyProgram)--}}
{{--                                            --}}{{--                                                    <p class="text-xs font-weight-bold mb-0">{{ $user->studyProgram->name }}</p>--}}
{{--                                            --}}{{--                                                    <p class="text-xs text-secondary mb-0">{{ $user->interestArea->name }}</p>--}}
{{--                                            --}}{{--                                                @else--}}
{{--                                            --}}{{--                                                    <p class="text-xs text-secondary mb-0">-</p>--}}
{{--                                            --}}{{--                                                @endif--}}
{{--                                            --}}{{--                                            </td>--}}
{{--                                            <td class="align-middle">--}}
{{--                                                <p class="text-xs font-weight-bold mb-0">{{ $user->dibuat->name ?? 'Administrator' }}</p>--}}
{{--                                                <p class="text-xs text-secondary mb-0">{{ $user->created_at }}</p>--}}
{{--                                            </td>--}}
{{--                                            <td class="align-middle text-xs text-end action">--}}
{{--                                                @if(request()->has('view_deleted'))--}}
{{--                                                    <a href="{{ route('users.restore', $user->id) }}"--}}
{{--                                                       class="mx-1 badge bg-gradient-success show-confirm-restore">--}}
{{--                                                        <i class="fa fa-check text-white"></i> &nbsp; Restore--}}
{{--                                                    </a>--}}
{{--                                                @else--}}
{{--                                                    <a href="{{ url('/master/users/' . $user->id) }}"--}}
{{--                                                       class="badge bg-gradient-info">--}}
{{--                                                        <i class="fas fa-eye text-white"></i> &nbsp; Detail--}}
{{--                                                    </a>--}}
{{--                                                    <a href="javascript:void(0);"--}}
{{--                                                       class="mx-1 badge bg-gradient-warning" data-bs-toggle="modal" data-bs-target="#edit-user-modal-form{{ $user->id }}">--}}
{{--                                                        <i class="fas fa-edit text-white"></i> &nbsp; Edit--}}
{{--                                                    </a>--}}
{{--                                                    <form action="{{ url('/master/users/' . $user->id) }}"--}}
{{--                                                          method="post" class="d-inline">--}}
{{--                                                        @csrf--}}
{{--                                                        @method('delete')--}}
{{--                                                        <button type="submit"--}}
{{--                                                                class="badge bg-gradient-danger border-0 show-confirm-delete">--}}
{{--                                                            <i class="fas fa-trash text-white"></i> &nbsp; Hapus--}}
{{--                                                        </button>--}}
{{--                                                    </form>--}}
{{--                                                @endif--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                        @include('dashboard.users.modals.edit')--}}
{{--                                    @endforeach--}}
{{--                                @endif--}}
                                </tbody>
                            </table>
                        </div>
{{--                        <div class="d-flex justify-content-end pt-3 pe-4">--}}
{{--                            {{ $users->links() }}--}}
{{--                        </div>--}}
                    </div>
{{--                    @include('dashboard.users.modals.create')--}}
                </div>
            </div>
        </div>
    </div>
@endsection
{{--@section('scripts')--}}
{{--    <script>--}}
{{--        function previewImage(imageInputId, imagePreviewClass, defaultImageUrl) {--}}
{{--            const imageUser = document.querySelector(`#${imageInputId}`);--}}
{{--            const userImgPreview = document.querySelector(`.${imagePreviewClass}`);--}}

{{--            if (imageUser.files && imageUser.files[0]) {--}}
{{--                const oFReader = new FileReader();--}}
{{--                oFReader.readAsDataURL(imageUser.files[0]);--}}

{{--                oFReader.onload = function(oFREvent) {--}}
{{--                    userImgPreview.src = oFREvent.target.result; // Update src to the selected image--}}
{{--                }--}}
{{--            } else {--}}
{{--                userImgPreview.src = defaultImageUrl; // Set back to default if no file is chosen--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}
{{--    @if ($errors->any())--}}
{{--        <script>--}}
{{--            document.addEventListener("DOMContentLoaded", function() {--}}
{{--                var myModal = new bootstrap.Modal(document.getElementById('create-user-modal-form'));--}}
{{--                myModal.show();--}}
{{--            });--}}
{{--        </script>--}}
{{--    @endif--}}
{{--@endsection--}}