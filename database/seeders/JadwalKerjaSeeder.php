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
        $jadwal = [
            [
                'shift' => 'Pagi',
                'tgl_masuk' => '2023-08-01',
                'jam_masuk' => '07:00:00',
                'jam_keluar' => '15:00:00',
            ],
            [
                'shift' => 'Malam',
                'tgl_masuk' => '2023-08-01',
                'jam_masuk' => '18:00:00',
                'jam_keluar' => '06:00:00',
            ],
        ];
        
        foreach($jadwal as $row)
        {
            JadwalKerja::create($row);
        }

    }
}
