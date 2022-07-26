<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SuccessAlert extends Component
{
    public $success;
    public function render()
    {
        return view('livewire.success-alert');
    }
}
