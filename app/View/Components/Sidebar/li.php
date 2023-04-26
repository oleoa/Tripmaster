<?php

namespace App\View\Components\Sidebar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class li extends Component
{
  public $name;
  public $href;
  public $current;
    /**
     * Create a new component instance.
     */
    public function __construct($name, $href, $current)
    {
      $this->name = $name;
      $this->href = $href;
      $this->current = $current;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar.li');
    }
}
