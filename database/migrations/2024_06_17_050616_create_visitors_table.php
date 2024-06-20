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
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('visit_code')->unique();
            $table->string('qr_code')->unique();
            $table->string('visit_date');
            $table->dateTime('check_in_time')->nullable();
            $table->dateTime('check_out_time')->nullable();
            $table->unsignedBigInteger('host_id')->nullable();
            $table->string('real_time_photo')->nullable();
            $table->string('companyname')->nullable();
            $table->string('group_name')->nullable();
            $table->enum('purpose', ['appointment', 'interview', 'service call', 'client/customervisit'])->nullable();
            $table->enum('type', ['single', 'group'])->nullable();
            $table->timestamps();
            $table->foreign('host_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
