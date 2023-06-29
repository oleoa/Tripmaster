<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stays extends Model
{
  use HasFactory;

  protected $table = 'stays';

  protected $fillable = [
    'title',
    'description',
    'owner',
    'capacity',
    'bedrooms',
    'price',
    'address',
    'country',
    'image',
    'city',
    'lat',
    'lon'
  ];
}
