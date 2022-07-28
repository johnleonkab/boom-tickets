<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NotificationSurvey extends Component
{
    public $text;
    public $survey_slug;
    public function render()
    {
        return view('livewire.notification-survey');
    }
}
