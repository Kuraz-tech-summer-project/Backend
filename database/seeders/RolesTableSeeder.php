<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the role names
        $roles = [
            ['name' => 'admin'],
            ['name' => 'user'],
        ];
        
        Role::insert($roles);
    }
}
