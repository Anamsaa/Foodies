<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follow extends Model
{
    protected $fillable = [
        'follower_id', 
        'followed_id', 
        'status'
    ];

    public function follower(): BelongsTo {
        return $this->belongsTo(Profile::class, 'follower_id');
    }
    public function followed(): BelongsTo {
        return $this->belongsTo(Profile::class, 'followed_id');
    }
}
