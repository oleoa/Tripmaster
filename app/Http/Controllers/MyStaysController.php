<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Stays_Images;
use App\Models\Stays;

class MyStaysController extends Controller
{
  private $you_are_not_the_owner = "You are not the owner of that stay";
  private $not_found = "Stay not found";

  public function index()
  {
    $this->data->title('Listing my Stays');

    $stays = Stays::where('owner', '=', Auth::id())->get()->toArray();
    $this->data->set('stays', $stays);

    return $this->view('my.stays.list');
  }

  public function enable(Request $request, $id)
  {
    $attempt = $this->stay_exists_and_ur_the_owner($request, $id);
    if(!is_array($attempt))
      return $attempt;

    Stays::where("id", $id)->update(["status" => "available"]);
    return redirect()->back();
  }

  public function disable(Request $request, $id)
  {
    $attempt = $this->stay_exists_and_ur_the_owner($request, $id);
    if(!is_array($attempt))
      return $attempt;

    Stays::where("id", $id)->update(["status" => "disabled"]);
    return redirect()->back();
  }

  public function delete(Request $request, $id)
  {
    $attempt = $this->stay_exists_and_ur_the_owner($request, $id);
    if(!is_array($attempt))
      return $attempt;

    Stays::destroy($id);
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
    
    $saved_stay = Stays::where('id', $id)->update($validated);
    
    return redirect()->route('my.list.stays');
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
    
    $stay = Stays::create($validated);
    
    $images = $request->file('images');
    if($images)
      foreach($images as $img){
        $image_path = explode("/", $img->store('stays', 'public'))[1];
        $image = array(
          'image_path' => $image_path,
          'stay' => $stay['id']
        );
        Stays_Images::create($image);
      }
    
    return redirect()->route('my.list.stays');
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
    $stay_exists = Stays::find($id);
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
