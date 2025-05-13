<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory; 

    protected $table = 'cities';

    protected $fillable = ['codigo', 'nombre', 'province_id']; 

    // Relación con la tabla Province 
    public function province() {
        return $this->belongsTo(Province::class);
    }
}
