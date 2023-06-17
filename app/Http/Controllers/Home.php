<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Home extends Controller
{
  public function index()
  {
    $this->data->title("Home");
    session()->flash('success', 'Welcome to the home page');
    return $this->view('home');
  }
}
