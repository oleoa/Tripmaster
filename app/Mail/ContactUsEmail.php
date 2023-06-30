<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactUsEmail extends Mailable
{
  use Queueable, SerializesModels;

  public $name;

  public function __construct($name)
  {
    $this->name = $name;
  }

  public function build()
  {
    return $this->view('emails.contact')->subject('Contacted us');
  }
}
