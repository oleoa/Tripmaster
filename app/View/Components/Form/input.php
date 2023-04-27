<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class input extends Component
{
  public $type;
  public $name;
  public $id;
  public $placeholder;

    /**
     * Create a new component instance.
     */
    public function __construct($type, $name, $placeholder = "", $id = "")
    {
      $this->type = $type;
      $this->name = $name;
      $this->id = $id;
      $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.input');
    }
}
