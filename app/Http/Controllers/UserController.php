<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
  
  public function signing_in(Request $request)
  {
    $validated = $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);
    
    if(!Auth::attempt($validated))
    return redirect()->route('signin');
    
    $request->session()->regenerate();
    return redirect()->route('home');
  }
  
  public function signing_up()
  {
    $validated = $request->validate([
      'name' => 'required',
      'email' => 'required|email',
      'password' => 'required|confirmed'
    ]);

    $pass_hash = Hash::make($validated['password']);

    // Create User

    return redirect()->route('home');
  }
}
