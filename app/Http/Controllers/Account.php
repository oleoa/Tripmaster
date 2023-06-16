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
  public function __construct()
  {
    parent::__construct();
    
    $this->error->message("not_logged_in", "You are not logged in");
    $this->error->message("not_the_owner", "You are not the owner of that account");
    $this->error->message("password_incorrect", "Password is incorrect");
    
    $this->error->redirect('editor', 'account.editor');
    $this->error->redirect('signin', 'sign.in');
  }

  public function index()
  {
    $this->data->title('Account');

    if(!Auth::check()){
      session()->flash('error', $this->error->message('not_logged_in'));
      return redirect()->route($this->error->redirect("signin"));
    }
    
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
    $this->error->redirect('account.editor');

    $this->data->title('Edit account');
    $this->data->set("password_min_length", env('PASSWORD_MIN_LENGTH'));
    $this->data->set("password_max_length", env('PASSWORD_MAX_LENGTH'));

    $user = Auth::user();
    if(!$user){
      session()->flash('error', $this->error->message('not_logged_in'));
      return redirect()->route($this->error->redirect("signin"));
    }

    $this->data->set("user", $user);
    return $this->view('account.edit');
  }

  public function edit(Request $request)
  {
    // Verify if the user is logged in
    $user = Auth::user();
    if(!$user){
      session()->flash('error', $this->error->message('not_logged_in'));
      return redirect()->route($this->error->redirect("signin"));
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
      session()->flash('error', $this->error->message('not_the_owner'));
      return redirect()->route($this->error->redirect("editor"));
    }

    // Verify if the user id sent in the request exists
    $user_from_request = User::where("id", $request->input('id'))->first();
    if(!$user_from_request) {
      session()->flash('error', $this->error->message('not_the_owner'));
      return redirect()->route($this->error->redirect("editor"));
    }

    // Verify if the password is correct
    $user_test = array(
      'id' => $user->id,
      'password' => $validated['password'],
    );
    if(!Auth::attempt($user_test)) {
      session()->flash('error', $this->error->message('password_incorrect'));
      return redirect()->route($this->error->redirect("editor"));
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
      session()->flash('error', $this->error->message('not_logged_in'));
      return redirect()->route($this->error->redirect("signin"));
    }

    if($user->id != $id) {
      session()->flash('error', $this->error->message('not_the_owner'));
      return redirect()->route($this->error->redirect("editor"));
    }

    $user = User::where("id", $id)->first();
    if(!$user) {
      session()->flash('error', $this->error->message('not_the_owner'));
      return redirect()->route($this->error->redirect("editor"));
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
