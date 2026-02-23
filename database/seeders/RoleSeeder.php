<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $bhcAdminRole = Role::create(['name' => 'bhc-admin']);
        $boeslAdminRole = Role::create(['name' => 'boesl-admin']);
        $superAdminRole = Role::create(['name' => 'super-admin']);

        // Create default users
        $superAdmin = User::firstOrCreate([
            'email' => 'superadmin@example.com',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
        ]);
        $superAdmin->assignRole($superAdminRole);

        $boeslAdmin = User::firstOrCreate([
            'email' => 'boesl@example.com',
        ], [
            'name' => 'Boesl Admin',
            'password' => Hash::make('password'),
        ]);
        $boeslAdmin->assignRole($boeslAdminRole);

        $bhcAdmin = User::firstOrCreate([
            'email' => 'bhc@example.com',
        ], [
            'name' => 'BHC Admin',
            'password' => Hash::make('password'),
        ]);
        $bhcAdmin->assignRole($bhcAdminRole);
    }
}
