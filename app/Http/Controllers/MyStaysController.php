<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stays_Images;
use App\Models\Stays;

class MyStaysController extends Controller
{
  public function index()
  {
    $this->data->title('Listing my Stays');

    $stays = Stays::where('owner', '=', Auth::id())->get()->toArray();
    $this->data->set('stays', $stays);

    return $this->view('my.stays.list');
  }
  
  public function creator()
  {
    $this->data->title('Create Stay');
    $this->data->set('owner', Auth::id());
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
    foreach($images as $img){
      $image_path = explode("/", $img->store('stays', 'public'))[1];
      $image = array(
        'image_path' => $image_path,
        'stay' => $stay['id']
      );
      Stays_Images::create($image);
    }

    return redirect()->route('my.list.stays');
  }
}
