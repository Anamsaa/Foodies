<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Notification extends Model
{
    protected $fillable = [
        'from_profile_id', 
        'to_profile_id', 
        'type'
    ];

    public function fromProfile(): BelongsTo {
        return $this->belongsTo(Profile::class, 'from_profile_id');
    }

    public function toProfile(): BelongsTo {
        return $this->belongsTo(Profile::class, 'to_profile_id');
    }
    
}
