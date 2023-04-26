<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use App\Classes\Data;

class Controller extends BaseController
{
  use AuthorizesRequests, ValidatesRequests;

  protected Data $data;

  public function __construct()
  {
    $this->data = Data::getInstance();
  }
  
  protected function view($page)
  {
    $this->data->theme(session('theme') ?? 'light');
    $this->data->current($page);
    return view($page, $this->data->get());
  }

}
