<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed admin account
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@sample.com',
            'password' => 'admin123',
            'email_verified_at' => now()
        ]);

        // Seed admin role
        $role = Role::create([
            'role_name' => 'administrator'
        ]);

        // Set role of admin account as an admin
        DB::table('role_user')->insert([
            'user_id' => $user->id,
            'role_type_id' => $role->id
        ]);
    }
}
