<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UnfollowButton extends Component
{
    public $target_type;
    public $target_slug;
    public function render()
    {
        return view('livewire.unfollow-button');
    }
}
