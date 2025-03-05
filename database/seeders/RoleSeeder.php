<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Role::create([
            'name'=>'super_admin'
        ]);
        Role::create([
            'name'=>'admin'
        ]);

        Role::create([
            'name'=>'user'
        ]);

    
        
    }
}
