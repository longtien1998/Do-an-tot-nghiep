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
        if(!Schema::hasTable('albums')){
            Schema::create('albums', function (Blueprint $table) {
                $table->id();
                $table->string('album_name');
                $table->unsignedBigInteger('singer_id')->nullable();
                $table->foreign('singer_id')->references('id')->on('singers')->nullOnDelete();
                $table->string('image')->nullable();
                $table->integer('listen_count')->nullable();
                $table->timestamp('creation_date');
                $table->timestamps();
            });

        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('album');
    }
};
