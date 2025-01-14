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
        Schema::create('field_form_layanans', function (Blueprint $table) {
            $table->Uuid('id')->primary();
            $table->foreignUuid('layanan_id')->constrained()->nullable();
            $table->string('judul_kolom')->nullable();
            $table->string('nama_kolom')->nullable();
            $table->string('jenis_input')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('wajib')->nullable();
            $table->string('status')->nullable();
            $table->integer('urutan')->default(0);
            $table->string('petunjuk')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_form_layanans');
    }
};
