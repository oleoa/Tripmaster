<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class StaysController extends Controller
{
  public function index()
  {
    $this->data->title('Stays');

    $lastProjectOpened = User::where("id", Auth::id())->first()->lastProjectOpened ?? false;
    if(!$lastProjectOpened)
      return redirect()->route('my.creator.project');
    
    $project = Project::where("id", $lastProjectOpened)->first() ?? false;
    if(!$project)
      return redirect()->route('my.creator.project');
      
    $this->data->set("p", $project);

    $this->data->set('country', $project->country);

    return $this->view('stays.index');
  }

}
