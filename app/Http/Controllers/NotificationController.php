<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(Request $request, $id)
    {
        $notification = auth()->guard('admin')->user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return back();
    }

    public function markAllAsRead(Request $request)
    {
        auth()->guard('admin')->user()->unreadNotifications->markAsRead();

        return back();
    }
}
