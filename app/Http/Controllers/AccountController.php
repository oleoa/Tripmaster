<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Stays;

class AccountController extends Controller
{
  public function index(Request $request)
  {
    $this->data->title('Account');
    
    $stays = Stays::where("owner", Auth::id())->get()->toArray();
    
    $stays = array(
      'title' => 'Stays',
      'howMany' => 'You have '.count($stays).' stays',
      'beingUsed' => 'X stays are being used',
      'add' => array(
        'text' => 'Add Stay',
        'href' => route('my.creator.stay')
      ),
      'list' => array(
        'text' => 'List Stays',
        'href' => route('my.list.stays')
      )
    );

    $cars = array(
      'title' => 'Cars',
      'howMany' => 'You have x cars',
      'beingUsed' => 'X cars are being used',
      'add' => array(
        'text' => 'Add Car',
        'href' => route('my.creator.stay')
      ),
      'list' => array(
        'text' => 'List Cars',
        'href' => route('my.list.stays')
      )
    );

    $this->data->set('stays', $stays);
    $this->data->set('cars', $cars);
    
    $u = Auth::user();
    $this->data->set('id', $u->id);
    $this->data->set('name', $u->name);
    $this->data->set('email', $u->email);
    $projects_count = Project::where('owner', Auth::id())->count();
    $this->data->set('projects_count', "You have ".$projects_count." projects");

    $created_at_date_time = Carbon::parse($u->created_at);
    $current_date_time = Carbon::now();
    $diff = $created_at_date_time->diff($current_date_time);
    $this->data->set('user_time_since_created', "$diff->h hour $diff->i minutes");

    return $this->view('my.account');
  }
}
