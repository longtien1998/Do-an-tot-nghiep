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
        if (!Schema::hasTable('rangking_logs')) {
            Schema::create('rangking_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('song_id');
                $table->foreign('song_id')->references('id')->on('songs')->cascadeOnDelete();
                $table->integer('listen_count')->default(0);
                $table->integer('download_count')->default(0);
                $table->integer('like_count')->default(0);
                $table->date('date'); // Ngày cụ thể
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rangking_logs');
    }
};
