<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class VerificationController extends Controller
{
  public function verify(Request $request, $token)
  {
    // Retrieve the user based on the provided token
    $user = User::where('verification_token', $token)->first();

    if (!$user) {
      return redirect()->route('verification.error')->with('error', 'Invalid verification token.');
    }

    // Verify the user's email
    $user->email_verified_at = now();
    $user->verification_token = null;
    $user->save();

    // Redirect to a success page or display a success message
    return redirect()->route('verification.success')->with('success', 'Your email has been successfully verified.');
  }
}
