<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class Image
{
  // Singleton
  private static $instance;
  public static function getInstance(): Image
  {
    if(empty(self::$instance)) {
      self::$instance = new Image();
    }
    
    return self::$instance;
  }
  private function __construct(){}

  const NO_IMAGE = "https://climate.onep.go.th/wp-content/uploads/2020/01/default-image.jpg";
  
  public static function get($path, $default = false)
  {
    $path = str_replace('storage/', '', $path);
    if(Storage::disk('public')->exists($path))
      return asset('storage/'.$path);
    else
      return $default ? $defualt : Image::NO_IMAGE;
  }

  public static function set($path, $file)
  {
    $path = str_replace('storage/', '', $path);
    $path = 'storage/'.$path;
    try {
      $response = Storage::disk('public')->put($path, $file);
    } catch (\Throwable $th) {
      return false;
    }
    return $response;
  }
}
