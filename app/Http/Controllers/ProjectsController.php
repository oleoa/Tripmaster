<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectsController extends Controller
{
  private $REST_Countries = 'https://restcountries.com/v3.1/all?fields=name';

  public function creator()
  {
    $this->data->title('Create Project');

    $countries = $this->getCountries();
    
    $this->data->set('selected', "France");
    $this->data->set('countries', $countries);

    return $this->view('projects.create');
  }

  public function create(Request $request)
  {
    $valideted = $request->validate([
      'title' => 'required',
      'country' => 'required',
      'start' => 'required',
      'end' => 'required',
      'adults' => 'required',
      'children' => 'required',
    ]);

    $project = array(
      'title' => $valideted['title'],
      'country' => $valideted['country'],
      'start' => $valideted['start'],
      'end' => $valideted['end'],
      'adults' => $valideted['adults'],
      'children' => $valideted['children'],
      'headcount' => $valideted['adults'] + $valideted['children'],
      'image' => $valideted['country'],
      'isFlag' => true,
      'owner' => Auth::id()
    );
    $info = Project::create($project);
    
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

    foreach($user_projects as $project_data)
    {
      $project = new Project();
      $project->title($project_data['title']);
      $project->country($project_data['country']);
      $project->date($project_data['date']);
      $project->image($project_data['image']);
      $project->headcount($project_data['headcount']);
      $projects[] = $project;
    }

    $this->data->set('projects', $projects);

    return $this->view('projects.list');
  }

  private function getFlag($country): string
  {
    $flag = "https://restcountries.com/v3.1/name/$country?fields=flags";
    $data = $this->doCurlURL($flag);
    $svg = $data[0]['flags']['svg'];
    return $svg;
  }

  private function doCurlURL($url)
  {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response, true);
    return $data;
  }
  
  private function getCountries(): array
  {
    $data = $this->doCurlURL($this->REST_Countries);
    $countries_names = array();
    foreach($data as $name)
      $countries_names[] = $name['name']['common'];
    sort($countries_names);
    return $countries_names;
  }
}
