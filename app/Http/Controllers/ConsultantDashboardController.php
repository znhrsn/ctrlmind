<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsultantDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // ✅ Count unread notifications for badge
        $unreadCount = $user->unreadNotifications()->count();

        // ✅ Fetch clients assigned to consultant
        $clients = $user->clients()->get();

        return view('consultants.dashboard', compact('unreadCount', 'clients'));
    }
}
