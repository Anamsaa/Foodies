<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $table = 'regions';
    protected $fillable = ['codigo', 'nombre'];

    // Definición de la relación con la tabla "Province"
    public function provinces() {
        return $this->hasMany(Province::class);
    }
}
