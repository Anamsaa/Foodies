<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    protected $fillable = [
        'profile_id', 
        'first_name', 
        'last_name',
        'description',
        'birth_date'
    ]; 

    public function profile() : BelongsTo {
        return $this->belongsTo(Profile::class);
    }
    public function eventParticipations(): HasMany {
        return $this->hasMany(EventParticipation::class);
    }
}
