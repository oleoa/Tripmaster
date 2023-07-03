<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Notifications;
use Illuminate\Http\Request;
use App\Models\Stays_Images;
use App\Models\Project;
use App\Models\Stays;
use App\Models\Rents;
use App\Models\User;
use Carbon\Carbon;

class Projects extends Controller
{
  public function index()
  {
    $this->data->title('Project');

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
    
    if($project->closed){
      session()->flash('alert', $this::PROJECT_CLOSED);
      return redirect()->route('projects.create');
    }
    
    $rents = Rents::where("project", $project->id)->get() ?? false;
    $project->stays = array();
    if($rents){
      $stays = array();
      foreach($rents as $rent){
        $stay = Stays::where("id", $rent->stay)->first() ?? false;

        $img_path = Stays_Images::where("stay", $stay->id)->first()->image_path ?? false;
        $stay->image = $this->image->get('stays/'.$img_path);

        $stay->start = $rent->start_date;
        $stay->end = $rent->end_date;
        $stay->headcount = $rent->headcount;
        
        $stays[] = $stay;
      }
      $project->rents = $stays;
    }
    
    $this->data->set("project", $project);

    return $this->view('main');
  }

  public function close($id)
  {
    $project = Project::where("id", $id)->first() ?? false;
    if(!$project){
      session()->flash('alert', $this::PROJECT_404);
      return redirect()->route('projects.creator');
    }

    $belongs = $this->project_exists_and_ur_the_owner($id);
    if(!$belongs){
      session()->flash('alert', $this::NOT_THE_PROJECT_OWNER);
      return redirect()->route('projects.index');
    }

    $user = User::where("id", Auth::id())->first() ?? false;
    if(!$user){
      session()->flash('alert', $this::NOT_LOGGED);
      return redirect()->route('projects.creator');
    }

    if($user->money < $project->cost){
      session()->flash('alert', $this::NOT_ENOUGH_MONEY);
      return redirect()->route('projects.payment');
    }

    $rents = Rents::where("project", $project->id)->get();
    foreach($rents as $r){
      $r->status = 'closed';
      $r->save();
      $stay_owner = Stays::where("id", $r->stay)->first()->toArray()['owner'] ?? false;
      $owner_user = User::where("id", $stay_owner)->first() ?? false;
      $owner_user->money += $r->price;
      $owner_user->save();
    }

    $user->money -= $project->cost;
    $user->lastProjectOpened = null;
    $user->save();

    $project->closed = true;
    $project->save();

    session()->flash('success', $this::PROJECT_CLOSED);
    return redirect()->route('projects.list');
  }
  
  public function payment()
  {
    $this->data->title('Project Payment');

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

    $belongs = $this->project_exists_and_ur_the_owner($lastProjectOpened);
    if(!$belongs){
      session()->flash('alert', $this::NOT_THE_PROJECT_OWNER);
      return redirect()->route('projects.index');
    }

    $stay = Stays::where("id", $project->stay)->first() ?? false;
    if($stay) {
      $stay->image = Stays_Images::where("stay", $stay->id)->first()->image_path ?? false;
      $project->stay = $stay;
    }

    $this->data->set("user", Auth::user());
    $this->data->set("project", $project);
    $this->data->set("remaining", Auth::user()->money - $project->cost);

    return $this->view('projects.payment');
  }

  public function creator()
  {
    $this->data->title('Create Project');

    if(!Auth::check()){
      session()->flash('alert', $this::NOT_LOGGED);
      return redirect()->route('home');
    }

    $countries = $this->countries->getAll();
    
    $this->data->set('selected', "France");
    $this->data->set('pageTitle', "Create Project");
    $this->data->set('pageActionButton', "Create");
    $this->data->set('minStart', now()->format('Y-m-d'));
    $this->data->set('minEnd', Carbon::parse(now()->format('Y-m-d'))->addDays(1)->format('Y-m-d'));
    $this->data->set('route', route('projects.create'));
    $this->data->set('countries', $countries);

    return $this->view('projects.create_and_edit');
  }

