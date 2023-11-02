<?php

namespace App\Livewire\Events;

use Livewire\Component;
use App\Models\Event;

class Index extends Component
{
    public $event;

    public function mount(Event $event)
    {
        $this->event = $event;
    }
    public function render()
    {
        return view('livewire.events.index');
    }
}
