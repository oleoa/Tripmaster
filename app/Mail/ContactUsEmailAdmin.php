<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactUsEmailAdmin extends Mailable
{
  use Queueable, SerializesModels;

  public $name;
  public $email;
  public $subject;
  public $messageTxt;

  public function __construct($name, $email, $message, $subject)
  {
    $this->name = $name;
    $this->email = $email;
    $this->messageTxt = $message;
    $this->subject = $subject;
  }

  public function build()
  {
    return $this->view('emails.contact_admin')->subject('Contact');
  }
}