  public function create(Request $request)
  {
    $valideted = $request->validate([
      'country' => 'required',
      'start' => array(
        'required',
        'date',
        'after_or_equal:'.now()->format('Y-m-d')
      ),
      'end' => array(
        'required',
        'date',
        'after_or_equal:'.now()->format('Y-m-d')
      ),
      'adults' => 'required|numeric|min:0',
      'children' => 'required|numeric|min:0',
    ]);

    // The FullCalendar API is returning one more day after the end for some reason, so we have to substract one day
    // If they correct this, we have to remove this line
    $valideted['end'] = Carbon::parse($valideted['end'])->subDays(1)->format('Y-m-d');

    if($valideted['adults'] == 0 && $valideted['children'] == 0){
      session()->flash('alert', $this::NO_PEOPLE);
      return redirect()->route('projects.creator');
    }

    $start = Carbon::parse($valideted['start']);
    $end = Carbon::parse($valideted['end']);
    if($start->greaterThan($end)){
      session()->flash('alert', $this::START_DATE_AFTER_END_DATE);
      return redirect()->route('projects.creator');
    }

    // Save the image or get it from the storage
    $image = $this->countries->getFlag($valideted['country']);

    $project = array(
      'country' => $valideted['country'],
      'start' => $valideted['start'],
      'end' => $valideted['end'],
      'adults' => $valideted['adults'],
      'children' => $valideted['children'],
      'headcount' => $valideted['adults'] + $valideted['children'],
      'image' => $image,
      'owner' => Auth::id()
    );
    
    $info = Project::create($project);
    
    if(!$info){
      session()->flash('error', $this::ERROR_500);
      return redirect()->route('project.creator');
    }

    session()->flash('success', $this::PROJECT_CREATED);
    return redirect()->route('projects.list');
  }
  
  public function list()
  {
    $this->data->title('Projects List');

    if(!Auth::check()){
      session()->flash('alert', $this::NOT_LOGGED);
      return redirect()->route('home');
    }

    $user_projects = Project::where('owner', Auth::id())->get();
    foreach($user_projects as $p)
    {
      if(!$p->finished && $p->closed == true && $p->end <= now()->format('Y-m-d')){
        $p->finished = true;
        $p->save();
        $rents = Rents::where("project", $p->id)->get();
        foreach($rents as $r){
          $r->status = 'finished';
          $r->save();
        }
      }
    }

    $projects = array();    
    foreach($user_projects as $project_data)
    {
      $project = array(
        'id' => $project_data['id'],
        'country' => $project_data['country'],
        'start' => date("F", mktime(0, 0, 0, explode('-', $project_data['start'])[1], 1)).' '.explode('-', $project_data['start'])[2],
        'end' => date("F", mktime(0, 0, 0, explode('-', $project_data['end'])[1], 1)).' '.explode('-', $project_data['end'])[2],
        'image' => $project_data['image'],
        'headcount' => $project_data['headcount'],
        'closed' => $project_data['closed'],
        'finished' => $project_data['finished'],
        'cost' => $project_data['cost'],
        'people' => $project_data['headcount'] == 1 ? 'person goes' : 'people goes',
      );

      $projects[] = $project;
    }
    
    $this->data->set('projects', $projects);

    return $this->view('projects.list');
  }

  public function set($id)
  {
    if(!Auth::check()){
      session()->flash('alert', $this::NOT_LOGGED);
      return redirect()->route('home');
    }

    $attempt = $this->project_exists_and_ur_the_owner($id);
    if(!$attempt){
      session()->flash('alert', $this::NOT_THE_PROJECT_OWNER);
      return redirect()->route('projects.list');
    }

    $project = Project::find($id);
    if(!$project){
      session()->flash('alert', $this::PROJECT_404);
      return redirect()->route('projects.list');
    }    
    
    if($project->closed){
      session()->flash('alert', $this::PROJECT_CLOSED);
      return redirect()->route('projects.list');
    }

    User::where("id", Auth::id())->update(['lastProjectOpened' => $id]);
    return redirect()->route("projects.index");
  }
  
