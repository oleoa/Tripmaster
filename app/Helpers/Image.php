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
  
  public function get($path, $default = false)
  {
    $path = $this->format($path);
    if(Storage::disk('public')->exists($path) && $path[strlen($path)-1] != '/')
      return asset('storage/'.$path);
    else
      return $default ? $default : Image::NO_IMAGE;
  }

  public function set($path, $file)
  {
    $path = $this->format($path);
    $pathCount = count(explode('/', $path));
    try {
      $response = Storage::disk('public')->put($path, $file);
    } catch (\Throwable $th) {
      return false;
    }
    if($response === true)
      return true;
    return explode('/', $response)[$pathCount];
  }

  public function default()
  {
    return $this::NO_IMAGE;
  }

  private function format($path)
  {
    return str_replace('storage/', '', $path);
  }
}
