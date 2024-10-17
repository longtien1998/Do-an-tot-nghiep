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
        if (!Schema::hasTable('file_paths')) {
            Schema::create('file_paths', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('song_id');
                $table->foreign('song_id')->references('id')->on('songs')->cascadeOnDelete();
                $table->string('path_type')->nullable();
                $table->string('file_path')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_path');
    }
};
