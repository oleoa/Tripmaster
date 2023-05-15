<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountController extends Controller
{
  public function index()
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

    return $this->view('account');
  }
}
