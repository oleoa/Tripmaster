<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Map extends Component
{
  public $lat;
  public $lon;
  public $editable;
  /**
   * Create a new component instance.
   */
  public function __construct($lat = 51.505, $lon = -0.09, $editable = false)
  {
    $this->lat = $lat;
    $this->lon = $lon;
    $this->editable = $editable;
  }

  /**
   * Get the view / contents that represent the component.
   */
  public function render(): View|Closure|string
  {
    return view('components.map');
  }
}
