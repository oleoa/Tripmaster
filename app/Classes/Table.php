<?php

namespace App\Classes;

abstract class Table
{
  public function __construct()
  {
    $this->format();
  }

  abstract public function format(): void;

  protected function setAndGet($attr, $name)
  {
    if($attr === null)
      return $this->{$name};
    $this->{$name} = $attr;
    return true;
  }
}