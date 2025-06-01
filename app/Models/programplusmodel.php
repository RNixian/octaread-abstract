<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class programplusmodel extends Model
{
    use HasFactory;

    protected $table = 'programplus';

    protected $fillable = [
        'programplus',
    ];
}
