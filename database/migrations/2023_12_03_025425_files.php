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
            Schema::create('files', function (Blueprint $table) {
                $table->Uuid('id')->primary();
                $table->string('file_path');
                $table->string('file_type');
                $table->string('file_name')->index();
                $table->string('purpose')->index()->nullable();
                $table->string('child_id')->index()->nullable();
                $table->uuid('file_size')->nullable();
                $table->char('file_auth',32)->nullable();
                $table->bigInteger('file_hits')->default(0);
                $table->uuid('user_id')->index()->nullable();
                $table->uuidMorphs('fileable');
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('files');
        }
};
