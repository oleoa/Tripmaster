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

  public function creator()
  {
    $this->data->title('Create Stay');
    return $this->view('stays.create');
  }
}
