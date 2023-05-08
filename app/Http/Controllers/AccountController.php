<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
  public function index()
  {
    $this->data->title('Account');
    return $this->view('account');
  }
}
