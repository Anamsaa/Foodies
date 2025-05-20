<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function region(): BelongsTo {
        return $this->belongsTo(Region::class);
    }
    public function province(): BelongsTo {
        return $this->belongsTo(Province::class);
    }
    public function city(): BelongsTo {
        return $this->belongsTo(City::class);
    }
    public function profilePhoto(): BelongsTo {
        return $this->belongsTo(Photo::class, 'profile_photo_id');
    }
    public function coverPhoto(): BelongsTo {
        return $this->belongsTo(Photo::class, 'cover_photo_id');
    }
    public function restaurant(): HasOne {
        return $this->hasOne(Restaurant::class);
    }
    public function person(): HasOne {
        return $this->hasOne(Person::class);
    }
    public function posts() {
        return $this->hasMany(Post::class);
    }
    public function likes(): HasMany {
        return $this->hasMany(Like::class);
    }
    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }   
    public function followers(): HasMany {
        return $this->hasMany(Follow::class, 'followed_id');
    }
    public function followings(): HasMany {
        return $this->hasMany(Follow::class, 'follower_id');
    }
    public function sentNotifications(): HasMany {
        return $this->hasMany(Notification::class, 'from_profile_id');
    }
    public function receivedNotifications(): HasMany {
        return $this->hasMany(Notification::class, 'to_profile_id');
    }

}
