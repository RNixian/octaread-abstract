<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usermodel extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'schoolid',
        'department',
        'birthdate',
        'user_type_id',
    ];

    protected $hidden = ['birthdate'];

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function favorites()
    {
        return $this->belongsToMany(BooksModel::class, 'favorites', 'user_id', 'ebook_id')->withTimestamps();
    }


    public function userType()
    {
        return $this->belongsTo(UserTypeModel::class, 'user_type_id');
    }
    


}
