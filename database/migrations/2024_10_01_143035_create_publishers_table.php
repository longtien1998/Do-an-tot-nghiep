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
        if (!Schema::hasTable('publishers')) {
            Schema::create('publishers', function (Blueprint $table) {
                $table->id();
                $table->string('publisher_name');
                $table->string('alias_name')->nullable();
                $table->string('country', 100)->nullable();
                $table->string('city', 100)->nullable();
                $table->string('address',255)->nullable();
                $table->string('website')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();
                $table->string('logout')->nullable();
                $table->string('description')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publishers');
    }
};
