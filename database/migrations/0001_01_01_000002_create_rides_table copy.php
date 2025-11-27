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
        Schema::create('rides', function (Blueprint $table) {
            $table->id()->primary();
            $table->string('name');
            $table->string('origin');
            $table->string('destination');
            $table->string('date');
            $table->string('time');
            $table->string('space_cost');
            $table->integer('space');

            $table->integer('user_id');
            $table->foreign('user_id')
                ->references('cedula')
                ->on('users')
                ->onDelete('cascade');

            $table->integer('vehicle_id');

            $table->foreign('vehicle_id')
                ->references('plateNum')
                ->on('vehicles')
                ->onDelete('cascade');
            $table->string('status');

        });

        Schema::create('bookings', function (Blueprint $table) {
            $table->id()->primary();

            $table->integer('user_id');

            $table->foreign('user_id')
                ->references('cedula')
                ->on('users')
                ->onDelete('cascade');

            $table->string('status');

            $table->unsignedBigInteger('ride_id');

            $table->foreign('ride_id')
                ->references('id')
                ->on('rides')
                ->onDelete('cascade');

            $table->string('date');
            $table->integer('driver_id');

            $table->foreign('driver_id')
                ->references('cedula')
                ->on('users')
                ->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movements');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('rides');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('users');

    }
};