<?php

namespace App\Helpers;

class DataHelper
{
  private $data;

  public function setTitle($title)
  {
    $this->data['title'] = $title;
  }

  public function getData()
  {
    return $this->data;
  }
}