<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        // Redirect based on role
        if ($user->role === 'manager_stock') {
            // Get statistics for manager stock
            $orders = \App\Models\Order::where('user_id', $user->id)->latest()->get();
            
            return view('dashboards.manager-stock', [
                'orders' => $orders,
                'totalOrders' => $orders->count(),
                'pendingOrders' => $orders->where('status', 'pending')->count(),
                'inProgressOrders' => $orders->whereIn('status', ['confirmed', 'in_progress'])->count(),
                'completedOrders' => $orders->where('status', 'completed')->count(),
            ]);
        } elseif ($user->role === 'vendor') {
            return view('dashboards.vendor');
        } elseif ($user->role === 'admin') {
            return view('dashboards.admin');
        }
        
        // Fallback
        return view('dashboard');
    })->name('dashboard');
});
