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
        if(!Schema::hasTable('favorite_album')){
            Schema::create('favorite_album', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('album_id')->nullable();
                $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
                $table->foreign('album_id')->references('id')->on('albums')->nullOnDelete();
                $table->timestamps();
            });

        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_album');
    }
};
