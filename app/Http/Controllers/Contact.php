<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\ContactUsEmail;
use Illuminate\Http\Request;
use App\Models\Contact_us;

class Contact extends Controller
{
  public function index()
  {
    $this->data->title('Contact us');
    $user = Auth::user();
    $this->data->set('user', $user);
    return $this->view('contact');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required',
      'email' => 'required|email',
      'subject' => 'required',
      'message' => 'required',
    ]);

    $data = array(
      'name' => $validated['name'],
      'email' => $validated['email'],
      'message' => $validated['message'],
      'subject' => $validated['subject']
    );

    Contact_us::create($data);

    Mail::to($data['email'])->send(new ContactUsEmail($data['name']));

    return redirect()->route('home')->with('success', $this::CONTACT_US_SUCCESS_MESSAGE);
  }
}
