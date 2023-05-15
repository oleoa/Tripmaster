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
        'href' => route('creator.stay')
      ),
      'list' => array(
        'text' => 'List Stays',
        'href' => route('my.stays')
      )
    );

    $cars = array(
      'title' => 'Stays',
      'howMany' => 'You have x stays',
      'beingUsed' => 'X stays are being used',
      'add' => array(
        'text' => 'Add Stay',
        'href' => route('creator.stay')
      ),
      'list' => array(
        'text' => 'List Stays',
        'href' => route('my.stays')
      )
    );

    $this->data->set('stays', $stays);
    $this->data->set('cars', $cars);
    
    $u = Auth::user();
    $this->data->set('id', $u->id);
    $this->data->set('name', $u->name);
    $this->data->set('email', $u->email);

    return $this->view('account');
  }
}
