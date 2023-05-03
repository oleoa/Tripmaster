<?php

namespace App\View\Components\Sidebar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Sidebar extends Component
{
  public $current;
  public $logged;
    /**
     * Create a new component instance.
     */
    public function __construct($current, $logged)
    {
      $this->current = $current;
      $this->logged = $logged;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar.index');
    }
}
