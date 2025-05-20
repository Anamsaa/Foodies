<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CulinaryEvent extends Model
{
    protected $primaryKey = 'post_id'; 
    public $incrementing = false;

    protected $fillable = [
        'post_id',
        'title',
        'event_date',
        'event_time',
        'status',
        'max_participants',
        'short_description',
        'restaurant_id',
    ];

    public function post(): BelongsTo {
        return $this->belongsTo(Post::class, 'post_id');
    }
    public function restaurant(): BelongsTo {
        return $this->belongsTo(Restaurant::class);
    }
    public function participations(): HasMany {
        return $this->hasMany(EventParticipation::class, 'event_id', 'post_id');
    }
}
