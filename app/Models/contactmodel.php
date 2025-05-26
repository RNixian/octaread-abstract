<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contactModel extends Model
{
    use HasFactory;

    protected $table = 'contact';

    protected $fillable = [
        'contact_number',
        'email',
        'social_media',
        'social_media_link',
    ];

}