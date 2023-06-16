<?php

namespace App\Http\Controllers;

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
  const NOT_LOGGED_IN = "You are not logged in";
  const NOT_THE_OWNER = "You are not the owner of that account";
  const PASSWORD_INCORRECT = "Password is incorrect";

  public function index()
  {
    $this->data->title('Account');

    if(!Auth::check()){
      session()->flash('error', $this::NOT_LOGGED_IN);
      return redirect()->route("sign.in");
    }
        
    $u = Auth::user();
    $this->data->set('id', $u->id);
    $this->data->set('name', $u->name);
    $this->data->set('email', $u->email);

    $projects_count = Project::where('owner', Auth::id())->count();
    $this->data->set('projects_count', $projects_count);

    return $this->view('account.show');
  }
  
  public function editor()
  {
    $this->data->title('Edit account');

    $this->data->set("password_min_length", env('PASSWORD_MIN_LENGTH'));
    $this->data->set("password_max_length", env('PASSWORD_MAX_LENGTH'));

    $user = Auth::user();
    if(!$user){
      session()->flash('error', $this::NOT_LOGGED_IN);
      return redirect()->route("signin");
    }

    $this->data->set("user", $user);
    return $this->view('account.edit');
  }

  public function edit(Request $request)
  {
    // Verify if the user is logged in
    $user = Auth::user();
    if(!$user){
      session()->flash('error', $this::NOT_LOGGED_IN);
      return redirect()->route("sign.in");
    }

    // Get the user from the database to edit this user
    $user = User::where("id", $user->id)->first();
  
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
      'password' => 'nullable|string|min:'.env('PASSWORD_MIN_LENGTH').'|max:'.env('PASSWORD_MAX_LENGTH'),
    ]);
    
    // Verify if the user is the owner of the account
    if($user->id != $request->input('id')) {
      session()->flash('error', $this::NOT_THE_OWNER);
      return redirect()->route("account.editor");
    }

    // Verify if the user id sent in the request exists
    $user_from_request = User::where("id", $request->input('id'))->first();
    if(!$user_from_request) {
      session()->flash('error', $this::NOT_THE_OWNER);
      return redirect()->route("account.editor");
    }

    // Verify if the password is correct
    $user_test = array(
      'id' => $user->id,
      'password' => $validated['password'],
    );
    if(!Auth::attempt($user_test)) {
      session()->flash('error', $this::PASSWORD_INCORRECT);
      return redirect()->route("account.editor");
    }

    $user->name = $validated['name'];
    $user->email = $validated['email'];      
    $user->save();

    return redirect()->route('account.index');
  }

  public function delete($id)
  {
    $user = Auth::user();
    if(!$user){
      session()->flash('error', $this::NOT_LOGGED_IN);
      return redirect()->route("sign.in");
    }

    if($user->id != $id) {
      session()->flash('error', $this::NOT_THE_OWNER);
      return redirect()->route("account.editor");
    }

    $user = User::where("id", $id)->first();
    if(!$user) {
      session()->flash('error', $this::NOT_THE_OWNER);
      return redirect()->route("account.editor");
    }

    $user->delete();
    return redirect()->route('sign.out');
  }

  public function recover()
  {
    // Method to recover the password
    return redirect()->route('account.index');
  }
}
