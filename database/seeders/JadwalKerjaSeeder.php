<?php

namespace Database\Seeders;

use App\Models\JadwalKerja;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jadwal_kerjas')->insert([
            'user_id' => 1,
            'slug' => 'Pagi',
            'tgl_masuk' => '2023-07-14',
            'jam_masuk' => '07:00:00',
            'jam_keluar' => '15:00:00'
        ]);

    }
}
