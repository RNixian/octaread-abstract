<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class departmentmodel extends Model
{
    use HasFactory;

    protected $table = 'department';

    protected $fillable = [
        'department',
    ];

}