<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class adminmodel extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins';

    protected $fillable = [
    'firstname', 'middlename', 'lastname', 'schoolid', 'birthdate', 'masterkey', 'role',
];


    protected $hidden = ['masterkey', 'birthdate'];

    protected $casts = ['birthdate' => 'date'];
}
