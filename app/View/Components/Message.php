<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Message extends Component
{
  public $type;
  public $message;
  public $title;
    /**
     * Create a new component instance.
     */
    public function __construct($type, $message, $title)
    {
      $this->type = $type;
      $this->message = $message;
      $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.message');
    }
}
