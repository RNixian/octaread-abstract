<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class carouselmodel extends Model
{
    use HasFactory;

    protected $table = 'carousel';

    protected $fillable = [
        'carousel_imgpath',
        'display_order',

    ];

}