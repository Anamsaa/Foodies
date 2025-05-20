<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Restaurant extends Model
{
    protected $fillable = [
        'profile_id',
        'name',
        'description',
        'address',
        'website',
        'phone'
    ];

    public function profile() : BelongsTo {
        return $this->belongsTo(Profile::class);
    }
    public function reviews() {
        return $this->hasMany(Review::class);
    }
    public function culinaryEvent() {
        return $this->hasMany(CulinaryEvent::class, 'post_id');
    }

}
