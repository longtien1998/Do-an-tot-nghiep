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
        if (!Schema::hasTable('payments')) {
            Schema::create('payments', function (Blueprint $table) {
                $table->id();
                $table->string('description')->nullable();
                $table->timestamp('payment_date');
                $table->string('payment_method')->nullable();
                $table->decimal('amount', 10, 2);
                $table->unsignedBigInteger('users_id')->nullable();
                $table->foreign('users_id')->references('id')->on('users')->nullOnDelete();
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
        Schema::dropIfExists('payments');
    }
};
