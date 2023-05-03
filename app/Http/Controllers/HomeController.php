<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
    return $this->view('home');
  }
}
