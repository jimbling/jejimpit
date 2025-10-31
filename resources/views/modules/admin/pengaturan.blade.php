@extends('layouts.tabler')

@section('title', $title ?? 'Pengaturan Profil')

@section('page-title', 'Pengaturan Profil')

@section('content')
    <div class="container-xl">
        <div class="card">
            <div class="row g-0">
                <!-- Sidebar Menu -->
                <div class="col-12 col-md-3 border-end bg-body">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <span class="avatar avatar-xl me-3"
                                style="background-image: url({{ asset('storage/avatars/' . ($user->avatar ?? 'default-avatar.png')) }})"></span>
                            <div>
                                <h3 class="mb-0">{{ auth()->user()->name }}</h3>
                                <div class="text-muted">{{ auth()->user()->email }}</div>
                            </div>
                        </div>

                        <h4 class="subheader text-uppercase fs-xs mb-3">Menu Pengaturan</h4>
                        <div class="list-group list-group-transparent">
                            <a href="#" data-target="my-account"
                                class="list-group-item list-group-item-action d-flex align-items-center active">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon icon-tabler icon-tabler-user-circle me-2" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                                    <path d="M12 10m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                    <path d="M6.168 18.849a4 4 0 0 1 3.832 -2.849h4a4 4 0 0 1 3.834 2.855" />
                                </svg>
                                Informasi Akun
                            </a>
                            <a href="#" data-target="section-permissions"
                                class="list-group-item list-group-item-action d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key me-2"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z" />
                                    <path d="M15 9h.01" />
                                </svg>
                                Hak Akses
                            </a>
                            <a href="#" data-target="section-roles"
                                class="list-group-item list-group-item-action d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users me-2"
                                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                </svg>
                                Peran Pengguna
                            </a>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <div class="text-muted mb-1">Status Akun</div>
                            <div class="d-flex align-items-center">
                                <span class="badge bg-success-lt me-2">Aktif</span>
                                <small class="text-secondary">Bergabung
                                    {{ auth()->user()->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Content -->
                <div class="col-12 col-md-9 d-flex flex-column">
                    <div class="card-body p-4">
                        <!-- My Account -->
                        <div id="my-account" class="settings-section">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h2 class="mb-0">Informasi Akun</h2>
                                <div class="text-muted">Terakhir diperbarui:
                                    {{ auth()->user()->updated_at->diffForHumans() }}</div>
                            </div>

                            <div class="row">
                                <div class=" mx-auto">
                                    <!-- Profile Information -->
                                    <div class="card card-active mb-4">
                                        <div class="card-header">
                                            <h3 class="card-title">Informasi Profil</h3>
                                        </div>
                                        <div class="card-body">
                                            @include('modules.profile.partials.update-profile-information-form')
                                        </div>
                                    </div>

                                    <!-- Change Password -->
                                    <div class="card card-active mb-4">
                                        <div class="card-header">
                                            <h3 class="card-title">Keamanan Akun</h3>
                                        </div>
                                        <div class="card-body">
                                            @include('modules.profile.partials.update-password-form')
                                        </div>
                                    </div>

                                    <!-- Delete Account -->
                                    <div class="card card-danger mb-4">
                                        <div class="card-header">
                                            <h3 class="card-title text-danger">Hapus Akun</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="alert alert-danger">
                                                <strong>Peringatan!</strong> Tindakan ini akan menghapus akun Anda secara
                                                permanen. Semua data akan dihapus dan tidak dapat dikembalikan.
                                            </div>
                                            @include('modules.profile.partials.delete-user-form')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hak Akses -->
                        <div id="section-permissions" class="settings-section d-none">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h2 class="mb-0">Hak Akses Saya</h2>
                                <div class="text-muted">{{ $permissions_grouped->flatten()->count() }} hak akses</div>
                            </div>

                            @if ($permissions_grouped->isEmpty())
                                <div class="empty">
                                    <div class="empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-lock-off" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M15 11h2a2 2 0 0 1 2 2v2m0 4a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2h4" />
                                            <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                                            <path d="M8 11v-3m.719 -3.289a4 4 0 0 1 7.281 2.289v4" />
                                            <path d="M3 3l18 18" />
                                        </svg>
                                    </div>
                                    <p class="empty-title">Tidak ada hak akses khusus</p>
                                    <p class="empty-subtitle text-muted">
                                        Anda belum memiliki hak akses khusus. Hubungi administrator untuk mendapatkan akses
                                        tambahan.
                                    </p>
                                </div>
                            @else
                                <div class="row">
                                    @foreach ($permissions_grouped as $group => $permissions)
                                        <div class="col-md-6 mb-4">
                                            <div class="card h-100">
                                                <div class="card-header">
                                                    <h3 class="card-title mb-0">{{ strtoupper($group ?? 'Tanpa Grup') }}
                                                    </h3>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-sm table-vcenter card-table">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 10%">#</th>
                                                                <th>Nama Hak Akses</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($permissions as $index => $permission)
                                                                <tr>
                                                                    <td class="text-muted">{{ $index + 1 }}</td>
                                                                    <td>
                                                                        <span class="badge bg-blue-lt text-uppercase">
                                                                            {{ $permission }}
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>



                        <!-- Roles -->
                        <div id="section-roles" class="settings-section d-none">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h2 class="mb-0">Peran Saya</h2>
                                <div class="text-muted">{{ count($roles) }} peran</div>
                            </div>

                            @if (empty($roles))
                                <div class="empty">
                                    <div class="empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-user-off" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path
                                                d="M8.18 8.189a4.01 4.01 0 0 0 2.616 2.627m3.507 -.545a4 4 0 1 0 -5.59 -5.552" />
                                            <path
                                                d="M6 21v-2a4 4 0 0 1 4 -4h4c.412 0 .81 .062 1.183 .178m2.633 2.618c.12 .38 .184 .785 .184 1.204v2" />
                                            <path d="M3 3l18 18" />
                                        </svg>
                                    </div>
                                    <p class="empty-title">Tidak ada peran yang ditetapkan</p>
                                    <p class="empty-subtitle text-muted">
                                        Anda belum memiliki peran khusus. Hubungi administrator untuk menetapkan peran.
                                    </p>
                                </div>
                            @else
                                <div class="row row-cards">
                                    @foreach ($roles as $role)
                                        <div class="mb-4">
                                            <div class="card card-sm shadow-sm h-100">
                                                <div class="card-body d-flex flex-column">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <span
                                                            class="avatar avatar-lg me-3 {{ $role === 'super-admin' ? 'bg-red-lt' : ($role === 'admin' ? 'bg-yellow-lt' : 'bg-blue-lt') }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-shield" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path
                                                                    d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3" />
                                                            </svg>
                                                        </span>
                                                        <div>
                                                            <h3 class="card-title mb-1 text-capitalize">
                                                                {{ $role }}</h3>
                                                            <p class="text-muted text-sm mb-0">
                                                                @if ($role === 'super-admin')
                                                                    Pengelola sistem utama dengan akses penuh.
                                                                @elseif ($role === 'admin')
                                                                    Administrator sekolah, dapat mengelola data penting.
                                                                @elseif ($role === 'user')
                                                                    Pengguna biasa, memiliki akses terbatas sesuai
                                                                    kebutuhan.
                                                                @else
                                                                    Peran khusus dalam sistem.
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="mt-auto">
                                                        <span
                                                            class="badge bg-{{ $role === 'super-admin' ? 'red' : ($role === 'admin' ? 'yellow' : 'blue') }}-lt">
                                                            {{ strtoupper($role) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Sembunyikan semua section dan tampilkan yang pertama
                $('.settings-section').hide().removeClass('d-none');
                $('#my-account').show().addClass('animate__animated animate__fadeIn animate__faster');

                $('.list-group-item').click(function(e) {
                    e.preventDefault();

                    // Active state
                    $('.list-group-item').removeClass('active');
                    $(this).addClass('active');

                    const target = $(this).data('target');

                    // Hide current with animation
                    $('.settings-section:visible')
                        .removeClass('animate__fadeIn')
                        .addClass('animate__animated animate__fadeOut animate__faster')
                        .one('animationend', function() {
                            $(this).hide().removeClass(
                                'animate__animated animate__fadeOut animate__faster');

                            // Show next with animation
                            $('#' + target)
                                .show()
                                .addClass('animate__animated animate__fadeIn animate__faster');
                        });
                });
            });
        </script>
    @endpush

    <!-- Modal for uploading avatar -->
    <div class="modal fade" id="uploadAvatarModal" tabindex="-1" aria-labelledby="uploadAvatarModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadAvatarModalLabel">Unggah Avatar Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form for uploading avatar -->
                    <form method="POST" action="{{ route('profile.update-avatar') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="avatar" class="form-label">Pilih Avatar</label>
                            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*"
                                required>
                            @error('avatar')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Unggah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus Akun -->
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="confirmUserDeletionModalLabel">
                        {{ __('Are you sure you want to delete your account?') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="modal-status bg-danger"></div>
                </div>

                <div class="modal-body">

                    <p class="text-muted">
                        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                    </p>

                    <!-- Form untuk menghapus akun -->
                    <form id="confirmUserDeletionModalForm" method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" name="password" type="password" class="form-control"
                                placeholder="{{ __('Password') }}" required />

                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ __('Cancel') }}
                    </button>

                    <!-- Tombol submit yang sekarang berada dalam form -->
                    <button type="submit" class="btn btn-danger" form="confirmUserDeletionModalForm">
                        {{ __('Delete Account') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
