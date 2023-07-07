<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notifications;

class Verification extends Controller
{
  public function verify($token)
  {
    $user = User::where('verification_token', $token)->first();

    if(!$user){
      session()->flash("error", $this::INVALID_TOKEN);
      return redirect()->route('verification.error');
    }

    $user->email_verified_at = now();
    $user->verification_token = null;
    $user->save();

    $notification = new Notifications();
    $notification->user = $user->id;
    $notification->date = now();
    $notification->title = "Your account has been verified.";
    $notification->body = "Your account has been verified successfully. You can now use all the features of the website.";
    $notification->save();

    session()->flash("name", $user->name);
    return redirect()->route('verification.success');
  }

  public function password($token)
  {
    $user = User::where('password_verification_token', $token)->first();

    if(!$user){
      session()->flash("error", $this::INVALID_TOKEN);
      return redirect()->route('verification.error');
    }

    $user->email_verified_at = now();
    $user->verification_token = null;
    $user->save();
    
    session()->flash('success', $this::PASSWORD_RESETED);
    return redirect()->route('account.password.editor');
  }
  
  public function password_anonymously($token)
  {
    $user = User::where('password_verification_token', $token)->first();
    
    if(!$user){
      session()->flash("error", $this::INVALID_TOKEN);
      return redirect()->route('verification.error');
    }
    
    $user->password_verification_token = null;
    $user->save();
    
    session()->flash('success', $this::PASSWORD_RESETED);
    session()->put('user', $user);

    return redirect()->route('account.password.editor.anonymously');
  }

  public function success()
  {
    $this->data->title("Verification success");

    $name = session()->get("name");
    session()->flash("name", $name);
    
    $this->data->set("name", $name);
    return $this->view('verification.success');
  }
  
  public function error()
  {
    $this->data->title("Verification error");
    return $this->view('verification.error');
  }
}
