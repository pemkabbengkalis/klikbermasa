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
        Schema::create('layanans', function (Blueprint $table) {
            $table->Uuid('id')->primary();
            $table->foreignUuid('instansi_id')->constrained()->nullable();
            $table->string('nama')->nullable();
            $table->string('jenis')->nullable();
            $table->string('deskripsi')->nullable();
            $table->string('link')->nullable();
            $table->string('jam_operasional')->nullable();
            $table->integer('hits')->default(0);
            $table->char('display_to_home',1)->default( '0');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
