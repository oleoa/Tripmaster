<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stays;

class MyStaysController extends Controller
{
  public function index()
  {
    $this->data->title('Listing my Stays');
    return $this->view('my.stays.list');
  }
  
  public function creator()
  {
    $this->data->title('Create Stay');
    $this->data->set('owner', 1);
    return $this->view('my.stays.create');
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

    $stay = Stays::create($validated);

    $images = $request->file('images');
    $images_model = array();
    foreach($images as $img){
      $image_path = $img->store(/*Store place*/);
      $images_model[] = array(
        'image_path' => $image_path,
        'stay' => $stay['id']
      );
    }

    dd($validated);

    return redirect()->back();
  }
}
