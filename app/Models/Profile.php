<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Profile extends Model
{
    protected $fillable = [
        'account_id', 
        'region_id', 
        'province_id', 
        'city_id', 
        'profile_photo_id', 
        'cover_photo_id', 
        'user_type'
    ];
    
    public function account(): BelongsTo {
        return $this->belongsTo(Account::class);
    }

    public function restaurant(): HasOne {
        return $this->hasOne(Restaurant::class);
    }
    public function person(): HasOne {
        return $this->hasOne(Person::class);
    }

}
