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
        Schema::table('absensi', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned()->after('id');
            $table->unsignedBigInteger('jadwalkerja_id')->after('id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('jadwalkerja_id')->references('id')->on('jadwal_kerjas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            //
        });
    }
};
