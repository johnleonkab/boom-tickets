<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ToggleSwitch extends Component
{
    public $value;
    public $name;
    public $checked;
    public $disabled;
    public $ident;
    public function render()
    {
        return view('livewire.toggle-switch');
    }
}
