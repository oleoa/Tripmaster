<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaysController extends Controller
{
  public function index()
  {
    $this->data->title('Stays');
    return $this->view('stays.index');
  }

}
