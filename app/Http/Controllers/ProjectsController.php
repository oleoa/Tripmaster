<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectsController extends Controller
{
  public function creator()
  {
    $this->data->title('Create Project');
    return $this->view('projects.create');
  }
  
  public function index()
  {
    $this->data->title('Projects List');
    return $this->view('projects.list');
  }
}
