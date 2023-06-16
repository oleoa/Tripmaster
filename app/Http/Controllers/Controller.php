<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Countries;
use App\Helpers\Image;
use App\Helpers\Error;
use App\Helpers\Data;
use App\Models\User;

class Controller extends BaseController
{
  use AuthorizesRequests, ValidatesRequests;

  protected Data $data;
  protected Image $image;
  protected Countries $countries;
  protected Error $error;

  public function __construct()
  {
    $this->data = Data::getInstance();
    $this->countries = Countries::getInstance();
    $this->image = Image::getInstance();
    $this->error = Error::getInstance();
  }
  
  protected function view($page)
  {
    $this->data->isLogged(Auth::check());
    $this->data->current($page);
    
    return view($page, $this->data->get());
  }

  protected function getLastProjectOpened($userId)
  {
    $lastProjectOpened = User::where("id", $userId)->first()->lastProjectOpened ?? false;
    if(!$lastProjectOpened) {
      session()->reflash();
      return false;
    }
    return $lastProjectOpened;
  }
}
