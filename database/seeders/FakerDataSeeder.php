<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class FakerDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Buat beberapa contoh pengguna dengan data palsu
        for ($i = 0; $i < 10; $i++) {
            $password = $faker->password;
            
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'image' => $faker->imageUrl, // Menggunakan URL gambar palsu
                'jabatan' => $faker->randomElement(['Bos', 'Manager', 'Staff', 'Karyawan']),
                'role' => $faker->randomElement([0, 1]),
                'password' => Hash::make($password)
            ]);
        }
    }
}
