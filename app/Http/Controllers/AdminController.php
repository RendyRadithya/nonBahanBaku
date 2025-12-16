<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $pendingUsers = \App\Models\User::where('is_approved', false)->get();
        return view('admin.approvals', compact('pendingUsers'));
    }

    public function approve($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->is_approved = true;
        $user->save();

        // Send email notification to user
        $user->notify(new \App\Notifications\UserApprovedNotification());

        return redirect()->back()->with('success', 'User berhasil disetujui! Notifikasi email telah dikirim.');
    }

    public function reject($id)
    {
        $user = \App\Models\User::findOrFail($id);
        
        // Send email notification before deleting user
        $user->notify(new \App\Notifications\UserRejectedNotification());
        
        // Delete user
        $user->delete();

        return redirect()->back()->with('rejected', 'User berhasil ditolak dan dihapus dari sistem.');
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function clearAll()
    {
        auth()->user()->notifications()->delete();
        return redirect()->back()->with('success', 'All notifications cleared.');
    }
}
