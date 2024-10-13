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
        Schema::create('file_path', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('song_id');
            $table->foreign('song_id')->references('id')->on('songs')->cascadeOnDelete();
            $table->string('path_type');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_path');
    }
};
