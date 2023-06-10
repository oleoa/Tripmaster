<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
  public function index()
  {
    $this->data->title('Project');

    if(!session()->get('project'))
      return redirect()->route('home');
    
    $this->data->set("p", session()->get("project"));

    return $this->view('main');
  }
}
