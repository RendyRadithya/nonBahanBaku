<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Find vendor users (users with store_name). If none, pick first 3 users.
        $vendors = User::whereNotNull('store_name')->get();
        if ($vendors->isEmpty()) {
            $vendors = User::take(3)->get();
        }

        foreach ($vendors as $vendor) {
            // create 3 example products per vendor
            for ($i = 1; $i <= 3; $i++) {
                Product::create([
                    'vendor_id' => $vendor->id,
                    'name' => ($vendor->store_name ? $vendor->store_name : $vendor->name) . ' Product ' . $i,
                    'description' => 'Deskripsi produk contoh ' . $i,
                    'price' => rand(25000, 250000),
                    'stock' => rand(10, 100),
                ]);
            }
        }
    }
}
