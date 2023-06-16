<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;

class Account extends Controller
{
  public function index()
  {
    $this->data->title('Account');

    if(!Auth::check()){
      session()->flash('alert', $this::NOT_LOGGED);
      return redirect()->route("home");
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
      session()->flash('alert', $this::NOT_LOGGED);
      return redirect()->route("home");
    }

    $this->data->set("user", $user);
    return $this->view('account.edit');
  }

  public function edit(Request $request)
  {
    // Verify if the user is logged in
    $user = Auth::user();
    if(!$user){
      session()->flash('alert', $this::NOT_LOGGED);
      return redirect()->route("home");
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
      session()->flash('alert', $this::NOT_THE_ACCOUNT_OWNER);
      return redirect()->route("account.editor");
    }

    // Verify if the user id sent in the request exists
    $user_from_request = User::where("id", $request->input('id'))->first();
    if(!$user_from_request) {
      session()->flash('alert', $this::NOT_THE_ACCOUNT_OWNER);
      return redirect()->route("account.editor");
    }

    // Verify if the password is correct
    $user_test = array(
      'id' => $user->id,
      'password' => $validated['password'],
    );
    if(!Auth::attempt($user_test)) {
      session()->flash('alert', $this::PASSWORD_INCORRECT);
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
      session()->flash('alert', $this::NOT_LOGGED);
      return redirect()->route("home");
    }

    if($user->id != $id) {
      session()->flash('alert', $this::NOT_THE_ACCOUNT_OWNER);
      return redirect()->route("account.editor");
    }

    $user = User::where("id", $id)->first();
    if(!$user) {
      session()->flash('alert', $this::NOT_THE_ACCOUNT_OWNER);
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
