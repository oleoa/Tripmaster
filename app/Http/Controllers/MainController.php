<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Stays;
use App\Models\User;

class MainController extends Controller
{
  public function index()
  {
    $this->data->title('Project');

    $lastProjectOpened = User::where("id", Auth::id())->first()->lastProjectOpened ?? false;
    if(!$lastProjectOpened)
      return redirect()->route('my.creator.project');
    
    $project = Project::where("id", $lastProjectOpened)->first() ?? false;
    if(!$project)
      return redirect()->route('my.creator.project');
      
    $this->data->set("p", $project);

    $stay = Stays::where("id", $lastProjectOpened)->first() ?? false;
    if($stay)
      $this->data->set("s", $stay);

    return $this->view('main');
  }
}
