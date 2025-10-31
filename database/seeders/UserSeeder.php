<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 Buat role super-admin & user
        $roleSuperAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $roleUser = Role::firstOrCreate(['name' => 'user']);

        // 🔹 Pastikan super-admin punya semua permission
        $permissions = Permission::all();
        $roleSuperAdmin->syncPermissions($permissions);

        // 🔹 Buat super-admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );
        $superAdmin->assignRole($roleSuperAdmin);

        // 🔹 Buat 10 user biasa
        for ($i = 1; $i <= 10; $i++) {
            $user = User::firstOrCreate(
                ['email' => "user{$i}@example.com"],
                [
                    'name' => "User {$i}",
                    'password' => Hash::make('password'),
                ]
            );
            $user->assignRole($roleUser);
        }
    }
}
