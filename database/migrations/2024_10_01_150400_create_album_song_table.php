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
        if(!Schema::hasTable('album_song')){
            Schema::create('album_song', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('album_id')->nullable();
                $table->unsignedBigInteger('song_id')->nullable();
                $table->foreign('album_id')->references('id')->on('albums')->nullOnDelete();
                $table->foreign('song_id')->references('id')->on('songs')->nullOnDelete();
                $table->timestamps();
            });

        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('album_song');
    }
};
