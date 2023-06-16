<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class Verification extends Controller
{
  public function verify(Request $request, $token)
  {
    $user = User::where('verification_token', $token)->first();

    if (!$user)
      return redirect()->route('validation.error');

    $user->email_verified_at = now();
    $user->verification_token = null;
    $user->save();

    return redirect()->route('validation.success');
  }

  public function success()
  {
    return view('verification.success');
  }

  public function error()
  {
    return view('verification.error');
  }
}
