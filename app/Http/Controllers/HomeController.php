<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function __construct()
  {
    parent::__construct();

    $this->setTitle('Home');
  }

  public function index()
  {
    return view('home', $this->getData());
  }
}
