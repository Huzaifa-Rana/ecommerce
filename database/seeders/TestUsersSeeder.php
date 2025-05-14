<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Test Admin',
                'password' => Hash::make('password'), // You can change this
            ]
        );

        // Assign admin role
        if (!$admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }

        // Create Customer User
        $customer = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Test Customer',
                'password' => Hash::make('password'), // You can change this
            ]
        );

        // Assign customer role
        if (!$customer->hasRole('customer')) {
            $customer->assignRole($customerRole);
        }
    }
}
