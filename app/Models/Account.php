<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    protected $table = 'accounts'; 

    protected $fillable = [
        'email',
        'password_hash',
        'type', 
    ]; 

    protected $hidden = [
        'password_hash',
    ]; 

    public function getAuthPassword()
    {
        return $this->password_hash; 
    }

    // Definir relaciones con la tabla perfil
    public function profile(): HasOne {
        return $this->hasOne(Profile::class);
    }
    
}
