<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class favmodel extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'favorites';

    protected $fillable = [
        'user_id', 'ebook_id',
    ];
}
