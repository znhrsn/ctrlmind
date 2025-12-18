<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsultantNotificationController extends Controller
{
    public function index()
    {
        $all = auth()->user()->notifications()->paginate(10);
        auth()->user()->unreadNotifications->markAsRead();

        // Changed from 'consultant.notifications' to match your path
        return view('consultants.notifications.index', compact('all')); 
    }
}
