<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Dropdown extends Component
{
    public $name;
    public $elements;
    public $idname;
    public function render()
    {
        return view('livewire.dropdown');
    }
}
