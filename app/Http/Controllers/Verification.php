<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class Verification extends Controller
{
  public function verify(Request $request, $token)
  {
    $user = User::where('verification_token', $token)->first();

    if(!$user)
      return redirect()->route('validation.error');

    $user->email_verified_at = now();
    $user->verification_token = null;
    $user->save();

    session()->flash("name", $user->name);
    return redirect()->route('validation.success');
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
