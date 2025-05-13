<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $table = 'provinces';
    protected $fillable = ['codigo', 'nombre', 'region_id'];

    // Defino la relación con la tabla "Region"
    public function region() {
        return $this->belongsTo(Region::class);
    }

    // Defino la relación con la tabla "City"
    public function cities() {
        return $this->hasMany(City::class);
    }
}
