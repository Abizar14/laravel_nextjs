<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
        [
            'name'=>'Manager',
            'status' => 'Staff',
            'salary' => 5    
            

        ],
            ['name'=>'Head Office',
        'status' => 'Daily Worker',
    'salary' => 2],
        ];
        foreach($roles as $row)
        {
            Position::create($row);
        }
    }
}
