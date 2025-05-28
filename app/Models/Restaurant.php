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
        'horarios',
        'tipo',
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
        return $this->hasMany(CulinaryEvent::class, 'post_id', 'id');
    }
    public function getDiasAperturaTextoAttribute(): string {
        return is_array($this->dias_apertura) ? implode(' - ' , $this->dias_apertura) : (string) $this->dias_apertura;
    }

}
