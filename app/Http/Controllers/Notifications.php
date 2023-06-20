<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifications as NotificationsModel;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class Notifications extends Controller
{
  public function index()
  {
    $this->data->title("User Notifications");
    $notifications = NotificationsModel::where('user', Auth::id())->get();
    foreach($notifications as $notification){
      $notification->seen = true;
      $notification->save();
    }
    $this->data->set('notifications', $notifications);
    return $this->view('account.notifications');
  }

  public function delete($id)
  {
    NotificationsModel::destroy($id);
    return redirect()->back();
  }

  public function deleteAll()
  {
    NotificationsModel::where("user", Auth::id())->delete();
    return redirect()->back();
  }
}
