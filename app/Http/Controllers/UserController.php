<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

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
    Session::flush();
    return redirect()->route('signin');
  }
  
  public function signing_in(Request $request)
  {
    $validated = $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);

    $this->messages("Email or password incorrect");
    
    $this->attempt(Auth::attempt($validated), $request);
    if(!$this->status)
      return redirect()->route('signin');
    
    $request->session()->regenerate();
    return redirect()->route('main');
  }
  
  public function signing_up(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required',
      'email' => 'required|email',
      'password' => 'required|confirmed'
    ]);

    $pass_hash = Hash::make($validated['password']);

    $user = array(
      'name' => $validated['name'],
      'email' => $validated['email'],
      'password' => $pass_hash
    );

    $info = User::create($user);

    $this->messages("Something went wrong, please try again");
    $this->attempt($info != false, $request);
    if(!$this->status)
      return redirect()->route('signup');
    
    Auth::attempt($user);
    $request->session()->regenerate();

    return redirect()->route('signin');
  }
}
