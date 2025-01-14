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
        Schema::create('tikets', function (Blueprint $table) {
            $table->Uuid('id')->primary();
            $table->foreignUuid('data_pengajuan_layanan_id')->constrained()->nullable();
            $table->string('kode')->nullable();
            $table->string('jenis_tiket')->nullable()->comment('Jika API maka tiket akan di request ke api layanan cek tiket untuk melihat status data permohonan');
            $table->string('kode_tiket_api')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tikets');
    }
};
