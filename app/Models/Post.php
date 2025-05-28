<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $fillable = [
        'profile_id',
        'status',
        'visibility',
        'photo_id',
        'content',
        'post_type',
    ];

    public function profile(): BelongsTo {
        return $this->belongsTo(Profile::class);
    }
    public function photo(): BelongsTo {
        return $this->belongsTo(Photo::class);
    }
    public function review(): HasOne {
        return $this->hasOne(Review::class, 'post_id');
    }
    public function culinaryEvent(): HasOne {
        return $this->hasOne(CulinaryEvent::class, 'post_id', 'id');
    }
    public function likes(): HasMany {
        return $this->hasMany(Like::class);
    }
    public function comments(): HasMany {
        return $this->hasMany(Comment::class);
    }

}
