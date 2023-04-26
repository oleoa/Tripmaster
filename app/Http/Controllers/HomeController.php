<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function __construct()
  {
    parent::__construct();
    
    $this->data->title('Home');
  }

  public function index()
  {
    return view('home', $this->data->get());
  }
}
