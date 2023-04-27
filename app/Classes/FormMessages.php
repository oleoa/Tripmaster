<?php

namespace App\Classes;

class FormMessages
{
  // Singleton
  private static $instance;
  public static function getInstance(): FormMessages
  {
    if(empty(self::$instance)) {
      self::$instance = new FormMessages();
    }
    
    return self::$instance;
  }
  private function __construct()
  {
    $this->format();
  }

  private array $status;
  private array $error;
  private array $message;
  private array $redirect;

  public function format(): void
  {
    $this->status = null;
    $this->error = null;
    $this->message = null;
    $this->redirect = null;
  }

  
}