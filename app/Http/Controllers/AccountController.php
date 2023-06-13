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
    
    $u = Auth::user();
    $this->data->set('id', $u->id);
    $this->data->set('name', $u->name);
    $this->data->set('email', $u->email);

    $projects_count = Project::where('owner', Auth::id())->count();
    $this->data->set('projects_count', $projects_count);

    /*
      $created_at_date_time = Carbon::parse($u->created_at);
      $current_date_time = Carbon::now();
      $diff = $created_at_date_time->diff($current_date_time);
      $this->data->set('utsc', $diff);
    */

    return $this->view('my.account');
  }
}
