<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ErrorAlert extends Component
{
    public $error;
    public function render()
    {
        return view('livewire.error-alert');
    }
}
