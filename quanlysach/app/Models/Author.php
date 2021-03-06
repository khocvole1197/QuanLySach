<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'authors';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    // protected $guarded = ['id'];
    protected $fillable = [
        'name_authors'
    ];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function books()
    {
        return $this->hasMany('App\Book', 'book_id', 'id');
    }
    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
