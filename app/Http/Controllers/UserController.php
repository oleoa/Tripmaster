<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
  
  public function signin()
  {
    $this->data->title('Signin');
    return $this->view('sign.in');
  }
  
  public function signup()
  {
    $this->data->title('Signup');
    return $this->view('sign.up');
  }
  
  public function signout()
  {
    return redirect()->route('home');
  }
  
  public function signing_in()
  {
    return redirect()->route('home');
  }

  public function signing_up()
  {
    return redirect()->route('home');
  }
}
