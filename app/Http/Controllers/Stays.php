<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Stays as StaysModel;
use Illuminate\Http\Request;
use App\Models\Stays_Images;
use Carbon\CarbonPeriod;
use App\Models\Project;
use App\Models\Rents;
use Carbon\Carbon;

class Stays extends Controller
{
  public function index()
  {
    $this->data->title('Stays');

    $lastProjectOpened = $this->getLastProjectOpened(Auth::id());
    if(!$lastProjectOpened){
      session()->flash('info', $this::NO_PROJECTS_YET);
      return redirect()->route('projects.creator');
    }
    
    $project = Project::where("id", $lastProjectOpened)->first() ?? false;
    if(!$project){
      session()->flash('alert', $this::PROJECT_404);
      return redirect()->route('projects.creator');
    }
      
    $this->data->set('country', $project->country);
    
    $stays = StaysModel::where("country", $project->country)->where('status', 'available')->get();
    for($i = 0; $i < count($stays); $i++)
    {
      $img_path = Stays_Images::where("stay", $stays[$i]->id)->first()->image_path ?? false;
      $stays[$i]->image = $this->image->get('stays/'.$img_path);
    }

    $this->data->set('stays', $stays);

    return $this->view('stays.index');
  }
  
  public function reviewer($id)
  {
    $this->data->title('Stay Review');

    $stay = StaysModel::where("id", $id)->first() ?? false;
    if(!$stay){
      session()->flash('error', $this::STAY_404);
      return redirect()->route('stays.list');
    }

    $this->data->set('stay', $stay);

    return $this->view('stays.reviewer');
  }

  public function review(Request $request, $id)
  {
    $validated = $request->validate([
      'title' => 'required',
      'description' => 'required',
      'rating' => 'required'
    ]);
    dd($validated);
  }

