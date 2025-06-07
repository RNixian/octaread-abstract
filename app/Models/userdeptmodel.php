<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userdeptmodel extends Model
{
    use HasFactory;

    protected $table = 'userdepartment';

    protected $fillable = [
        'user_type_id',
        'user_department',
    ];

    public function userTypes()
    {
        return $this->belongsTo(usertypemodel::class, 'user_type_id');
    }
}
