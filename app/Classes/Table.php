<?php

namespace App\Classes;

abstract class Table
{
  public function __construct()
  {
    $this->format();
  }

  abstract public function format(): void;
  abstract public function get(): array;

  public function __get($name)
  {
    return $this->data[$name];
  }

  public function __set($name, $value)
  {
    if(!in_array($name, $this->datas))
      return;
    $this->data[$name] = $value;
  }

  public function __call($name, $arguments)
  {
    if(!$arguments)
      return $this->data[$name];
    $this->__set($name, $arguments[0]);
  }
}
