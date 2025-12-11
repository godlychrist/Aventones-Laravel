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
        Schema::table('bookings', function (Blueprint $table) {
            // Agregar el campo created_at si no existe
            if (!Schema::hasColumn('bookings', 'created_at')) {
                $table->timestamp('created_at')->nullable()->after('driver_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Eliminar el campo created_at si existe
            if (Schema::hasColumn('bookings', 'created_at')) {
                $table->dropColumn('created_at');
            }
        });
    }
};
