<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;



class User extends Authenticatable
{
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    // name can be seen as company name.
    protected $fillable = [
        'name', 'email', 'phone','password','role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    
}
