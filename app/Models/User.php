<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Http\Request; // ✅ needed for authenticated()
use App\Models\Message;      // ✅ needed for message relationships

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',          // consultant or client
        'consultant_id', // link to assigned consultant
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Quotes saved by the user.
     */
    public function savedQuotes()
    {
        return $this->belongsToMany(\App\Models\Quote::class, 'user_quotes', 'user_id', 'quote_id')
                    ->withTimestamps()
                    ->withPivot('is_pinned');
    }

    /**
     * The consultant assigned to this user (self-reference).
     */
    public function consultant()
    {
        return $this->belongsTo(User::class, 'consultant_id');
    }

    /**
     * All clients assigned to this consultant (self-reference).
     */
    public function clients()
    {
        return $this->hasMany(User::class, 'consultant_id');
    }

    /**
     * Redirect after login based on role.
     */
    public function authenticated(Request $request, $user)
    {
        if ($user->role === 'consultant') {
            return redirect()->route('consultant.dashboard');
        }
        return redirect()->route('dashboard'); // regular user dashboard
    }

    /**
     * Messages sent by this user.
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    /**
     * Messages received by this consultant.
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'consultant_id');
    }
}