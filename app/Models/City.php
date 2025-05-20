<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory; 

    protected $table = 'cities';

    protected $fillable = ['codigo', 'nombre', 'province_id']; 

    // Relación con la tabla Province 
    public function province() {
        return $this->belongsTo(Province::class);
    }
    public function profiles() : HasMany {
        return $this->hasMany(Profile::class);
    }
}
