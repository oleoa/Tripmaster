<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Stays;
use App\Models\User;

/**
 * @group Account management
 * This controller is responsible for managing the user account.
 */
class Account extends Controller
{
  public function index()
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

    return $this->view('account.show');
  }
  
  public function editor()
  {
    $this->data->title('Edit account');
    $this->data->set("password_min_length", env('PASSWORD_MIN_LENGTH'));
    $this->data->set("password_max_length", env('PASSWORD_MAX_LENGTH'));

    $user = Auth::user();
    if(!$user)
      return redirect()->route('home');

    $this->data->set("user", $user);
    return $this->view('account.edit');
  }

  public function edit(Request $request)
  {
    $user = Auth::user();
    if(!$user)
      return redirect()->route('home');
  
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
      'password' => 'nullable|string|min:'.env('PASSWORD_MIN_LENGTH').'|max:'.env('PASSWORD_MAX_LENGTH'),
    ]);
    
    if($user->id != $request->input('id'))
      return redirect()->route('home');

    $user = User::where("id", $user->id)->first();
    if(!$user)
      return redirect()->route('home');

    $user_test = array(
      'id' => $user->id,
      'password' => $validated['password'],
    );

    if(!Auth::attempt($user_test))
      return redirect()->route('home');

    $user->name = $validated['name'];
    $user->email = $validated['email'];      
    $user->save();

    return redirect()->route('account.index');
  }

  public function recover()
  {
    // Method to recover the password
    return redirect()->route('account.index');
  }
}
