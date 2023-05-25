<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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

  public function delete($id)
  {
    // Verificar se apenas o dono ou um admin está a deletar essa stay
    Stays::destroy($id);
    return redirect()->back();
  }
  
  public function editor($id)
  {
    /**
     * Verify:
     * If the stay exists
     * If you are the owner of the stay or an admin
     */

    $this->data->title('Edit Stay');

    $this->data->set('owner', Auth::id());

    $stay = Stays::find($id)->first()->toArray();

    $this->data->set('page_title', 'Edit Stay');
    $this->data->set('submit_button', 'Update');
    $this->data->set('form_route', route('my.edit.stay', ['id' => $id]));
    $this->data->set('editing_case', true);
    $this->data->set('stay', $stay);

    return $this->view('my.stays.create_and_edit');
  }
  
  public function creator()
  {
    $this->data->title('Create Stay');
    $this->data->set('owner', Auth::id());
    $this->data->set('editing_case', false);
    $this->data->set('form_route', route('my.create.stay'));
    $this->data->set('submit_button', 'Create');
    $this->data->set('page_title', 'Create Stay');
    return $this->view('my.stays.create_and_edit');
  }
  
  public function edit(Request $request, $id)
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

    $saved_stay = Stays::where('id', $id)->update($validated);

    return redirect()->route('my.list.stays');
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
