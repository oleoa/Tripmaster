<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AccountController extends Controller
{
  public function index(Request $request)
  {
    $this->data->title('Account');

    $stays = array(
      'title' => 'Stays',
      'howMany' => 'You have x stays',
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

    return $this->view('my.account');
  }
}
