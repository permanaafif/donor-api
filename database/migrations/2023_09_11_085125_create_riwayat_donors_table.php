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
        Schema::create('riwayat_donors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pendonor')->nullable(false);
            $table->integer('jumlah_donor')->nullable(false);
            $table->dateTime('tanggal_donor')->nullable(false);
            $table->unsignedBigInteger('id_stok_darah')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_donors');
    }
};
