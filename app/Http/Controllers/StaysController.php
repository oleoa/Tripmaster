<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Stays_Images;
use App\Models\Project;
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
      $img_path = Stays_Images::where("stay", $stays[$i]->id)->first()->image_path ?? false;
      $stays[$i]->image = $this->image->get('stays/'.$img_path);
    }

    $this->data->set('staySelected', $project->stay);

    $this->data->set('stays', $stays);

    return $this->view('stays.index');
  }

  public function show($id)
  {
    $this->data->title('Stay');

    $stay = Stays::where("id", $id)->first() ?? false;
    if(!$stay)
      return redirect()->route('list.stays');
    $stay->images = array();
    
    $images_path = Stays_Images::where("stay", $stay->id)->get()->toArray() ?? false;
    if($images_path) {
      $images = array();
      foreach($images_path as $image)
        $images[] = $this->image->get('stays/'.$image['image_path']);
      $stay->images = $images;
    }

    $this->data->set('stay', $stay);

    $this->data->set('backHref', url()->previous());

    return $this->view('stays.stay');
  }
}
