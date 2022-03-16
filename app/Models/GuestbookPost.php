<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestbookPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'message',
        'cheffe',
        'category',
        'spam_detection',
    ];
}
