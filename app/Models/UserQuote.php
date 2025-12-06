<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserQuote extends Model
{
    protected $fillable = ['user_id', 'quote_id', 'pinned'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
