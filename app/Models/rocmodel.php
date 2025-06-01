<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class rocmodel extends Model
{
    use HasFactory;

    protected $table = 'research_out_cat';

    protected $fillable = [
        'out_cat',
    ];
}
