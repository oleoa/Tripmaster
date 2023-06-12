<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MyAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      $currentRouteName = $request->route()->getName();
      if($currentRouteName == "signin" || $currentRouteName == "signup" || $currentRouteName == "signout" || $currentRouteName == "signing-in" || $currentRouteName == "signing-up")
        return $next($request);

      if (Auth::guest())
        return redirect()->route('signin');

      return $next($request);
    }
}
