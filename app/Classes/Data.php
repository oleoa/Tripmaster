<?php

namespace App\Classes;

class Data
{
  // Singleton
  private static $instance;
  public static function getInstance(): Data
  {
    if(empty(self::$instance)) {
      self::$instance = new Data();
    }
    
    return self::$instance;
  }
  private function __construct()
  {
    $this->format();
  }

  private array $data;
  private array $fillable;

  public function title($title): void
  {
    $this->fillable['title'] = $title;
  }

  public function format(): void
  {
    $this->data = array();
    $this->fillable = array();
  }

  public function get(): array
  {
    $data = $this->data;
    foreach($this->fillable as $key => $value)
      $data[$key] = $value;

    return $data;
  }

  public function theme($theme): void
  {
    $this->fillable['theme'] = $theme;
  }
  
  public function current($page)
  {
    $page = strtolower($page);
    $this->fillable['current'] = $page;
  }

  public function set($key, $value)
  {
    $this->data[$key] = $value;
  }
}