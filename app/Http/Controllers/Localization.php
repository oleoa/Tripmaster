<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Localization extends Controller
{
  public function index($locale)
  {
    if (! in_array($locale, ['en', 'pt']))
      abort(400);

    app()->setLocale($locale);
    
    session(['locale' => $locale]);

    return redirect()->back();
  }
}
