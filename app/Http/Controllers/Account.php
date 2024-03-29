<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Mail\PasswordChangeVerificationEmail;
use App\Models\Notifications;
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
    $u->image = $this->image->get('users/'.$u->image);
    $this->data->set('user', $u);

    $projects_count = Project::where('owner', Auth::id())->count();
    $this->data->set('projects_count', $projects_count);

    $notifications = Notifications::where('user', Auth::id())->where("seen", false)->get();
    $this->data->set("hasNewNotifications", $notifications != null && count($notifications) > 0);
    $this->data->set("newNotificationsCount", count($notifications));

    return $this->view('account.show');
  }
  
  public function manage()
  {
    $this->data->title('Manage account');

    $user = Auth::user();
    if(!$user){
      session()->flash('alert', $this::NOT_LOGGED);
      return redirect()->route("home");
    }

    $this->data->set("user", $user);
    return $this->view('account.manage');
  }

  public function recover_password_anonymously()
  {
    $this->data->title('Recover password');

    return $this->view('account.recover_password_anonymously');
  }

  public function recover_password_anonymously_send(Request $request)
  {
    $validated = $request->validate([
      'email' => 'required|string|email|max:255',
    ]);

    $user = User::where('email', $validated['email'])->first();
    if(!$user){
      session()->flash('alert', $this::EMAIL_NOT_FOUND);
      return redirect()->route("recover.password.anonymously");
    }

    $verificationToken = Str::random(40);
    $user->password_verification_token = $verificationToken;
    $user->save();

    $verificationLink = route('verification.password.anonymously', ['token' => $verificationToken]);
    Mail::to($user->email)->send(new PasswordChangeVerificationEmail($verificationLink));

    session()->flash('info', $this::PASSWORD_RESET_EMAIL_SENT);
    return redirect()->route('home');
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

    $user->image = $this->image->get('users/'.$user->image);

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
      'id' => 'required|integer',
      'name' => 'required|string|max:255',
      'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
      'password' => 'nullable|string|min:'.env('PASSWORD_MIN_LENGTH').'|max:'.env('PASSWORD_MAX_LENGTH'),
    ]);
    
    // Verify if the user is the owner of the account
    if($user->id != $validated['id']) {
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
    $user->image = $validated['image'] ? $this->image->set('users', $validated['image']) : $user->image;
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

    $user = User::where("id", $user->id)->first();
    if(!$user) {
      session()->flash('alert', $this::NOT_THE_ACCOUNT_OWNER);
      return redirect()->route("account.editor");
    }

    $user->delete();
    
    session()->flash('info', $this::ACCOUNT_DELETED);
    return redirect()->route('sign.out');
  }

  public function password_editor()
  {
    $this->data->title('Change password');

    $this->data->set("id", Auth::id());
    $this->data->set("password_min_length", env('PASSWORD_MIN_LENGTH'));
    $this->data->set("password_max_length", env('PASSWORD_MAX_LENGTH'));

    return $this->view('account.password');
  }

  public function password_editor_anonymously()
  {
    $this->data->title('Change password');

    $user = session()->get('user');
    $this->data->set("id", $user->id);

    $this->data->set("password_min_length", env('PASSWORD_MIN_LENGTH'));
    $this->data->set("password_max_length", env('PASSWORD_MAX_LENGTH'));

    return $this->view('account.password_anonymously');
  }

  public function password_edit_anonymously(Request $request)
  {
    $validated = $request->validate([
      'id' => 'required|integer',
      'password' => 'nullable|string|min:'.env('PASSWORD_MIN_LENGTH').'|max:'.env('PASSWORD_MAX_LENGTH').'|confirmed',
    ]);

    // Get the user from the database to edit this user
    $user = User::where("id", $validated['id'])->first();
    if(!$user){
      session()->flash('alert', $this::NOT_THE_ACCOUNT_OWNER);
      return redirect()->route("account.editor");
    }

    $user->password = Hash::make($validated['password']);
    $user->password_verification_token = null;
    $user->save();

    session()->flash('info', $this::PASSWORD_CHANGED);
    return redirect()->route('account.index');
  }

  public function password_edit(Request $request)
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
      'id' => 'required|integer',
      'password' => 'nullable|string|min:'.env('PASSWORD_MIN_LENGTH').'|max:'.env('PASSWORD_MAX_LENGTH').'|confirmed',
    ]);
    
    // Verify if the user is the owner of the account
    if($user->id != $validated['id']){
      session()->flash('alert', $this::NOT_THE_ACCOUNT_OWNER);
      return redirect()->route("account.editor");
    }

    // Verify if the user id sent in the request exists
    $user_from_request = User::where("id", $validated['id'])->first();
    if(!$user_from_request){
      session()->flash('alert', $this::NOT_THE_ACCOUNT_OWNER);
      return redirect()->route("account.editor");
    }

    $user->password = Hash::make($validated['password']);
    $user->password_verification_token = null;
    $user->save();

    session()->flash('info', $this::PASSWORD_CHANGED);
    return redirect()->route('sign.out');
  }

  public function recover_password()
  {
    $verificationToken = Str::random(40);

    $userId = Auth::id();

    $user = User::where('id', $userId)->first();
    $user->password_verification_token = $verificationToken;
    $user->save();

    $verificationLink = route('verification.password', ['token' => $verificationToken]);
    Mail::to($user->email)->send(new PasswordChangeVerificationEmail($verificationLink));

    session()->flash('info', $this::PASSWORD_RESET_EMAIL_SENT);
    return redirect()->route('account.index');
  }
}
