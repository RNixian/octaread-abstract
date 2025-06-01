<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class underrocmodel extends Model
{
    use HasFactory;

    protected $table = 'under_out_cat';

    protected $fillable = [
        'out_cat_id', 'under_roc',
    ];

    public function outputCategory()
    {
        return $this->belongsTo(rocmodel::class, 'out_cat_id');
    }
    



}
