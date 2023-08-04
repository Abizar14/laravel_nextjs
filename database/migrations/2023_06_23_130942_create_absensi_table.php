<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->enum('keterangan',['Masuk','Alpha','Telat']);
            $table->string('terlambat')->nullable();
            $table->date('tanggal')->nullable();
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->time('jam_kerja')->nullable();
            $table->string('image')->nullable();
            $table->point('coordinates')->nullable();
            $table->timestamps();

            
            // $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('jadwalkerja_id')->references('id')->on('jadwal_kerjas');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
