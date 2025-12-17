<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsultantDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Count unread notifications for badge
        $unreadCount = $user->unreadNotifications()->count();

        // Allow searching clients by name (case-insensitive)
        $q = trim($request->input('q', ''));
        $clientsQuery = $user->clients();

        if ($q !== '') {
            $qLower = mb_strtolower($q);
            $clientsQuery->whereRaw('LOWER(name) LIKE ?', ["%{$qLower}%"]);
        }

        $clients = $clientsQuery->orderBy('name')->paginate(20)->withQueryString();

        return view('consultants.dashboard', compact('unreadCount', 'clients', 'q'));
    }
}
