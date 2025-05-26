<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class coursemodel extends Model
{
    use HasFactory;

    protected $table = 'course';

    protected $fillable = [
        'course',
    ];

}