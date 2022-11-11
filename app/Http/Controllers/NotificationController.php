<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class NotificationController extends Controller
{
    //


    public function setread(Request $request, $notification_id)
    {
        $user = Auth::user();
        $notification = $user->unreadNotifications()->find($notification_id);
        // return $notification;
        if ($notification_id) {
            if ($user) {
                if ($notification) {
                    $notification->markAsRead();
                }
            }
        }
        return Redirect::route('dashboard.dashboard');
    }
}