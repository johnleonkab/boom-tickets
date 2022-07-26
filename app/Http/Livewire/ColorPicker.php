<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ColorPicker extends Component
{
    public $defaultValue;
    public $defaultValueName;
    public function render()
    {
        return view('livewire.color-picker');
    }
}
