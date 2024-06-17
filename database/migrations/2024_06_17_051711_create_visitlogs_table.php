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
        Schema::create('visitlogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visitor_id')->constrained();
            $table->foreignId('staff_id')->nullable()->constrained();
            $table->string('action'); // e.g., 'check-in', 'check-out', 'appointment-created'
            $table->dateTime('entry_time');
            $table->dateTime('exit_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitlogs');
    }
};
