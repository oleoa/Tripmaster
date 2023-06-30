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
      $allowedNotAuthRoutes = [
        "sign.in",
        "sign.up",
        "sign.out",
        "sign.ing-in",
        "sign.ing-up",
        "contact",
        "recover.password.anonymously",
        "verification.password.anonymously",
        "account.password.editor.anonymously",
        "account.password.edit.anonymously",
        "home"
      ];
      if(in_array($currentRouteName, $allowedNotAuthRoutes))      
        return $next($request);

      if(Auth::guest())
        return redirect()->route('home');

      return $next($request);
    }
}
