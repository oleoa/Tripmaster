<?php

namespace App\View\Components\Account;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Item extends Component
{
  public $itemData;
  /**
     * Create a new component instance.
     */
    public function __construct($itemData)
    {
      $this->itemData = $itemData;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
      return view('components.account.item');
    }
}
