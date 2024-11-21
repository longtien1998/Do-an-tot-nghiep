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
        if(!Schema::hasTable('roles_detail')){
            Schema::create('roles_detail', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('role_id')->unique();
                $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
                $table->boolean('role_1')->default(0);
                $table->boolean('role_2')->default(0);
                $table->boolean('role_3')->default(0);
                $table->boolean('role_4')->default(0);
                $table->boolean('role_5')->default(0);
                $table->boolean('role_6')->default(0);
                $table->boolean('role_7')->default(0);
                $table->boolean('role_8')->default(0);
                $table->boolean('role_9')->default(0);
                $table->boolean('role_10')->default(0);
                $table->boolean('role_11')->default(0);
                $table->boolean('role_12')->default(0);
                $table->boolean('role_13')->default(0);
                $table->boolean('role_14')->default(0);
                $table->boolean('role_15')->default(0);
                $table->boolean('role_16')->default(0);
                $table->boolean('role_17')->default(0);
                $table->boolean('role_18')->default(0);
                $table->boolean('role_19')->default(0);
                $table->boolean('role_20')->default(0);
                $table->timestamps();
            });

        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_detail');
    }
};
