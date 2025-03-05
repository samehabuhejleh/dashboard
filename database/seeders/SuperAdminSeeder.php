<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user= User::create([
            'name'=>"super_admin",
            'email'=>"super@admin.com",
            'password'=>Hash::make("Pass@123")
        ]);

        $user->addRole('super_admin');
        $user->save();
    }
}
