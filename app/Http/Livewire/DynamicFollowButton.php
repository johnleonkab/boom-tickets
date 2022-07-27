<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DynamicFollowButton extends Component
{
    public $containerId;
    public $targetType;
    public $targetId;
    public $targetSlug;
    public function render()
    {
        return view('livewire.dynamic-follow-button');
    }
}
