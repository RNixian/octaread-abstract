<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class membersModel extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'fullname',
        'position',
        'profile_imgpath'
    ];

}