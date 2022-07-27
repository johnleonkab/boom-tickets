<?php

namespace App\Http\Livewire;

use Livewire\Component;

class FollowButton extends Component
{
    public $target_type;
    public $target_slug;
    public function render()
    {
        return view('livewire.follow-button');
    }
}
