<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'order_id',
        'approved',
        'verification_code',
        'currency_id'
    ];

    static function get_user_balance() {
        $positive = Transfer::where('user_id', \Auth::id())->where('approved', 1)->where('type', 'charge')->sum('amount');
        $negative = Transfer::where('user_id', \Auth::id())->where('approved', 1)->where('type', 'order')->sum('amount');

        return $positive - $negative;
    }
}
