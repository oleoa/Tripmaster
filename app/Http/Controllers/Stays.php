<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Stays as StaysModel;
use Illuminate\Http\Request;
use App\Models\Stays_Images;
use App\Models\Project;
use App\Models\User;

class Stays extends Controller
{
  public function index()
  {
    $this->data->title('Stays');

    $lastProjectOpened = User::where("id", Auth::id())->first()->lastProjectOpened ?? false;
    if(!$lastProjectOpened)
      return redirect()->route('projects.creator');
    
    $project = Project::where("id", $lastProjectOpened)->first() ?? false;
    if(!$project)
      return redirect()->route('projects.creator');
      
    $this->data->set('country', $project->country);
    
    $stays = StaysModel::where("country", $project->country)->get();
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

    $stay = StaysModel::where("id", $id)->first() ?? false;
    if(!$stay)
      return redirect()->route('list.stays');
    $stay->images = array();
    
    $images_path = Stays_Images::where("stay", $stay->id)->get()->toArray() ?? false;
    if($images_path) {
      $images = array();
      foreach($images_path as $image)
        $images[] = $this->image->get('stays/'.$image['image_path']);
      $stay->images = $images;
    } else {
      $images = array();
      $images[] = $this->image->default();
      $stay->images = $images;
    }

    $this->data->set('stay', $stay);

    $this->data->set('backHref', url()->previous());

    return $this->view('stays.stay');
  }
  
  public function rent($id)
  {
    $stay = StaysModel::where("id", $id)->first() ?? false;
    if(!$stay)
      return redirect()->route('list.stays');

    $lastProjectOpened = User::where("id", Auth::id())->first()->lastProjectOpened ?? false;
    if(!$lastProjectOpened)
      return redirect()->route('projects.creator');
    
    $project = Project::where("id", $lastProjectOpened)->first() ?? false;
    if(!$project)
      return redirect()->route('projects.creator');

    $this->data->title('Rent');
    $this->data->set("stay", $stay);
    $this->data->set("minDate", $project->start);
    $this->data->set("maxDate", $project->end);
    $this->data->set("maxHeadcount", $project->headcount);

    return $this->view('stays.rent');
  }

  private $you_are_not_the_owner = "You are not the owner of that stay";
  private $not_found = "Stay not found";

  public function list()
  {
    $this->data->title('Listing my Stays');

    $stays = StaysModel::where('owner', '=', Auth::id())->get()->toArray();
    $this->data->set('stays', $stays);

    return $this->view('my.stays.list');
  }

  public function enable(Request $request, $id)
  {
    $attempt = $this->stay_exists_and_ur_the_owner($request, $id);
    if(!is_array($attempt))
      return $attempt;

    StaysModel::where("id", $id)->update(["status" => "available"]);
    return redirect()->back();
  }

  public function disable(Request $request, $id)
  {
    $attempt = $this->stay_exists_and_ur_the_owner($request, $id);
    if(!is_array($attempt))
      return $attempt;

    StaysModel::where("id", $id)->update(["status" => "disabled"]);
    return redirect()->back();
  }

  public function delete(Request $request, $id)
  {
    $attempt = $this->stay_exists_and_ur_the_owner($request, $id);
    if(!is_array($attempt))
      return $attempt;

    StaysModel::destroy($id);
    return redirect()->back();
  }
  
  public function editor(Request $request, $id)
  {
    $stay = $this->stay_exists_and_ur_the_owner($request, $id);
    if(!is_array($stay))
      return $stay;
      
    $this->data->title('Edit Stay');
    $this->data->set('owner', Auth::id());
    $this->data->set('page_title', 'Edit Stay');
    $this->data->set('submit_button', 'Update');
    $this->data->set('form_route', route('my.edit.stay', ['id' => $id]));
    $this->data->set('editing_case', true);
    $countries = $this->countries->getAll();
    $this->data->set('possible_countries', $countries);
    $this->data->set('stay', $stay);
    
    return $this->view('my.stays.create_and_edit');
  }
  
  public function creator()
  {
    $this->data->title('Create Stay');
    $this->data->set('owner', Auth::id());
    $this->data->set('editing_case', false);
    $this->data->set('form_route', route('my.create.stay'));
    $this->data->set('submit_button', 'Create');
    $this->data->set('page_title', 'Create Stay');
    $countries = $this->countries->getAll();
    $this->data->set('possible_countries', $countries);
    return $this->view('my.stays.create_and_edit');
  }
  
  public function edit(Request $request, $id)
  {
    $validated = $request->validate([
      'owner' => 'required',
      'title' => 'required',
      'description' => 'required',
      'capacity' => 'required',
      'bedrooms' => 'required',
      'price' => 'required',
      'country' => 'required',
      'city' => 'required'
    ]);
    
    $saved_stay = StaysModel::where('id', $id)->update($validated);
    
    return redirect()->route('stays.list');
  }
  
  public function create(Request $request)
  {
    $validated = $request->validate([
      'owner' => 'required',
      'title' => 'required',
      'description' => 'required',
      'capacity' => 'required',
      'bedrooms' => 'required',
      'price' => 'required',
      'country' => 'required',
      'city' => 'required'
    ]);
    
    $stay = StaysModel::create($validated);

    $images = $request->file('images');
    if($images)
      foreach($images as $img) {
        $image = array(
          'image_path' => $this->image->set('stays', $img),
          'stay' => $stay['id']
        );
        Stays_Images::create($image);
      }
    
    return redirect()->route('stays.list');
  }

  /**
   * It verifies if the stay searched does
   * exists and if the person who is trying to 
   * edit/delete it is the owner.
   * 
   * This funcion only exists to save code.
   */
  private function stay_exists_and_ur_the_owner($request, $id)
  {
    $stay_exists = StaysModel::find($id);
    if(!$stay_exists){
      $request->session()->flash('alert', $this->not_found);
      return redirect()->back();    
    }
    
    $stay = $stay_exists->toArray();
    
    $belongs = $stay['owner'] == Auth::id();
    if(!$belongs){
      $request->session()->flash('alert', $this->you_are_not_the_owner);
      return redirect()->back();      
    }

    return $stay;
  }
}
