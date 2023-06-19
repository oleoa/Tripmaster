<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifications as NotificationsModel;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class Notifications extends Controller
{
  public function index(Request $request)
  {
    $this->data->title("User Notifications");
    $notifications = NotificationsModel::where('user', Auth::id())->get();
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
