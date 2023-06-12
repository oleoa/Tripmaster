<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Stays_Images;
use App\Models\Stays;
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
      
    $this->data->set('country', $project->country);
    
    $stays = Stays::where("country", $project->country)->get();
    for($i = 0; $i < count($stays); $i++)
    {
      $stays[$i]->image = Stays_Images::where("stay", $stays[$i]->id)->first()->image_path ?? false;
    }
    $this->data->set('stays', $stays);

    return $this->view('stays.index');
  }
}
