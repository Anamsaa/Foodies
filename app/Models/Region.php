<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    use HasFactory;
    protected $table = 'regions';
    protected $fillable = ['codigo', 'nombre'];

    // Definición de la relación con la tabla "Province"
    public function provinces() {
        return $this->hasMany(Province::class);
    }
    public function profiles() : HasMany {
        return $this->hasMany(Profile::class);
    }
}
