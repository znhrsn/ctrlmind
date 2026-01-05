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
        // 1. Validate Input (Updated gender options and added consultant_pref)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'gender' => ['required', 'string', 'in:male,female,others,prefer_not_to_say'], 
            'consultant_pref' => ['required', 'string', 'in:male,female'], // Required for matching logic
        ]);

        // 2. Create the User (Include gender and preference)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', 
            'gender' => $request->gender, 
            'consultant_pref' => $request->consultant_pref, // Storing their choice
        ]);

        // 3. Search for a Consultant based on the User's PREFERENCE
        // We match $request->consultant_pref against the consultant's $gender
        $consultant = User::where('role', 'consultant')
            ->where('gender', $request->consultant_pref) 
            ->withCount('clients')
            ->orderBy('clients_count', 'asc') // Fair distribution
            ->first();

        // FALLBACK: If preferred gender is not available, find any least-loaded consultant
        if (!$consultant) {
            Log::warning("Preferred gender ({$request->consultant_pref}) consultant not available. Falling back to least busy.");
            $consultant = User::where('role', 'consultant')
                ->withCount('clients')
                ->orderBy('clients_count', 'asc')
                ->first();
        }

        // 4. If a consultant is found, assign and notify
        if ($consultant) {
            Log::info("Consultant found for User preference ({$request->consultant_pref}): " . $consultant->email);
            
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
                'message' => "Based on your preference, we've matched you with {$consultant->name}."
            ]);
        } else {
            Log::error('Critical: No consultants found in the database at all.');
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