<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $primaryKey = 'post_id';
    public $incrementing = false;

    protected $fillable = [
        'post_id',
        'title',
        'score',
        'restaurant_id',
        'short_description',
    ];
    public function post(): BelongsTo {
        return $this->belongsTo(Post::class, 'post_id');
    }
    public function restaurant(): BelongsTo {
        return $this->belongsTo(Restaurant::class);
    }
}
