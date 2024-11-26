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
        if(!Schema::hasTable('contacts')){
            Schema::create('contacts', function (Blueprint $table) {
                $table->id();
                $table->string('username',50);
                $table->string('email',100);
                $table->string('topic',255 );
                $table->text('message');
                $table->boolean(column: 'acknowledge')->default(false);
                $table->boolean('dataProcessing')->default(false);
                $table->string('status')->default('waiting');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts_tables');
    }
};
