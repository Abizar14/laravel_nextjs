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
        Schema::create('jadwal_kerjas', function (Blueprint $table) {
            $table->id();

            $table->string('shift');
            $table->date('tgl_masuk');
    
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();

            // $table->foreign('user_id')->references('id')->on('users');


            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_kerjas');
    }
};
