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
        if(!Schema::hasTable('migrations')){
            Schema::create('copyrights', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('song_id')->nullable();
                $table->unsignedBigInteger('publisher_id')->nullable();
                $table->foreign('song_id')->references('id')->on('songs')->nullOnDelete();
                $table->foreign('publisher_id')->references('id')->on('publishers')->nullOnDelete();
                $table->string('license_type',50)->nullable();
                $table->timestamp('issue_date')->nullable();
                $table->timestamp('expiry_date')->nullable();
                $table->text('usage_rights')->nullable();
                $table->text('tems')->nullable();
                $table->string('license_file')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('copyrights');
    }
};
