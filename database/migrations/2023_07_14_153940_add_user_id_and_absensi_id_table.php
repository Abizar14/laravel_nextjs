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
        Schema::table('cutis', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            // $table->unsignedBigInteger('absensi_id')->after('id');
            $table->integer('jumlah_cuti')->after('user_id');

            $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('absensi_id')->references('id')->on('absensi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cutis', function (Blueprint $table) {
            //
        });
    }
};
