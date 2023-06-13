<?php

namespace App\Helpers;

use App\Helpers\Current;

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
    $this->current = new Current();
  }

  private array $data;
  private array $fillable;

  private $current;

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

  public function inverseTheme($inverseTheme): void
  {
    $this->fillable['inverseTheme'] = $inverseTheme;
  }

  public function isLogged($isLogged): void
  {
    $this->fillable['isLogged'] = $isLogged;
  }
  
  public function current($page)
  {
    $this->fillable['current'] = $this->current->get($page);
  }

  public function set($key, $value)
  {
    $this->data[$key] = $value;
  }
}