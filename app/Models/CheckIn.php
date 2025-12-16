<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    use HasFactory;

    protected $table = 'check_ins';

    protected $fillable = [
        'user_id',
        'date',
        'period',
        'mood',
        'energy',
        'focus',
        'satisfaction',
        'self_kindness',
        'relaxation',
        'note',
    ];

    protected $casts = [
        'date' => 'date',
        'mood' => 'integer',
        'energy' => 'integer',
        'focus' => 'integer',
        'satisfaction' => 'integer',
        'self_kindness' => 'integer',
        'relaxation' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
