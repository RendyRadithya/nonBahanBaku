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
        Schema::table('orders', function (Blueprint $table) {
            // We use DB statement because changing enum with Schema builder is not fully supported in all drivers or requires doctrine/dbal
            // and can be tricky.
            DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'confirmed', 'in_progress', 'shipped', 'completed', 'rejected') DEFAULT 'pending'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
             DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('pending', 'confirmed', 'in_progress', 'completed', 'rejected') DEFAULT 'pending'");
        });
    }
};
