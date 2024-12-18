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
        if (!Schema::hasTable('singers')){
            Schema::create('singers', function (Blueprint $table) {
                $table->id();
                $table->string('singer_name');
                $table->string('singer_image');
                $table->string('singer_background');
                $table->date('singer_birth_date')->nullable();
                $table->string('singer_gender',10);
                $table->text('singer_biography')->nullable();
                $table->string('singer_country',100);
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
        Schema::dropIfExists('singers');
    }
};
