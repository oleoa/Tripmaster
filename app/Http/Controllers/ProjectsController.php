<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Classes\Project;
use App\Models\Project as ProjectModel;

class ProjectsController extends Controller
{
  private $REST_Countries = 'https://restcountries.com/v3.1/all?fields=name';

  public function creator()
  {
    $countries = $this->getCountries();
    
    $this->data->set('countries', $countries);
    $this->data->title('Create Project');
    return $this->view('projects.create');
  }

  public function create(Request $request)
  {
    $valideted = $request->validate([
      'title' => 'required',
      'country' => 'required',
      'date' => 'required',
      'headcount' => 'required',
    ]);

    $project = new Project();
    $project->title($valideted['title']);
    $project->country($valideted['country']);
    $project->date($valideted['date']);
    $project->headcount($valideted['headcount']);
    $project->owner(Auth::id());
    $info = ProjectModel::create($project->get());
    
    if(!$info){
      $request->session()->flash('status', false);
      $request->session()->flash('message', 'Something went wrong, please try again');
      return redirect()->route('creator.project');
    }

    $request->session()->flash('status', true);
    $request->session()->flash('message', 'Project created');
    return redirect()->route('my.projects');
  }
  
  public function index()
  {
    $this->data->title('Projects List');

    $user_projects = ProjectModel::where('owner', Auth::id())->get();

    $projects = array();

    foreach($user_projects as $project)
    {
      $projects[] = $project;
    }

    $this->data->set('projects', $projects);

    return $this->view('projects.list');
  }
  
  private function getCountries()
  {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $this->REST_Countries);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);
    $countries_names = array();
    foreach($data as $name)
      $countries_names[] = $name['name']['common'];
    sort($countries_names);
    return $countries_names;
  }
}
