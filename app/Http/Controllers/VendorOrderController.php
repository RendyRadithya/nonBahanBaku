<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Notifications\OrderStatusUpdatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorOrderController extends Controller
{
    public function index()
    {
        $vendorId = Auth::id();
        $orders = Order::where('vendor_id', $vendorId)->latest()->get();
        return view('dashboards.vendor', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:confirmed,in_progress,shipped,rejected',
        ]);

        $order = Order::where('id', $id)->where('vendor_id', Auth::id())->firstOrFail();
        $previousStatus = $order->status;
        $order->status = $request->status;
        
        if ($request->status === 'shipped') {
             // Logic for shipped if needed, e.g. tracking number
        }

        $order->save();

        // Notify the Manager (User who created the order)
        $manager = \App\Models\User::find($order->user_id);
        if ($manager) {
            $manager->notify(new OrderStatusUpdatedNotification($order, $previousStatus));
        }

        return response()->json(['success' => true, 'message' => 'Status pesanan berhasil diperbarui.', 'status_label' => $order->getStatusLabel(), 'status_color' => $order->getStatusBadgeColor()]);
    }
}
