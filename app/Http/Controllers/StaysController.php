<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Stays_Images;
use App\Models\Stays;
use App\Models\User;

class StaysController extends Controller
{
  const NO_IMAGE = "https://pumpkin.pt/wp-content/uploads/anexos/Hellokitty2.jpg";

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
      if(Storage::disk('public')->exists('stays/'.$img_path))
        $stays[$i]->image =  asset('storage/stays/'.$img_path);
      else
        $stays[$i]->image =  $this::NO_IMAGE;
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

    $stays_images = Stays_Images::where("stay", $stay->id)->get();

    $this->data->set('stay', $stay);
    $this->data->set('images', $stays_images);

    $this->data->set('backHref', url()->previous());

    return $this->view('stays.stay');
  }
}
