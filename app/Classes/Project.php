<?php

namespace App\Classes;

use App\Classes\Table;

class Project extends Table
{
  protected $datas = array('id', 'owner', 'title', 'country', 'date', 'headcount', 'image');
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