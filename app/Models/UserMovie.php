<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMovie extends Model
{
    protected $table = 'user_movie';

    protected $fillable = [
        'user_id',
        'movie_id',
        'position',
        'rating',
        'tags',
    ];

    public $timestamps = true;

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
