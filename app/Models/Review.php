<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'points',
        'details',
        'review'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'from_user_id');
    }
}
