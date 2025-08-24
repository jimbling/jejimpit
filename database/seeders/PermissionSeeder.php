<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Format: [name, group]
            ['lihat hak akses', 'Administrator'],
            ['lihat sistem', 'Administrator'],
            ['lihat pemeliharaan', 'Administrator'],
            ['lihat pembaruan', 'Administrator'],
            ['edit hak akses', 'Administrator'],
            ['update hak akses', 'Administrator'],
            ['update peran', 'Administrator'],
            ['reset password', 'Administrator'],
            ['hapus akun', 'Administrator'],
            ['atur sistem', 'Administrator'],
            ['atur dokumen', 'Administrator'],
            ['atur gdrive', 'Administrator'],
            ['atur jimpitan', 'Administrator'],
            ['entri jimpitan', 'Administrator'],
            ['atur warga', 'Administrator'],
            ['tambah akun', 'Administrator'],
            ['atur bku', 'Administrator'],
            ['atur penerimaan', 'Administrator'],
            ['atur pengeluaran', 'Administrator'],






            // GUNAKAN PERINTAH php artisan seed:akses UNTUK MENJALANKAN SEEDER INI
        ];

        foreach ($permissions as [$name, $group]) {
            Permission::firstOrCreate(
                ['name' => $name],
                ['guard_name' => 'web', 'group' => $group]
            );
        }


        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
