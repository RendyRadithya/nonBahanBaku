<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Log;

Artisan::command('map:vendors', function () {
    $this->comment('Mapping orders with missing vendor_id to users by normalized name...');

    $normalize = function ($s) {
        if (empty($s)) return null;
        $s = mb_strtolower($s);
        $s = preg_replace('/[^a-z0-9]/u', '', $s);
        return $s;
    };

    $users = \App\Models\User::select('id','name','store_name')->get();
    $map = [];
    foreach ($users as $u) {
        $n1 = $normalize($u->store_name ?? '');
        $n2 = $normalize($u->name ?? '');
        if ($n1) $map[$n1] = $u->id;
        if ($n2) $map[$n2] = $u->id;
    }

    $orders = \App\Models\Order::whereNull('vendor_id')->get();
    $updated = 0;
    $unmatched = [];

    foreach ($orders as $order) {
        $vn = $order->vendor_name ?? '';
        $nn = $normalize($vn);
        if ($nn && isset($map[$nn])) {
            $order->vendor_id = $map[$nn];
            $order->save();
            $this->info("Mapped order {$order->id} ('{$vn}') -> user_id {$map[$nn]}");
            Log::info('map:vendors mapped order', ['order_id' => $order->id, 'vendor_name' => $vn, 'vendor_id' => $map[$nn]]);
            $updated++;
        } else {
            $unmatched[] = ['order_id' => $order->id, 'vendor_name' => $vn];
        }
    }

    $this->comment("Done. Updated: {$updated}. Unmatched: " . count($unmatched));
    if (count($unmatched) > 0) {
        $this->line('Unmatched orders (order_id => vendor_name):');
        foreach ($unmatched as $u) {
            $this->line(" - {$u['order_id']} => {$u['vendor_name']}");
        }
    }

})->describe('Try to map existing orders vendor_name -> users and populate vendor_id');

Artisan::command('map:vendors:create', function () {
    $this->comment('Create vendor users for unmatched vendor_name values and map orders to them');

    $normalize = function ($s) {
        if (empty($s)) return null;
        $s = mb_strtolower($s);
        $s = preg_replace('/[^a-z0-9]/u', '', $s);
        return $s;
    };

    $orders = \App\Models\Order::whereNull('vendor_id')->get();
    $groups = [];
    foreach ($orders as $o) {
        $vn = trim($o->vendor_name ?? '');
        if ($vn === '') continue;
        $groups[$vn][] = $o->id;
    }

    if (count($groups) === 0) {
        $this->comment('No unmatched vendor_name orders found.');
        return;
    }

    foreach ($groups as $vendorName => $orderIds) {
        $this->info("Creating vendor user for: {$vendorName}");
        $store = str_replace(['_', '-'], ' ', $vendorName);
        $store = ucwords(strtolower($store));
        $email = preg_replace('/[^a-z0-9]/', '', strtolower(str_replace(' ', '.', $store))) . rand(100,999) . '@mcorder.local';

        $user = \App\Models\User::create([
            'name' => $store,
            'email' => $email,
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'vendor',
            'phone' => null,
            'store_name' => $store,
        ]);

        foreach ($orderIds as $id) {
            $o = \App\Models\Order::find($id);
            if ($o) {
                $o->vendor_id = $user->id;
                $o->vendor_name = $user->store_name ?? $user->name;
                $o->save();
            }
        }

        $this->line("Created vendor: {$user->id} ({$user->store_name}) - email: {$user->email} password: password123");
        \Illuminate\Support\Facades\Log::info('map:vendors:create created vendor', ['vendor_name' => $vendorName, 'user_id' => $user->id]);
    }

    $this->comment('Done creating vendors and mapping orders.');

})->describe('Create vendor users for unmatched vendor_name values and map their orders');