  public function delete($id)
  {
    if(!Auth::check()){
      session()->flash('alert', $this::NOT_LOGGED);
      return redirect()->route('home');
    }

    $attempt = $this->project_exists_and_ur_the_owner($id);
    if(!$attempt){
      session()->flash('alert', $this::NOT_THE_PROJECT_OWNER);
      return redirect()->route('projects.list');
    }

    $project = Project::where("id", $id)->first();
    if(!$project){
      session()->flash('alert', $this::PROJECT_404);
      return redirect()->route('projects.list');
    }

    if($project->closed){
      session()->flash('alert', $this::PROJECT_CLOSED);
      return redirect()->route('projects.list');
    }

    Project::destroy($id);
    session()->flash('info', $this::PROJECT_DELETED);
    return redirect()->back();
  }

  public function rentStay(Request $request, $id)
  {
    $valideted = $request->validate([
      'start_date' => 'required',
      'end_date' => 'required',
      'headcount' => 'required|numeric|min:1|max:'.Stays::find($id)->capacity,
    ]);

    $start = Carbon::parse($valideted['start_date']);
    $end = Carbon::parse($valideted['end_date']);
    if($start->greaterThan($end)){
      session()->flash('alert', $this::START_DATE_AFTER_END_DATE);
      return redirect()->back();
    }

    $lastProjectOpened = $this->getLastProjectOpened(Auth::id());
    if(!$lastProjectOpened){
      session()->flash('info', $this::NO_PROJECTS_YET);
      return redirect()->route('stays.list');
    }

    $project = Project::where("id", $lastProjectOpened)->first();
    if(!$project){
      session()->flash('alert', $this::PROJECT_404);
      return redirect()->route('stays.list');
    }
    
    if($project->closed){
      session()->flash('alert', $this::PROJECT_CLOSED);
      return redirect()->route('projects.list');
    }

    if($valideted['headcount'] > $project->headcount){
      session()->flash('alert', $this::STAY_HEADCOUNT_GREATER_THAN_PROJECT_HEADCOUNT);
      return redirect()->back();
    }

    $attempt = $this->project_exists_and_ur_the_owner($project->id);
    if(!$attempt){
      session()->flash('alert', $this::NOT_THE_PROJECT_OWNER);
      return redirect()->route('projects.index');
    }

    $stay = Stays::find($id);
    if(!$stay){
      session()->flash('error', $this::STAY_404);
      return redirect()->route('stays.index');
    }

    $start = $valideted['start_date'];
    $end = $valideted['end_date'];
    
    $rent = Rents::where(function ($query) use ($start, $end) {
      $query->whereBetween('start_date', [$start, $end])->orWhereBetween('end_date', [$start, $end]);
    })->first();

    if($rent != null){
      session()->flash('alert', $this::STAY_NOT_AVAILABLE);
      return redirect()->route('stays.index');
    }

    $days = Carbon::parse($valideted['start_date'])->diffInDays(Carbon::parse($valideted['end_date']));
    $cost = $stay->price * $days;

    $project->cost += $cost;
    $project->save();

    $user = User::find(Auth::id());

    $notification = array(
      'user' => $stay->owner,
      'title' => $this::YOUR_STAY_WAS_RENTED,
      'body' => "Your stay '".$stay->title."' was rented by '".$user->name."' from ".$valideted['start_date']." to ".$valideted['end_date'].".",
      'date' => Carbon::now(),
    );

    Notifications::create($notification);
    
    $rent = array(
      'project' => $project->id,
      'stay' => $stay->id,
      'user' => Auth::id(),
      'start_date' => $valideted['start_date'],
      'end_date' => $valideted['end_date'],
      'status' => 'pending', // 'pending', 'accepted', 'rejected', 'closed', 'finished
      'price' => $cost,
      'headcount' => $valideted['headcount']
    );

    $rent = Rents::create($rent);

    return redirect()->route("projects.index");
  }

