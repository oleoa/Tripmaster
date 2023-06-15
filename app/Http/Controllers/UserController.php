<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Mail\VerificationEmail;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
  public function signin()
  {
    $this->data->set("password_min_length", env('PASSWORD_MIN_LENGTH'));
    $this->data->set("password_max_length", env('PASSWORD_MAX_LENGTH'));
    $this->data->title('Signin');
    return $this->view('sign.in');
  }
  
  public function signup()
  {
    $this->data->set("password_min_length", env('PASSWORD_MIN_LENGTH'));
    $this->data->set("password_max_length", env('PASSWORD_MAX_LENGTH'));
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
      'password' => [
        'required',
        'confirmed',
        'min:'.env('PASSWORD_MIN_LENGTH'),
        'max:'.env('PASSWORD_MAX_LENGTH'),
        'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]+$/',
        Rule::notIn(['password', '123456', 'qwerty', '123456789', '12345678', '12345', '1234567', '1234567', '1234567890', 'abc123', 'password1', 'admin', 'letmein', 'welcome', 'monkey', '123123', 'football', 'iloveyou', '1234', 'sunshine']), // Common passwords
      ]
    ]);

    $pass_hash = Hash::make($validated['password']);
    $verificationToken = Str::random(40);
    
    $new_user = array(
      'name' => $validated['name'],
      'email' => $validated['email'],
      'password' => $pass_hash,
      'verification_token' => $verificationToken,
    );

    $info = User::create($new_user);

    $login_user = $new_user;
    $login_user['password'] = $validated['password'];

    $this->messages("Something went wrong, please try again");
    $this->attempt($info != false, $request);
    if(!$this->status)
      return redirect()->route('signup');
    
    $verificationLink = route('verify', ['token' => $verificationToken]);
    Mail::to($request->email)->send(new VerificationEmail($verificationLink));
    
    Auth::attempt($login_user);
    $request->session()->regenerate();

    return redirect()->route('main');
  }
}
