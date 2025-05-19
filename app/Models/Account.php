<?php

namespace App\Models;

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
    
}
