<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\GuestbookPostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestbookPost extends Model
{
    /** @use HasFactory<GuestbookPostFactory> */
    use HasFactory;

    public float $score = 0;

    protected $fillable = [
        'name',
        'message',
        'cheffe',
        'category',
        'spam_detection',
    ];
}
