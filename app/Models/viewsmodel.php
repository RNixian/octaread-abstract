<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class viewsmodel extends Model
{
    use HasFactory;

    protected $table = 'views';

    
    protected $fillable = [
        'user_id', 'ebook_id',
    ];
}
