<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Photo extends Model
{
    protected $fillable = ['url']; 
    public function usedAsProfilePhoto() : HasMany {
        return $this->hasMany(Profile::class, 'profile_photo_id');
    }
    public function usedAsCoverPhoto() : HasMany {
        return $this->hasMany(Profile::class, 'cover_photo_id');
    }
    public function usedInPost() : HasMany {
        return $this->hasMany(Post::class, 'photo_id');
    }
    public function getUrlAttribute($value) {
        return asset(Storage::url($value));
    }
}
