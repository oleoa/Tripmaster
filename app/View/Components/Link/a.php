<?php

namespace App\View\Components\Link;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class a extends Component
{
  public $text;
  public $href;
    /**
     * Create a new component instance.
     */
    public function __construct($text, $href)
    {
      $this->text = $text;
      $this->href = $href;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.link.a');
    }
}
