<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stays_Images extends Model
{
  use HasFactory;
  
  protected $table = 'stays_images';

  protected $fillable = [
    'stay',
    'image_path'
  ];
}
