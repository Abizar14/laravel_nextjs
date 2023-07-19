<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $roles = [
            ['name'=>'admin'],
            ['name'=>'karyawan'],
        ];
        foreach($roles as $row)
        {
            Roles::create($row);
        }
    }
}
