<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Countries;
use App\Helpers\Image;
use App\Helpers\Data;

class Controller extends BaseController
{
  use AuthorizesRequests, ValidatesRequests;

  protected Data $data;
  protected Image $image;
  protected Countries $countries;

  public function __construct()
  {
    $this->data = Data::getInstance();
    $this->countries = Countries::getInstance();
    $this->image = Image::getInstance();
  }
  
  protected function view($page)
  {
    $this->data->isLogged(Auth::check());
    $this->data->current($page);
    
    return view($page, $this->data->get());
  }
}
