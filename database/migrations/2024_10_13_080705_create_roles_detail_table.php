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
        Schema::create('roles_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->boolean('role_1');
            $table->boolean('role_2');
            $table->boolean('role_3');
            $table->boolean('role_4');
            $table->boolean('role_5');
            $table->boolean('role_6');
            $table->boolean('role_7');
            $table->boolean('role_8');
            $table->boolean('role_9');
            $table->boolean('role_10');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_detail');
    }
};
