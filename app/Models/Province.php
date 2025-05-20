<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    use HasFactory;

    protected $table = 'provinces';
    protected $fillable = ['codigo', 'nombre', 'region_id'];

    public function region() {
        return $this->belongsTo(Region::class);
    }
    public function cities() {
        return $this->hasMany(City::class);
    }
    public function profiles() : HasMany {
        return $this->hasMany(Profile::class);
    }
}
