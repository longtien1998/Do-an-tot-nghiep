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
        if(!Schema::hasTable('country')){
            Schema::create('country', function (Blueprint $table) {
                $table->id();
                $table->string('name_country')->unique();
                $table->string('description_country')->nullable();
                $table->string('background')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });

        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country');
    }
};
