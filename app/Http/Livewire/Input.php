<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Input extends Component
{
    public $placeholder;
    public $required;
    public $readonly;
    public $type;
    public $value;
    public $properties;
    public $name;
    public function render()
    {
        return view('livewire.input');
    }
}
