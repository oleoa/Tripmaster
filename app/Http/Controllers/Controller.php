<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Helpers\DataHelper;

class Controller extends BaseController
{
  use AuthorizesRequests, ValidatesRequests;

  protected $dataManager;

  public function __construct()
  {
    $this->dataManager = new DataHelper();
  }

  protected function setTitle($title)
  {
    $this->dataManager->setTitle($title);
  }

  protected function getData()
  {
    return $this->dataManager->getData();
  }
}
