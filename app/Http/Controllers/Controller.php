<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Classes\Data;

class Controller extends BaseController
{
  use AuthorizesRequests, ValidatesRequests;

  protected Data $data;

  public function __construct()
  {
    $this->data = Data::getInstance();
    $currentRouteName = Route::currentRouteName();
    if($currentRouteName != "signin" && $currentRouteName != "signup" && $currentRouteName != "signout" && $currentRouteName != "signing_in" && $currentRouteName != "signing_up" && !Auth::check())
      return redirect()->route('signin');
  }
  
  protected function view($page)
  {
    $this->data->isLogged(Auth::check());
    $this->data->current($page);
    
    return view($page, $this->data->get());
  }

  private array $message;
  protected bool $status;
  protected function messages($didnt, $worked = "")
  {
    $this->message[true] = $worked;
    $this->message[false] = $didnt;
  }
  protected function attempt(Bool $attempt, $request)
  {
    $request->session()->flash('message', $this->message[$attempt]);
    $request->session()->flash('status', $attempt);
    $this->status = $attempt;
  }
}
