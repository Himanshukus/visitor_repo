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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('plainpassword');
            $table->boolean('portal_user')->default(false); 
            $table->boolean('is_online')->default(false); 
            $table->string('profile_picture')->nullable();
            $table->string('staff_id')->unique()->nullable(); 
            $table->string('department_id')->nullable(); 
            $table->enum('type', ['admin', 'staff'])->default('staff');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
