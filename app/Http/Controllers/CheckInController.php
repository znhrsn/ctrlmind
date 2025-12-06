<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckinController extends Controller
{
    public function start()
    {
        return view('checkin.start');
    }
}
