<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
  
  public function index()
  {
    $this->data->title('Projects List');
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
