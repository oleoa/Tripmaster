<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Stays as StaysModel;
use Illuminate\Http\Request;
use App\Models\Stay_Reviews;
use App\Models\Stays_Images;
use App\Models\StaysViews;
use App\Models\User;
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
    
    $stays = StaysModel::where("country", $project->country)->where('status', 'enabled')->get();
    for($i = 0; $i < count($stays); $i++)
      $stays[$i]->image = $this->image->get('stays/'.$stays[$i]->image);

    $this->data->set('stays', $stays);

    return $this->view('stays.index');
  }
  
  public function reviewer($id)
  {
    $this->data->title('Stay Review');

    $stay = StaysModel::where("id", $id)->first() ?? false;
    $stay->image = $this->image->get('stays/'.$stay->image);
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
      'comment' => 'required',
      'rating' => 'required'
    ]);

    $stay = StaysModel::where("id", $id)->first() ?? false;
    if(!$stay){
      session()->flash('error', $this::STAY_404);
      return redirect()->route('stays.list');
    }

    if(!in_array($validated['rating'], array(1, 2, 3, 4, 5))){
      session()->flash('error', $this::INVALID_RATING);
      return redirect()->route('stays.reviewer', $id);
    }
    
    $review = new Stay_Reviews;
    $review->title = $validated['title'];
    $review->comment = $validated['comment'];
    $review->rating = $validated['rating'];
    $review->date = Carbon::now();
    $review->stay = $id;
    $review->user = Auth::id();
    $review->save();

    session()->flash('success', $this::REVIEW_SUCCESS);
    return redirect()->route('stays.index');
  }

  public function show($id)
  {
    $this->data->title('Stay');

    $stay = StaysModel::where("id", $id)->first() ?? false;
    if(!$stay){
      session()->flash('error', $this::STAY_404);
      return redirect()->route('stays.list');
    }

    if($stay->owner != Auth::id()){
      $view = new StaysViews();
      $view->user = Auth::id();
      $view->stay = $id;
      $view->time = Carbon::now()->format('Y-m-d H:i:s');
      $view->save();
    }
    
    $stay->image = $this->image->get('stays/'.$stay->image);

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

    $reviews = Stay_Reviews::where("stay", $stay->id)->where('avaiable', true)->get()->toArray() ?? false;
    for($i = 0; $i < count($reviews); $i++)
      $reviews[$i]['user'] = User::where('id', $reviews[$i]['user'])->first()->toArray()['name'] ?? false;
    
    $stay->reviews = $reviews;

    $this->data->set('stay', $stay);

    $canReview = Rents::where("stay", $stay->id)->where("user", Auth::id())->where("status", "finished")->first() ? true : false;
    $this->data->set('canReview', $canReview);
    
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
    $this->data->set('stay', $stay);

    $views = StaysViews::where("stay", $stay->id)->get()->toArray() ?? false;
    $this->data->set('views', $views);
    $this->data->set('totalViews', count($views));

    $rents = Rents::where("stay", $stay->id)->where("status", "closed")->get()->toArray() ?? false;
    $this->data->set('rents', $rents);
    $this->data->set('totalRents', count($rents));

    $totalEarning = 0;
    foreach($rents as $rent)
      $totalEarning += $rent['price'];
    $this->data->set('totalEarnings', $totalEarning);

    return $this->view('stays.dashboard');
  }
  
  public function rent($id)
  {
    $stay = StaysModel::where("id", $id)->where('status', 'enabled')->first() ?? false;
    if(!$stay){
      session()->flash('error', $this::STAY_404);
      return redirect()->route('stays.list');
    }

    if($stay->owner == Auth::id()){
      session()->flash('error', $this::CANT_RENT_UR_OWN_STAY);
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

    $rents = Rents::where("stay", $stay->id)->get()->toArray() ?? false;
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

    $stays = StaysModel::where('owner', '=', Auth::id())->get();
    for($i = 0; $i < count($stays); $i++)
      $stays[$i]['image'] = $this->image->get('stays/'.$stays[$i]['image']);

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
      'owner' => 'required|exists:users,id',
      'title' => 'required|max:255',
      'description' => 'required',
      'capacity' => 'required|numeric|min:1',
      'bedrooms' => 'required|numeric|min:1',
      'price' => 'required|numeric',
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
      'owner' => 'required|exists:users,id',
      'title' => 'required|max:255',
      'description' => 'required',
      'capacity' => 'required|numeric|min:1',
      'bedrooms' => 'required|numeric|min:1',
      'price' => 'required|numeric',
      'address' => 'required',
      'country' => 'required',
      'lat' => 'required',
      'lon' => 'required',
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
      $stay->image = $image['image_path'];
      $stay->save();
      Stays_Images::create($image);
    }

    session()->flash('success', $this::STAY_CREATED);
    return redirect()->route('stays.list');
  }

  public function images_editor($id)
  {
    $this->data->title('Edit Stay Images');

    $stay = StaysModel::where("id", $id)->first() ?? false;
    if(!$stay){
      session()->flash('error', $this::STAY_404);
      return redirect()->route('stays.list');
    }

    $belongs = $this->stay_exists_and_ur_the_owner($id);
    if(!$belongs){
      session()->flash('alert', $this::NOT_THE_STAY_OWNER);
      return redirect()->route('stays.list');
    }

    $images = Stays_Images::where('stay', $id)->get();
    $this->data->set('images', $images);

    $this->data->set('stayId', $id);

    return $this->view('stays.images_editor');
  }

  public function image_add(Request $request)
  {
    $validated = $request->validate([
      'stay' => 'required|exists:stays,id',
      'image' => 'required'
    ]);

    $stay = StaysModel::find($validated['stay']);
    if(!$stay){
      session()->flash('error', $this::STAY_404);
      return redirect()->route('stays.list');
    }

    $belongs = $this->stay_exists_and_ur_the_owner($stay->id);
    if(!$belongs){
      session()->flash('alert', $this::NOT_THE_STAY_OWNER);
      return redirect()->route('stays.list');
    }

    foreach($validated['image'] as $img) {
      $image = array(
        'image_path' => $this->image->set('stays', $img),
        'stay' => $stay->id
      );
      Stays_Images::create($image);
    }

    session()->flash('success', $this::IMAGE_ADDED);
    return redirect()->back();
  }

  public function image_destroy($id)
  {
    $image = Stays_Images::find($id);
    if(!$image){
      session()->flash('error', $this::IMAGE_404);
      return redirect()->route('stays.list');
    }

    $stay = StaysModel::find($image->stay);
    if(!$stay){
      session()->flash('error', $this::STAY_404);
      return redirect()->route('stays.list');
    }

    $belongs = $this->stay_exists_and_ur_the_owner($stay->id);
    if(!$belongs){
      session()->flash('alert', $this::NOT_THE_STAY_OWNER);
      return redirect()->route('stays.list');
    }

    if($stay->image == $image->image_path){
      $stay->image = null;
      $stay->save();
    }

    $image->delete();

    session()->flash('info', $this::IMAGE_DELETED);
    return redirect()->back();
  }

  public function image_main(Request $request)
  {
    $validated = $request->validate([
      'stay' => 'required|exists:stays,id',
      'image' => 'required'
    ]);
    
    $stay = StaysModel::find($validated['stay']);
    if(!$stay){
      session()->flash('error', $this::STAY_404);
      return redirect()->route('stays.list');
    }

    $belongs = $this->stay_exists_and_ur_the_owner($stay->id);
    if(!$belongs){
      session()->flash('alert', $this::NOT_THE_STAY_OWNER);
      return redirect()->route('stays.list');
    }

    $stay->image = $validated['image'];
    $stay->save();

    session()->flash('success', $this::IMAGE_UPDATED);
    return redirect()->back();
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
