<?php

namespace App\Stays;

use App\Stays\Table;

class Stays extends Table
{
  protected $datas = array('id', 'owner', 'title', 'description', 'capacity', 'bedrooms', 'locale');
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