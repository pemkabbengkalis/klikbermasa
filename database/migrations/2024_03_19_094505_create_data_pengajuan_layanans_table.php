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
        Schema::create('data_pengajuan_layanans', function (Blueprint $table) {
            $table->Uuid('id')->primary();
            $table->foreignUuid('layanan_id')->constrained()->nullable();
            $table->foreignUuid('instansi_id')->constrained()->nullable();
            $table->foreignUuid('user_id')->constrained()->nullable();
            $table->json('data_pengajuan')->nullable();
            $table->string('dibaca')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pengajuan_layanans');
    }
};
