<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderEvent;

class OrderController extends Controller
{
    // Return a JSON list of vendors (users with role 'vendor')
    public function vendors()
    {
        $vendors = User::where('role', 'vendor')->get(['id', 'name', 'store_name']);
        return response()->json($vendors);
    }

    // Demo products per vendor (replace with real product lookup if available)
    public function products($vendorId)
    {
        // Query real products by vendor if the products table exists; fallback to empty array
        if (class_exists('\App\\Models\\Product')) {
            $prods = \App\Models\Product::where('vendor_id', $vendorId)->get(['id', 'name', 'price']);
            return response()->json($prods);
        }

        return response()->json([]);
    }

    // Store a new order
    public function store(Request $request)
    {
        $data = $request->validate([
            // vendor_id may be a static fallback id (not present in users table),
            // so we only validate as integer here and resolve vendor_name server-side.
            'vendor_id' => 'nullable|integer',
            'vendor_name' => 'required|string|max:255',
            'product_id' => 'nullable|integer',
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'estimated_delivery' => 'nullable|date',
        ]);

        // determine price from product_id if provided
        $price = 0;
        if (!empty($data['product_id']) && class_exists('\App\\Models\\Product')) {
            $prod = \App\Models\Product::find($data['product_id']);
            if ($prod) $price = (float) $prod->price;
        }

        $orderNumber = 'ORD' . date('YmdHis') . rand(100, 999);

        // resolve vendor_id -> vendor_name if vendor_id provided
        // defensive: if vendor_id is provided but doesn't exist, clear it to avoid FK errors.
        $vendorName = $data['vendor_name'] ?? null;
        $vendorId = $data['vendor_id'] ?? null;
        if (!empty($vendorId)) {
            $v = User::find($vendorId);
            if ($v) {
                $vendorName = $v->store_name ?? $v->name;
            } else {
                // provided vendor_id invalid — drop it so DB FK won't fail
                $vendorId = null;
            }
        }

        // If we still don't have a vendor_id, try to map by vendor_name (exact match)
        if (empty($vendorId) && !empty($vendorName)) {
            $v2 = User::where('store_name', $vendorName)->orWhere('name', $vendorName)->first();
            if ($v2) {
                $vendorId = $v2->id;
                $vendorName = $v2->store_name ?? $v2->name;
            }
        }

        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => Auth::id(),
            'vendor_id' => $vendorId,
            'vendor_name' => $vendorName,
            'product_name' => $data['product_name'],
            'quantity' => $data['quantity'],
            'total_price' => $price * $data['quantity'],
            'status' => 'pending',
            'estimated_delivery' => $data['estimated_delivery'] ?? null,
        ]);

        return response()->json(['success' => true, 'order' => $order]);
    }

    // Return tracking info for an order
    public function tracking($id)
    {
        $order = Order::find($id);
        if (!$order) return response()->json(['message' => 'Order not found'], 404);

        // try to find vendor user record by vendor_id if available, else fallback to name matching
        $vendor = null;
        if ($order->vendor_id) {
            $vendor = User::find($order->vendor_id);
        }
        if (!$vendor) {
            $vendor = User::where('store_name', $order->vendor_name)->orWhere('name', $order->vendor_name)->first();
        }

        // prefer real events from order_events table if available
        $events = OrderEvent::where('order_id', $order->id)->orderBy('created_at')->get();
        $timeline = [];
        if ($events->count() > 0) {
            foreach ($events as $ev) {
                $timeline[] = [
                    'key' => $ev->event_type,
                    'title' => ucfirst(str_replace('_',' ', $ev->event_type)),
                    'date' => $ev->created_at->format('d M Y, H:i'),
                    'description' => $ev->description,
                    'icon' => null,
                ];
            }
        } else {
            // fallback heuristics when no events exist
            $created = $order->created_at;
            $timeline[] = [
                'key' => 'created',
                'title' => 'Pesanan Dibuat',
                'date' => $created->format('d M Y, H:i'),
                'description' => 'Pesanan telah berhasil dibuat dan menunggu konfirmasi vendor',
                'icon' => '✓'
            ];

            if (in_array($order->status, ['confirmed','in_progress','completed'])) {
                $timeline[] = [
                    'key' => 'confirmed',
                    'title' => 'Dikonfirmasi Vendor',
                    'date' => $created->copy()->addDay(1)->format('d M Y, H:i'),
                    'description' => 'Vendor telah mengkonfirmasi pesanan Anda',
                    'icon' => '⟳'
                ];
            }

            if (in_array($order->status, ['in_progress','completed'])) {
                $timeline[] = [
                    'key' => 'processing',
                    'title' => 'Sedang Diproses',
                    'date' => $created->copy()->addDays(2)->format('d M Y, H:i'),
                    'description' => 'Pesanan sedang dikemas oleh vendor',
                    'icon' => '📦'
                ];

                $timeline[] = [
                    'key' => 'shipped',
                    'title' => 'Dalam Pengiriman',
                    'date' => $created->copy()->addDays(3)->format('d M Y, H:i'),
                    'description' => 'Pesanan sedang dikirim ke lokasi',
                    'icon' => '🚚'
                ];
            }

            if ($order->status === 'completed') {
                $timeline[] = [
                    'key' => 'completed',
                    'title' => 'Pesanan Selesai',
                    'date' => $order->updated_at->format('d M Y, H:i'),
                    'description' => 'Pesanan telah selesai',
                    'icon' => '✔'
                ];
            }
        }

        // tracking number (nullable column)
        $tracking_number = $order->tracking_number ?? null;

        return response()->json([
            'order' => $order,
            'status_label' => $order->getStatusLabel(),
            'timeline' => $timeline,
            'vendor' => $vendor ? ['id' => $vendor->id, 'name' => $vendor->name, 'store_name' => $vendor->store_name, 'phone' => $vendor->phone ?? null, 'email' => $vendor->email ?? null] : null,
            'tracking_number' => $tracking_number,
        ]);
    }

    // Confirm receipt (mark order completed)
    public function confirm(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) return response()->json(['message' => 'Order not found'], 404);

        $user = Auth::user();
        // only the buyer (order->user_id) or admin can confirm completion
        if ($user->id !== $order->user_id && $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $order->status = 'completed';
        $order->save();

        OrderEvent::create([
            'order_id' => $order->id,
            'event_type' => 'completed',
            'description' => 'Pembeli menandai pesanan selesai',
        ]);

        return response()->json(['success' => true, 'order' => $order]);
    }

    // Vendor accepts order (mark as confirmed)
    public function accept(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) return response()->json(['message' => 'Order not found'], 404);

        $user = Auth::user();
        // Only vendors or admins can accept; and vendor must match the order's vendor
        if ($user->role !== 'vendor' && $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // resolve vendor user
        $vendor = $order->vendor; // relation may be null
        if (!$vendor) {
            // fallback to name matching
            $vendor = User::where('store_name', $order->vendor_name)->orWhere('name', $order->vendor_name)->first();
            if (!$vendor) {
                return response()->json(['message' => 'Vendor not found for this order'], 400);
            }
        }

        if ($user->role !== 'admin' && $vendor->id !== $user->id) {
            return response()->json(['message' => 'Unauthorized - not the vendor for this order'], 403);
        }

        $order->status = 'confirmed';
        $order->save();

        OrderEvent::create([
            'order_id' => $order->id,
            'event_type' => 'confirmed',
            'description' => 'Vendor mengkonfirmasi pesanan',
        ]);

        return response()->json(['success' => true, 'order' => $order]);
    }

    // Vendor rejects order
    public function reject(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) return response()->json(['message' => 'Order not found'], 404);

        $user = Auth::user();
        if ($user->role !== 'vendor' && $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // resolve vendor user via relation or fallback
        $vendor = $order->vendor;
        if (!$vendor) {
            $vendor = User::where('store_name', $order->vendor_name)->orWhere('name', $order->vendor_name)->first();
            if (!$vendor) return response()->json(['message' => 'Vendor not found for this order'], 400);
        }

        if ($user->role !== 'admin' && $vendor->id !== $user->id) {
            return response()->json(['message' => 'Unauthorized - not the vendor for this order'], 403);
        }

        $data = $request->validate(['reason' => 'nullable|string']);
        $order->status = 'rejected';
        $order->save();

        OrderEvent::create([
            'order_id' => $order->id,
            'event_type' => 'rejected',
            'description' => $data['reason'] ?? 'Vendor menolak pesanan',
        ]);

        return response()->json(['success' => true, 'order' => $order]);
    }

    // Vendor or system can update tracking number and optionally push an event
    public function updateTracking(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) return response()->json(['message' => 'Order not found'], 404);

        $user = Auth::user();
        // only vendor of order or admin may update tracking
        if ($user->role !== 'vendor' && $user->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $vendor = $order->vendor;
        if (!$vendor) {
            $vendor = User::where('store_name', $order->vendor_name)->orWhere('name', $order->vendor_name)->first();
            if (!$vendor) return response()->json(['message' => 'Vendor not found for this order'], 400);
        }

        if ($user->role !== 'admin' && $vendor->id !== $user->id) {
            return response()->json(['message' => 'Unauthorized - not the vendor for this order'], 403);
        }

        $data = $request->validate([
            'tracking_number' => 'nullable|string|max:255',
            'event_description' => 'nullable|string',
            'event_type' => 'nullable|string',
        ]);

        if (!empty($data['tracking_number'])) {
            $order->tracking_number = $data['tracking_number'];
            $order->status = 'in_progress';
            $order->save();

            // add event
            OrderEvent::create([
                'order_id' => $order->id,
                'event_type' => $data['event_type'] ?? 'shipped',
                'description' => $data['event_description'] ?? 'Nomor resi ditambahkan',
                'meta' => json_encode(['tracking_number' => $data['tracking_number']]),
            ]);
        }

        return response()->json(['success' => true, 'order' => $order]);
    }
}
