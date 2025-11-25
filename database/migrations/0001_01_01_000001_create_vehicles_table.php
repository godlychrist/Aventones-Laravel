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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id()->primary();
            $table->integer('plateNum')->unique();
            $table->string('color');
            $table->string('brand');
            $table->string('model');
            $table->date('year');
            $table->string('image');
            $table->integer('user_id');
            $table->foreign('user_id')
                ->references('cedula')
                ->on('users')
                ->onDelete('cascade');
            $table->integer('capacity');

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