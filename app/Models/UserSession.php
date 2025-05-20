<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSession extends Model
{
    protected $fillable = [
        'account_id',
        'token',
        'session_start',
        'session_end',
    ];

    public function account(): BelongsTo {
        return $this->belongsTo(Account::class);
    }
}
