<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = AppNotification::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(AppNotification $notification)
    {
        if ($notification->user_id === auth()->id()) {
            $notification->update(['lu' => true]);
        }

        if ($notification->lien) {
            return redirect($notification->lien);
        }

        return redirect()->back();
    }

    public function markAllAsRead()
    {
        AppNotification::where('user_id', auth()->id())
            ->where('lu', false)
            ->update(['lu' => true]);

        return redirect()->back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }
}
