<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stay_Reviews extends Model
{
    use HasFactory;

    protected $table = 'stay_reviews';

    protected $fillable = [
        'id',
        'user',
        'stay',
        'date',
        'comment',
        'title',
        'rating'
    ];
}
