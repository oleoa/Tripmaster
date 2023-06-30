<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsEmail;
use Illuminate\Http\Request;
use App\Models\Contact_us;

class Contact extends Controller
{
  public function index()
  {
    $this->data->title('Contact us');
    return $this->view('contact');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required',
      'email' => 'required|email',
      'subject' => 'required',
      'phone' => 'required|numeric',
      'message' => 'required',
    ]);

    $data = array(
      'name' => $validated['name'],
      'email' => $validated['email'],
      'message' => $validated['message'],
      'subject' => $validated['subject'],
      'phone' => $validated['phone']
    );

    Contact_us::create($data);

    Mail::to($data['email'])->send(new ContactUsEmail($data['name']));

    return redirect()->route('home')->with('success', 'Thank you for your message. We will get back to you soon.');
  }
}
