<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    use HasFactory;

    protected $table = 'checkins';

    protected $fillable = [
        'user_id', 'mood', 'date', 'period', 'energy', 'focus', 'satisfaction', 'self_kindness', 'relaxation', 'note'
    ];
}

