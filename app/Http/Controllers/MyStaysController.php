<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stays;

class MyStaysController extends Controller
{
  public function index()
  {
    $this->data->title('Listing my Stays');
    return $this->view('stays.create');
  }
  
  public function creator()
  {
    $this->data->title('Create Stay');
    $this->data->set('owner', 1);
    return $this->view('stays.create');
  }
  
  public function create(Request $request)
  {
    $validated = $request->validate([
      'owner' => 'required',
      'title' => 'required',
      'description' => 'required',
      'capacity' => 'required',
      'bedrooms' => 'required',
      'price' => 'required',
      'country' => 'required',
      'city' => 'required'
    ]);

    return redirect()->back();
  }
}
