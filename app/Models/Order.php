<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'type',
        'topic_id',
        'data',
        'time',
        'fees',
        'currency_id',
        'notes',
        'meeting_id'
    ];

    public function teacher() {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function topic() {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

}
