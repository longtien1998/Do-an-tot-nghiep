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
        if (!Schema::hasTable('songs')) {
            Schema::create('songs', function (Blueprint $table) {
                $table->id();
                $table->string('song_name');
                $table->string('description')->nullable();
                $table->text('lyrics')->nullable();
                $table->unsignedBigInteger('singers_id')->nullable();
                $table->unsignedBigInteger('categories_id')->nullable();
                $table->foreign('singers_id')->references('id')->on('singers')->nullOnDelete();
                $table->foreign('categories_id')->references('id')->on('categories')->nullOnDelete();
                $table->string('song_image');
                $table->timestamp('release_date')->nullable();
                $table->integer('listen_count')->nullable();
                $table->string('file_path')->nullable();
                $table->string('provider')->nullable();
                $table->string('composer')->nullable();
                $table->integer('download_count')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
