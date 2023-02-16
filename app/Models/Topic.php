<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $appends = ['parent', 'full_image'];

    public function getParentAttribute()
    {
        if($this->parent_id) {
            return Topic::find($this->parent_id)->name_en;
        }
    }

    public function getFullImageAttribute()
    {
        if($this->image) {
            return asset('images/' . $this->image);
        }
    }
}
