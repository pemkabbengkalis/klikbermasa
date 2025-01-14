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
        Schema::create('api_layanans', function (Blueprint $table) {
            $table->Uuid('id')->primary();
            $table->foreignUuid('layanan_id')->constrained()->nullable();
            $table->string('method')->nullable();
            $table->string('url')->nullable();
            $table->string('keterangan')->nullable();
            $table->integer('hits')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_layanans');
    }
};
