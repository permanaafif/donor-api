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
        Schema::create('riwayat_ambils', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_riwayat_donor')->nullable(false);
            $table->integer('jumlah_ambil')->nullable(false);
            $table->dateTime('tanggal_ambil')->nullable(false);
            $table->string('penerima', 100)->nullable(false);
            $table->string('kontak_penerima', 20)->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_ambils');
    }
};
