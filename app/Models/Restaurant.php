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
        'phone',
        'dias_apertura',
    ];

    protected $casts = [
        'dias_apertura' => 'array'
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
