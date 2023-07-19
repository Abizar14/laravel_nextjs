<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FakerDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            'role_id' => 1,
            // 'jadwalkerja_id' => 1,
            'nik' => 'ABI001',
            'first_name' => 'Abizar',
            'last_name' => 'Zauli',
            'name' => 'Abizar Zauli',
            'email' => 'abizar@example.com',
            'position' => 'Manager',
            'dob' => '2004-01-14',
            'phone_number' => '082249274860',
            'image' => 'image.jpg',
            'password' => Hash::make('abizar'),
        ]);
    }
}
