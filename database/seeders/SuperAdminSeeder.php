<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // ── Roles তৈরি করা ──────────────────────────
        $roles = [
            'super-admin',
            'admin',
            'owner',
            'employee',
            'tenant',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // ── Super Admin user তৈরি করা ───────────────
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@ams.com'],
            [
                'name'     => 'Super Admin',
                'phone'    => '01700000000',
                'username' => 'superadmin',
                'email'    => 'superadmin@ams.com',
                'password' => Hash::make('password'),
            ]
        );

        // Super Admin role assign
        $superAdmin->assignRole('super-admin');

        $this->command->info('✅ Super Admin created!');
        $this->command->info('   Email: superadmin@ams.com');
        $this->command->info('   Phone: 01700000000');
        $this->command->info('   Password: password');
    }
}