<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsultantNotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return view('consultants.notifications.index', [
            'unread' => $user->unreadNotifications,
            'all' => $user->notifications()->paginate(15),
        ]);
    }
}
