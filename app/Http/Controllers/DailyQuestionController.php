<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MHResponses;

class DailyQuestionController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        foreach ($request->input('daily', []) as $question => $answer) {
            MHResponses::create([
                'user_id' => $user->id,
                'question_id' => null, // optional if you want to link to mh_questions
                'response_text' => $answer,
            ]);
        }

        return redirect()->route('dashboard')->with('status', 'Daily questions submitted!');
    }
}