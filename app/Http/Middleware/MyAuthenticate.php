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
      if($currentRouteName == "sign.in" || $currentRouteName == "sign.up" || $currentRouteName == "sign.out" || $currentRouteName == "sign.ing-in" || $currentRouteName == "sign.ing-up" || $currentRouteName == "home")
        return $next($request);

      if(Auth::guest())
        return redirect()->route('home');

      return $next($request);
    }
}
