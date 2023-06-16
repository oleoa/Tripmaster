<?php

namespace App\Helpers;

class Error
{
  // Singleton
  private static $instance = null;
  private function __construct(){}
  public static function getInstance()
  {
    if(self::$instance == null)
      self::$instance = new Error();
    return self::$instance;
  }

  private $redirect = [];
  private $message = [];

  public function redirect($name, $route = false)
  {
    if($route)
      $this->redirect[$name] = $route;
    else
      return $this->redirect[$name] ?? false;
  }

  public function message($name = false, $message = false)
  {
    if(!$name)
      return $this->message;
    else
      if($message)
        $this->message[$name] = $message;
      else
        return $this->message[$name] ?? false;
  }
}
