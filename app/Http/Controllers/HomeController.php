<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function index()
  {
    $this->data->title("Home");
    return $this->view('home');
  }
}
