<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usertypemodel extends Model
{
    use HasFactory;

    protected $table = 'usertype';

    protected $fillable = [
        'user_type',
    ];
    public function departments()
    {
        return $this->hasMany(userdeptmodel::class, 'user_type_id');
    }

}