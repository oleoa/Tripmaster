<?php

namespace App\Classes;

use App\Classes\Table;

class User extends Table
{
  protected $datas = array('id', 'name', 'email', 'password');
  protected $data;

  public function format(): void
  {
    $this->data = null;
  }

  public function get(): array
  {
    return $this->data;
  }
}
