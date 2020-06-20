<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "books";
    protected $fillable = [
        'book_id',
        'name_book',
        'authors',
        'active',
        'user_r',
    ];

    public function author()
    {
        return $this->belongsTo('App\Author', 'book_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'book_id', 'id');
    }
}
