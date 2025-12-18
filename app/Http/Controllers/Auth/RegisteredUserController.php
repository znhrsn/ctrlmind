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
use App\Notifications\NewClientAssigned; 
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // 1. Validate Input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Create the User
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', 
        ]);

        // 3. Search for a Consultant to assign
        $consultant = User::where('role', 'consultant')
            ->withCount('clients')
            ->orderBy('clients_count', 'asc')
            ->inRandomOrder()
            ->first();

        // 4. If a consultant is found, assign and notify
        if ($consultant) {
            Log::info('Consultant found: ' . $consultant->email);
            
            $user->consultant_id = $consultant->id;
            $user->save();

            try {
                $consultant->notify(new NewClientAssigned($user));
                Log::info('Notification sent successfully to ' . $consultant->email);
            } catch (\Exception $e) {
                Log::error('Notification failed to send: ' . $e->getMessage());
            }

            // Flash welcome modal data
            session()->flash('welcome_modal', [
                'user' => $user->name,
                'consultant' => $consultant->name,
            ]);
        } else {
            Log::warning('No user with the role "consultant" was found in the database. No assignment made.');
        }

        // 5. Save survey responses
        if ($request->has('survey')) {
            foreach ($request->input('survey') as $questionId => $value) {
                $question = MHQuestions::find($questionId);
                if ($question) {
                    MHResponses::create([
                        'user_id' => $user->id,
                        'question_id' => $questionId,
                        'response_text' => in_array($question->type, ['text','single','multi']) ? $value : null,
                        'response_number' => $question->type === 'scale' ? intval($value) : null,
                    ]);
                }
            }
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect('/dashboard');
    }
}