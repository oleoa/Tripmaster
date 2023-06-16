<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Stays_Images;
use App\Models\Project;
use App\Models\Stays;
use App\Models\Rents;
use App\Models\User;

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

    $stay = Stays::where("id", $project->stay)->first() ?? false;
    if($stay) {
      $stay->image = Stays_Images::where("stay", $stay->id)->first()->image_path ?? false;
      $project['stay'] = $stay;
    }

    $this->data->set("p", $project);

    return $this->view('main');
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
    $this->data->set('countries', $countries);

    return $this->view('projects.create');
  }

  public function create(Request $request)
  {
    if(!Auth::check()){
      session()->flash('alert', $this::NOT_LOGGED);
      return redirect()->route('home');
    }

    $valideted = $request->validate([
      'country' => 'required',
      'start' => 'required',
      'end' => 'required',
      'adults' => 'required',
      'children' => 'required',
    ]);

    $project = array(
      'country' => $valideted['country'],
      'start' => $valideted['start'],
      'end' => $valideted['end'],
      'adults' => $valideted['adults'],
      'children' => $valideted['children'],
      'headcount' => $valideted['adults'] + $valideted['children'],
      'image' => $this->countries->getFlag($valideted['country']),
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
        'people' => $project_data['headcount'] == 1 ? 'person' : 'people',
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

    Project::destroy($id);
    return redirect()->back();
  }

  public function rentStay(Request $request, $id)
  {
    $valideted = $request->validate([
      'start_date' => 'required',
      'end_date' => 'required',
      'headcount' => 'required',
    ]);

    $lastProjectOpened = $this->getLastProjectOpened(Auth::id());
    if(!$lastProjectOpened){
      session()->flash('info', $this::NO_PROJECTS_YET);
      return redirect()->route('list.stays');
    }

    $project = Project::where("id", $lastProjectOpened)->first();
    if(!$project){
      session()->flash('alert', $this::PROJECT_404);
      return redirect()->route('list.stays');
    }

    $attempt = $this->project_exists_and_ur_the_owner($request, $project->id);
    if(!$attempt){
      session()->flash('alert', $this::NOT_THE_PROJECT_OWNER);
      return $attempt;
    }

    $stay = Stays::find($id);
    if(!$stay){
      session()->flash('error', $this::STAY_404);
      return redirect()->route('list.stays');
    }

    if($stay->status != 'available'){
      session()->flash('alert', $this::STAY_NOT_AVAILABLE);
      return redirect()->route('list.stays');
    }

    $stay->status = 'rented';
    $stay->save();

    $project->stay = $stay->id;
    $project->save();
    
    $rent = array(
      'project' => $project->id,
      'stay' => $stay->id,
      'user' => Auth::id(),
      'start_date' => $valideted['start_date'],
      'end_date' => $valideted['end_date'],
      'headcount' => $valideted['headcount']
    );

    $rent = Rents::create($rent);

    return redirect()->route("projects.index");
  }

  public function removeStay(Request $request, $id)
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

    $attempt = $this->project_exists_and_ur_the_owner($request, $project->id);
    if(!is_array($attempt)){
      session()->flash('alert', $this::NOT_THE_PROJECT_OWNER);
      return $attempt;
    }

    $stay = Stays::find($id);
    if(!$stay){
      session()->flash('error', $this::STAY_404);
      return redirect()->route('projects.index');
    }
    
    if($stay->status != 'rented'){
      session()->flash('alert', $this::STAY_NOT_RENTED);
      return redirect()->route('projects.index');
    }

    $stay->status = 'available';
    $stay->save();

    $project->stay = 0;
    $project->save();

    return redirect()->route("projects.index");
  }

  private function project_exists_and_ur_the_owner($id)
  {
    $project_exists = Project::find($id);
    if(!$project_exists)
      return false;

    $project = $project_exists->toArray();

    $belongs = $project['owner'] == Auth::id();

    return $belongs;
  }
}
