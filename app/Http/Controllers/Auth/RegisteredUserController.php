<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\MHQuestions;
use App\Models\MHResponses;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // ✅ Assign consultant fairly
        $consultant = User::where('role', 'consultant')
            ->withCount('clients')
            ->orderBy('clients_count', 'asc')
            ->inRandomOrder()
            ->first();

        if ($consultant) {
            $user->consultant_id = $consultant->id;
            $user->save();

            // Notify consultant
            $consultant->notify(new \App\Notifications\NewClientAssigned($user));

            // Flash welcome modal
            session()->flash('welcome_modal', [
                'user' => $user->name,
                'consultant' => $consultant->name,
            ]);
        }

        // ✅ Save survey responses
        if ($request->has('survey')) {
            foreach ($request->input('survey') as $questionId => $value) {
                $question = MHQuestions::find($questionId);
                MHResponses::create([
                    'user_id' => $user->id,
                    'question_id' => $questionId,
                    'response_text' => in_array($question->type, ['text','single','multi']) ? $value : null,
                    'response_number' => $question->type === 'scale' ? intval($value) : null,
                ]);
            }
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect('/dashboard');
    }
}