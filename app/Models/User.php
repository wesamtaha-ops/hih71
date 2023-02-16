<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone','gender','image','currency_id','country_id','city','birthday', 'is_verified', 'is_blocked', 'is_approved','slug'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function teacher() {
        return $this->hasOne(Teacher::class, 'user_id');
    }

    public function country() {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }


    protected $appends = ['review_count', 'review_avg'];

    public function getReviewCountAttribute()
    {
        if($this->type == 'teacher') {
            return Review::where('teacher_id', $this->id)->count();
        }

        return 0;
    }

    public function getReviewAvgAttribute()
    {
        if($this->type == 'teacher') {
            return Review::where('teacher_id', $this->id)->avg('points');
        }

        return 0;
    }

}
