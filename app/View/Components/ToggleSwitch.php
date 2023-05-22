<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ToggleSwitch extends Component
{
  public $name;
  public $isChecked;
    /**
     * Create a new component instance.
     */
    public function __construct($name, $isChecked = true)
    {
      $this->name = $name;
      $this->isChecked = $isChecked;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.toggle-switch');
    }
}
