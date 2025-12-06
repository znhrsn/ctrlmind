<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // ✅ correct import
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory; // ✅ now works

    protected $fillable = [
        'title',
        'type',
        'topic',
        'description',
        'url',
        'is_featured',
    ];
}
