<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies';

    protected $fillable = [
        'imdb_id',
        'title',
        'year',
        'poster',
        'metadata',
    ];

    public $timestamps = true;

    protected $dateFormat = 'd/m/Y H:i:s';
}
