<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Message extends Component
{
  public $color;
  public $message;
  public $title;
  public $btn;
    /**
     * Create a new component instance.
     */
    public function __construct($color, $message, $title, $btn)
    {
      $this->color = $color;
      $this->message = $message;
      $this->title = $title;
      $this->btn = $btn;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.message');
    }
}