  public function removeStay($id)
  {
    $lastProjectOpened = $this->getLastProjectOpened(Auth::id());
    if(!$lastProjectOpened){
      session()->flash('info', $this::NO_PROJECTS_YET);
      return redirect()->route('projects.index');
    }
      
    $project = Project::where("id", $lastProjectOpened)->first();
    if(!$project){
      session()->flash('alert', $this::PROJECT_404);
      return redirect()->route('projects.index');
    }

    if($project->closed){
      session()->flash('alert', $this::PROJECT_CLOSED);
      return redirect()->route('projects.list');
    }

    $attempt = $this->project_exists_and_ur_the_owner($project->id);
    if(!$attempt){
      session()->flash('alert', $this::NOT_THE_PROJECT_OWNER);
      return redirect()->route('projects.index');
    }

    $stay = Stays::find($id);
    if(!$stay){
      session()->flash('error', $this::STAY_404);
      return redirect()->route('projects.index');
    }

    $rent = Rents::where("stay", $stay->id)->where("project", $project->id)->first();
    if(!$rent){
      session()->flash('alert', $this::RENT_404);
      return redirect()->route('projects.index');
    }
    
    if($stay->status != 'rented'){
      session()->flash('alert', $this::STAY_NOT_RENTED);
      return redirect()->route('projects.index');
    }
    
    $days = Carbon::parse($rent->start_date)->diffInDays(Carbon::parse($rent->end_date));
    $cost = $stay->price * $days;
    $project->cost -= $cost;
    $project->save();

    $rent->delete();

    $stay->status = 'available';
    $stay->save();

    return redirect()->route("projects.index");
  }

  private function project_exists_and_ur_the_owner($id)
  {
    $project = Project::where("id", $id);
    if(!$project->exists())
      return false;

    $owner = $project->first()->owner;

    return $owner == Auth::id();
  }

  public function editor($id)
  {
    $this->data->title('Project Editor');
    
    $project = Project::where("id", $id)->where('owner', Auth::id())->first() ?? false;
    if(!$project){
      session()->flash('alert', $this::NOT_THE_PROJECT_OWNER);
      return redirect()->route('projects.list');
    }
    
    $countries = $this->countries->getAll();
    $this->data->set('countries', $countries);
    $this->data->set('selected', $project->country);

    $this->data->set('project', $project);

    $this->data->set('route', route('projects.edit', ['id' => $id]));
    
    $this->data->set('minStart', now()->format('Y-m-d'));
    $this->data->set('minEnd', Carbon::parse(now()->format('Y-m-d'))->addDays(1)->format('Y-m-d'));

    $this->data->set('pageTitle', "Edit Project");
    $this->data->set('pageActionButton', "Update");

    return $this->view('projects.create_and_edit');
  }

  public function edit(Request $request, $id)
  {
    $valideted = $request->validate([
      'country' => 'required',
      'start' => array(
        'required',
        'date',
        'after_or_equal:'.now()->format('Y-m-d')
      ),
      'end' => array(
        'required',
        'date',
        'after_or_equal:'.now()->format('Y-m-d')
      ),
      'adults' => 'required|numeric|min:0',
      'children' => 'required|numeric|min:0',
    ]);

    $project = Project::where("id", $id)->where('owner', Auth::id())->first() ?? false;
    if(!$project){
      session()->flash('alert', $this::NOT_THE_PROJECT_OWNER);
      return redirect()->route('projects.list');
    }

    // The FullCalendar API is returning one more day after the end for some reason, so we have to substract one day
    // If they correct this, we have to remove this line
    $valideted['end'] = Carbon::parse($valideted['end'])->subDays(1)->format('Y-m-d');

    if($valideted['adults'] == 0 && $valideted['children'] == 0){
      session()->flash('alert', $this::NO_PEOPLE);
      return redirect()->route('projects.creator');
    }

    $start = Carbon::parse($valideted['start']);
    $end = Carbon::parse($valideted['end']);
    if($start->greaterThan($end)){
      session()->flash('alert', $this::START_DATE_AFTER_END_DATE);
      return redirect()->route('projects.creator');
    }

    // Save the image or get it from the storage
    $image = $this->countries->getFlag($valideted['country']);
    
    $project->country = $valideted['country'];
    $project->start = $valideted['start'];
    $project->end = $valideted['end'];
    $project->adults = $valideted['adults'];
    $project->children = $valideted['children'];
    $project->headcount = $valideted['adults'] + $valideted['children'];
    $project->image = $image;
    $project->save();

    session()->flash('success', $this::PROJECT_UPDATED);
    return redirect()->route('projects.list');
  }
}
