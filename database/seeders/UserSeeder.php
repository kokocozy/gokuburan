<?php

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exists = User::where('email', 'admin@admin.admin')->exists();

        if (!$exists) {
            $user = new User();
            $user->name = 'Admin';
            $user->email = 'admin@admin.admin';
            $user->password = Hash::make('password');
            $user->address = 'Jakarta';
            $user->role = Role::Admin;
            $user->save();
            $user->markEmailAsVerified();
        }
    }
}
