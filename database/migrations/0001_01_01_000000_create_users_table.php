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
            $table->integer('cedula')->primary();
            $table->string('name');
            $table->string('lastname');
            $table->date('birthDate');
            $table->string('email')->unique();
            $table->integer('phoneNum');
            $table->string('password');
            $table->string('image');
            $table->string('state');
            $table->string('userType');
            $table->string('token');
            $table->datetime('expiration_token');
        });

        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->foreign('user_id')
                ->references('cedula')
                ->on('users')
                ->onDelete('cascade');
            $table->date('date');
            $table->string('leavePlace');
            $table->string('destinationPlace');
            $table->integer('resultsNum');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('movements');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('rides');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('users');

    }
};