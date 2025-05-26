<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooksModel extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'title', 'author', 'year', 'category', 'department', 'pdf_filepath',
    ];

    public static function add_new_books($data)
    {
        return self::create($data);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(Usermodel::class, 'favorites', 'ebook_id', 'user_id')->withTimestamps();
    }
}
