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
        Schema::create('meetingreponses', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->unsignedBigInteger('meeting_id');
            $table->enum('response', ['yes', 'no']);
            $table->timestamps();
            $table->foreign('meeting_id')->references('id')->on('visitors')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetingreponses');
    }
};
