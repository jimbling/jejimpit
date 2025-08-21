@extends('layouts.petugas')

@section('content')
    <div class="min-h-screen ">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-0">

            <!-- Header dengan judul halaman -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Profil Saya</h1>
                <p class="text-gray-600 mt-1">Kelola informasi profil dan keamanan akun Anda</p>
            </div>

            <!-- Informasi Profil Card -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-5">
                <div class="border-b border-gray-100 px-5 py-4">
                    <h2 class="font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-user-circle text-blue-500 mr-2"></i>
                        Informasi Profil
                    </h2>
                </div>
                <div class="p-5">
                    @include('modules.profile.petugas.update-profile-information-form')
                </div>
            </div>

            <!-- Ubah Password Card -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-5">
                <div class="border-b border-gray-100 px-5 py-4">
                    <h2 class="font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-lock text-blue-500 mr-2"></i>
                        Keamanan Akun
                    </h2>
                </div>
                <div class="p-5">
                    @include('modules.profile.petugas.update-password-form')
                </div>
            </div>

        </div>
    </div>
@endsection
