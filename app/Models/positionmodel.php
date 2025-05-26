<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class positionmodel extends Model
{
    use HasFactory;

    protected $table = 'position';

    protected $fillable = [
        'position',
    ];

}