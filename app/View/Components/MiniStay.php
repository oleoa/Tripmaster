<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MiniStay extends Component
{
    public $stay;
    /**
     * Create a new component instance.
     */
    public function __construct($stay)
    {
      $this->stay = $stay;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.mini-stay');
    }
}
