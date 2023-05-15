<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyStaysController extends Controller
{
  public function index()
  {
    $this->data->title('Listing my Stays');
    return $this->view('stays.create');
  }
  
  public function creator()
  {
    $this->data->title('Create Stay');
    return $this->view('stays.create');
  }
}
