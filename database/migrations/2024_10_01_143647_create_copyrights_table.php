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
        if(!Schema::hasTable('copyrights')){
            Schema::create('copyrights', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('song_id')->nullable();
                $table->unsignedBigInteger('publisher_id')->nullable();
                $table->foreign('song_id')->references('id')->on('songs')->nullOnDelete();
                $table->foreign('publisher_id')->references('id')->on('publishers')->nullOnDelete();
                $table->string('license_type',50)->nullable();
                $table->timestamp('issue_day')->nullable();
                $table->timestamp('expiry_day')->nullable();
                $table->text('usage_rights')->nullable();
                $table->text('terms')->nullable();
                $table->integer('price')->nullable();
                $table->string('payment')->nullable();
                $table->string('location',255)->nullable();
                $table->timestamp('pay_day')->nullable();
                $table->string('license_file')->nullable();
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
        Schema::dropIfExists('copyrights');
    }
};