  public function show($id)
  {
    $this->data->title('Stay');

    $stay = StaysModel::where("id", $id)->first() ?? false;
    if(!$stay){
      session()->flash('error', $this::STAY_404);
      return redirect()->route('stays.list');
    }

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

  public function dashboard($id)
  {
    $this->data->title('Stay dashboard');

    $stay = StaysModel::where("id", $id)->first() ?? false;
    if(!$stay){
      session()->flash('error', $this::STAY_404);
      return redirect()->route('stays.list');
    }

    $rents = Rents::where("stay", $stay->id)->get()->toArray() ?? false;
    $this->data->set('rents', $rents);

    $this->data->set('stay', $stay);

    return $this->view('stays.dashboard');
  }
  
  public function rent($id)
  {
    $stay = StaysModel::where("id", $id)->where('status', 'available')->first() ?? false;
    if(!$stay){
      session()->flash('error', $this::STAY_404);
      return redirect()->route('stays.list');
    }

    $lastProjectOpened = $this->getLastProjectOpened(Auth::id());
    if(!$lastProjectOpened){
      session()->flash('info', $this::NO_PROJECTS_YET);
      return redirect()->route('projects.creator');
    }
    
    $project = Project::where("id", $lastProjectOpened)->first() ?? false;
    if(!$project){
      session()->flash('alert', $this::PROJECT_404);
      return redirect()->route('projects.creator');
    }

    $this->data->title('Rent');
    $this->data->set("stay", $stay);

    $this->data->set("minDate", $project->start);
    $this->data->set("maxDate", $project->end);

    $this->data->set("maxHeadcount", $project->headcount > $stay->capacity ? $stay->capacity : $project->headcount);

    $startDate = Carbon::parse($project->start);
    $endDate = Carbon::parse($project->end);
    if ($endDate->day < $startDate->day)
      $endDate->addMonth();

    $period = CarbonPeriod::create($startDate, '1 month', $endDate);
    $months = [];
    foreach ($period as $date)
      $months[] = $date;
    
    $this->data->set("months", $months);

    $rents = Rents::where("stay", $stay->id)->where("start_date", ">=", $project->start)->where("end_date", "<=", $project->end)->get()->toArray() ?? false;
    $myRents = array();
    foreach($rents as $rent){
      $period = CarbonPeriod::create($rent['start_date'], $rent['end_date']);
      foreach($period as $date)
        $myRents[] = $date->format('Y-m-d');
    }
    $this->data->set("rents", $myRents);

    return $this->view('stays.rent');
  }

  public function list()
  {
    $this->data->title('Listing my Stays');

    $stays = StaysModel::where('owner', '=', Auth::id())->get()->toArray();
    $this->data->set('stays', $stays);

    return $this->view('stays.list');
  }

  public function enable($id)
  {
    $attempt = $this->stay_exists_and_ur_the_owner($id);
    if(!$attempt){
      session()->flash('alert', $this::NOT_THE_STAY_OWNER);
      return redirect()->route('stays.list');
    }

    StaysModel::where("id", $id)->update(["status" => "available"]);
    return redirect()->back();
  }

  public function disable($id)
  {
    $attempt = $this->stay_exists_and_ur_the_owner($id);
    if(!$attempt){
      session()->flash('alert', $this::NOT_THE_STAY_OWNER);
      return redirect()->route('stays.list');
    }

    StaysModel::where("id", $id)->update(["status" => "disabled"]);
    return redirect()->back();
  }

  public function delete($id)
  {
    $attempt = $this->stay_exists_and_ur_the_owner($id);
    if(!$attempt){
      session()->flash('alert', $this::NOT_THE_STAY_OWNER);
      return redirect()->route('stays.list');
    }

    $stay = StaysModel::where("id", $id)->where('status', '!=', 'rented')->first() ?? false;
    if(!$stay){
      session()->flash('alert', $this::STAY_RENTED);
      return redirect()->route('stays.list');
    }

    StaysModel::destroy($id);
    session()->flash('info', $this::STAY_DELETED);
    return redirect()->back();
  }
  
  public function editor($id)
  {
    $stay = StaysModel::where("id", $id)->first() ?? false;
    if(!$stay){
      session()->flash('error', $this::STAY_404);
      return redirect()->route('stays.list');
    }
    if($stay->status == 'rented'){
      session()->flash('alert', $this::STAY_RENTED);
      return redirect()->route('stays.list');
    }

    $belongs = $this->stay_exists_and_ur_the_owner($id);
    if(!$belongs){
      session()->flash('alert', $this::NOT_THE_STAY_OWNER);
      return redirect()->route('stays.list');
    }
      
    $this->data->title('Edit Stay');
    $this->data->set('owner', Auth::id());
    $this->data->set('page_title', 'Edit Stay');
    $this->data->set('submit_button', 'Update');
    $this->data->set('form_route', route('stays.edit', ['id' => $id]));
    $this->data->set('editing_case', true);
    $countries = $this->countries->getAll();
    $this->data->set('possible_countries', $countries);
    $this->data->set('stay', $stay);
    
    return $this->view('stays.create_and_edit');
  }
  
  public function edit(Request $request, $id)
  {
    if(!Auth::check()){
      session()->flash('alert', $this::NOT_LOGGED);
      return redirect()->route('home');
    }

    if(!$this->stay_exists_and_ur_the_owner($id)){
      session()->flash('alert', $this::NOT_THE_STAY_OWNER);
      return redirect()->route('stays.list');
    }

    $stay = StaysModel::where("id", $id)->first() ?? false;
    if(!$stay){
      session()->flash('error', $this::STAY_404);
      return redirect()->route('stays.list');
    }
    if($stay->status == 'rented'){
      session()->flash('alert', $this::STAY_RENTED);
      return redirect()->route('stays.list');
    }

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
    
    StaysModel::where('id', $id)->update($validated);

    session()->flash('success', $this::STAY_UPDATED);
    
    return redirect()->route('stays.list');
  }
  
  public function creator()
  {
    $this->data->title('Create Stay');
    $this->data->set('owner', Auth::id());
    $this->data->set('editing_case', false);
    $this->data->set('form_route', route('stays.create'));
    $this->data->set('submit_button', 'Create');
    $this->data->set('page_title', 'Create Stay');
    $countries = $this->countries->getAll();
    $this->data->set('possible_countries', $countries);
    return $this->view('stays.create_and_edit');
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
      'address' => 'required',
      'country' => 'required',
      'city' => 'required'
    ]);

    $stay = StaysModel::create($validated);
    if(!$stay){
      session()->flash('error', $this::ERROR_500);
      return redirect()->route('stays.creator');
    }

    $images = $request->file('images');
    if($images)
      foreach($images as $img) {
        $image = array(
          'image_path' => $this->image->set('stays', $img),
          'stay' => $stay['id']
        );
        Stays_Images::create($image);
      }

    session()->flash('success', $this::STAY_CREATED);
    
    return redirect()->route('stays.list');
  }

  private function stay_exists_and_ur_the_owner($id)
  {
    $stay_exists = StaysModel::find($id);
    if(!$stay_exists)
      return false;
      
    $stay = $stay_exists->toArray();
    
    $belongs = $stay['owner'] == Auth::id();
    return $belongs;
  }
}
