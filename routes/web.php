<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

// Auth routes
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password reset routes
Route::get('password/reset', [ForgotPasswordController::class,'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class,'sendResetLinkEmail'])->name('password.email');

Route::get('password/reset/{token}', [ResetPasswordController::class,'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class,'reset'])->name('password.update');

// Change password routes
Route::get('password/change', function (Request $request) {
    // menampilkan login view tapi dengan form change password
    return view('login', ['show_change_password' => true, 'email' => $request->query('email')]);
})->name('password.change');

Route::post('password/change', [ChangePasswordController::class, 'update'])->name('password.change.update');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user(); // pakai helper, tidak perlu import
        
        // Redirect based on role
        if ($user->role === 'manager_stock') {
            // Get statistics for manager stock
            $orders = \App\Models\Order::latest()->get();

            // totalOrders should exclude already completed orders
            $totalOrders = $orders->where('status', '!=', 'completed')->count();
            $pendingOrders = $orders->where('status', 'pending')->count();
            $inProgressOrders = $orders->whereIn('status', ['confirmed', 'in_progress'])->count();
            $completedOrders = $orders->where('status', 'completed')->count();

            return view('dashboards.manager-stock', compact('orders', 'totalOrders', 'pendingOrders', 'inProgressOrders', 'completedOrders'));
        } elseif ($user->role === 'vendor') {
            // Vendor: show only orders belonging to this vendor. Prefer vendor_id, fallback to store_name match.
            $vendorId = $user->id;
            $storeName = $user->store_name ?? $user->name;

            $ordersQuery = \App\Models\Order::query();
            // Match by vendor_id OR exact vendor_name OR normalized vendor_name (lower, no spaces/underscores)
            $ordersQuery->where(function($q) use ($vendorId, $storeName) {
                $q->where('vendor_id', $vendorId);
                if ($storeName) {
                    $q->orWhere('vendor_name', $storeName);

                    // add normalized match to handle formatting differences like underscores/spaces/casing
                    $norm = str_replace([' ', '_'], '', mb_strtolower($storeName));
                    // use whereRaw to compare normalized vendor_name stored in DB
                    $q->orWhereRaw("REPLACE(REPLACE(LOWER(vendor_name),' ',''),'_','') = ?", [$norm]);
                }
            });

            $orders = $ordersQuery->latest()->get();

            $totalOrders = $orders->count();
            $newOrders = $orders->where('status','pending')->count();
            $inProgress = $orders->whereIn('status',['confirmed','in_progress'])->count();
            $completed = $orders->where('status','completed')->count();
            $totalSales = $orders->sum('total_price');

            return view('dashboards.vendor', compact('orders','totalOrders','newOrders','inProgress','completed','totalSales'));
        } elseif ($user->role === 'admin') {
            return view('dashboards.admin');
        }
        
        // Fallback
        return view('dashboard');
    })->name('dashboard');

    // AJAX endpoints for orders
    Route::get('/vendors', [OrderController::class, 'vendors']);
    Route::get('/vendors/{id}/products', [OrderController::class, 'products']);
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{id}/tracking', [OrderController::class, 'tracking']);
    Route::post('/orders/{id}/confirm', [OrderController::class, 'confirm']);
    Route::post('/orders/{id}/tracking', [OrderController::class, 'updateTracking']);
    // Vendor actions
    Route::post('/orders/{id}/accept', [OrderController::class, 'accept']);
    Route::post('/orders/{id}/reject', [OrderController::class, 'reject']);
});
