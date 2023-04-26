<?php

namespace App\Objects;

class Data
{
  // Singleton
  private static $instance;
  private function __construct(){}
  public static function getInstance(): Data
  {
    if(empty(self::$instance)) {
      self::$instance = new Data();
    }

    return self::$instance;
  }

  private array $data;
  private array $fillable;

  public function title($title): void
  {
    $this->fillable['title'] = $title;
  }

  public function format(): void
  {
    $this->data = null;
    $this->fillable = null;
  }

  public function get(): array
  {
    $data = $this->data;
    foreach($fillable as $key => $value)
      $data[$key] = $value;

    return $data;
  }
}