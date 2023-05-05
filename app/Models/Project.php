<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
  use HasFactory;

  protected $table = 'projects';

  protected $fillable = [
    'id',
    'owner',
    'country',
    'start',
    'end',
    'isFlag',
    'image',
    'headcount',
    'adults',
    'children'
  ];
}
