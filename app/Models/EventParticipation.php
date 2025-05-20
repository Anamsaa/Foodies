<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventParticipation extends Model
{
    protected $fillable = [
        'person_id',
        'event_id',
        'registration_date',
        'status',
    ];

    public function person(): BelongsTo {
        return $this->belongsTo(Person::class);
    }
    public function culinaryEvent(): BelongsTo {
        return $this->belongsTo(CulinaryEvent::class, 'event_id', 'post_id');
    }
}
