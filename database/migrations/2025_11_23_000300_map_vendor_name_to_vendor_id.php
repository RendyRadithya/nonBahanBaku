<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update orders that don't have vendor_id but vendor_name matches a user
        // Use a JOIN update so this runs efficiently on MySQL
        DB::statement(
            "UPDATE `orders` o JOIN `users` u ON (LOWER(o.vendor_name) = LOWER(u.store_name) OR LOWER(o.vendor_name) = LOWER(u.name)) SET o.vendor_id = u.id WHERE o.vendor_id IS NULL"
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert vendor_id for orders where vendor_name matched a user (set back to null)
        DB::statement(
            "UPDATE `orders` o JOIN `users` u ON (LOWER(o.vendor_name) = LOWER(u.store_name) OR LOWER(o.vendor_name) = LOWER(u.name)) SET o.vendor_id = NULL WHERE o.vendor_id = u.id"
        );
    }
};
