<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ShareModal extends Component
{
    public $targetType;
    public $targetSlug;
    public function render()
    {
        return view('livewire.share-modal');
    }
}
