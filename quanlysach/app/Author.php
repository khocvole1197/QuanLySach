<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    //
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name_authors'
    ];
    public function books()
    {
        return $this->hasMany('App\Book', 'book_id', 'id');
    }
}
