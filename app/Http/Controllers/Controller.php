<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Helpers\DataHelper;

class Controller extends BaseController
{
  use AuthorizesRequests, ValidatesRequests;

  protected Data $data;

  public function __construct()
  {
    $this->data = Data::getInstance();
  }

}
