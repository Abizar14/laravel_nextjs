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
        $users = [
            [
            'role_id' => 1,
            'jadwalkerja_id' => 1,
            'nik' => 'ABI001',
            'first_name' => 'Abizar',
            'last_name' => 'Zauli',
            'name' => 'Abizar Zauli',
            'email' => 'abizar10@example.com',
            'dob' => '2004-01-14',
            'phone_number' => '082249274860',
            'image' => 'image.jpg',
            'password' => Hash::make('abizar'),
            'position_id' => 1,
        ],
        [
            'role_id' => 1,
            'jadwalkerja_id' => 1,
            'nik' => 'ABI002',
            'first_name' => 'Abizar',
            'last_name' => 'Zauli',
            'name' => 'Abizar Zauli',
            'email' => 'abizar9@9example.com',
            // 'position' => 'Manager',
            'dob' => '2004-01-14',
            'phone_number' => '082249274860',
            'image' => 'image.jpg',
            'password' => Hash::make('abizar'),
            'position_id' => 1,
        ],
        [
            'role_id' => 1,
            'jadwalkerja_id' => 1,
            'nik' => 'ABI003',
            'first_name' => 'Abizar',
            'last_name' => 'Zauli',
            'name' => 'Abizar Zauli',
            'email' => 'abizar8@example.com',
            // 'position' => 'Manager',
            'dob' => '2004-01-14',
            'phone_number' => '082249274860',
            'image' => 'image.jpg',
            'password' => Hash::make('abizar'),
            'position_id' => 1,
        ],
        [
            'role_id' => 1,
            'jadwalkerja_id' => 1,
            'nik' => 'ABI004',
            'first_name' => 'Abizar',
            'last_name' => 'Zauli',
            'name' => 'Abizar Zauli',
            'email' => 'abizar7@example.com',
            // 'position' => 'Manager',
            'dob' => '2004-01-14',
            'phone_number' => '082249274860',
            'image' => 'image.jpg',
            'password' => Hash::make('abizar'),
            'position_id' => 1,
        ],
        [
            'role_id' => 1,
            'jadwalkerja_id' => 1,
            'nik' => 'ABI005',
            'first_name' => 'Abizar',
            'last_name' => 'Zauli',
            'name' => 'Abizar Zauli',
            'email' => 'abizar6@example.com',
            // 'position' => 'Manager',
            'dob' => '2004-01-14',
            'phone_number' => '082249274860',
            'image' => 'image.jpg',
            'password' => Hash::make('abizar'),
            'position_id' => 1,
        ],
        [
            'role_id' => 1,
            'jadwalkerja_id' => 1,
            'nik' => 'ABI006',
            'first_name' => 'Abizar',
            'last_name' => 'Zauli',
            'name' => 'Abizar Zauli',
            'email' => 'abizar5@example.com',
            // 'position' => 'Manager',
            'dob' => '2004-01-14',
            'phone_number' => '082249274860',
            'image' => 'image.jpg',
            'password' => Hash::make('abizar'),
            'position_id' => 1,
        ],
        [
            'role_id' => 1,
            'jadwalkerja_id' => 1,
            'nik' => 'ABI007',
            'first_name' => 'Abizar',
            'last_name' => 'Zauli',
            'name' => 'Abizar Zauli',
            'email' => 'abizar4@example.com',
            // 'position' => 'Manager',
            'dob' => '2004-01-14',
            'phone_number' => '082249274860',
            'image' => 'image.jpg',
            'password' => Hash::make('abizar'),
            'position_id' => 1,
        ],
        [
            'role_id' => 1,
            'jadwalkerja_id' => 1,
            'nik' => 'ABI008',
            'first_name' => 'Abizar',
            'last_name' => 'Zauli',
            'name' => 'Abizar Zauli',
            'email' => 'abizar3@example.com',
            // 'position' => 'Manager',
            'dob' => '2004-01-14',
            'phone_number' => '082249274860',
            'image' => 'image.jpg',
            'password' => Hash::make('abizar'),
            'position_id' => 1,
        ],
        [
            'role_id' => 1,
            'jadwalkerja_id' => 1,
            'nik' => 'ABI009',
            'first_name' => 'Abizar',
            'last_name' => 'Zauli',
            'name' => 'Abizar Zauli',
            'email' => 'abizar2@example.com',
            // 'position' => 'Manager',
            'dob' => '2004-01-14',
            'phone_number' => '082249274860',
            'image' => 'image.jpg',
            'password' => Hash::make('abizar'),
            'position_id' => 1,
        ],
        [
            'role_id' => 1,
            'jadwalkerja_id' => 1,
            'nik' => 'ABI010',
            'first_name' => 'Abizar',
            'last_name' => 'Zauli',
            'name' => 'Abizar Zauli',
            'email' => 'abizar1@example.com',
            // 'position' => 'Manager',
            'dob' => '2004-01-14',
            'phone_number' => '082249274860',
            'image' => 'image.jpg',
            'password' => Hash::make('abizar'),
            'position_id' => 1,
        ],
        ]
        ;
        foreach($users as $row) {
            User::create($row);
        }

    }
}
