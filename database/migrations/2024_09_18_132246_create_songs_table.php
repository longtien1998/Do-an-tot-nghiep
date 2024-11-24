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
                $table->unsignedBigInteger('singer_id')->nullable();
                $table->unsignedBigInteger('category_id')->nullable();
                $table->foreign('singer_id')->references('id')->on('singers')->nullOnDelete();
                $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
                $table->string('song_image')->nullable();
                $table->unsignedBigInteger('country_id')->nullable();
                $table->foreign('country_id')->references('id')->on('country')->nullOnDelete();
                $table->timestamp('release_day')->nullable();
                $table->string('time')->nullable();
                $table->integer('listen_count')->default(0);
                $table->string('provider')->nullable();
                $table->string('composer')->nullable();
                $table->integer('download_count')->default(0);
                $table->integer('like_count')->default(0);
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
