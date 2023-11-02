<?php

namespace App\Livewire\Events\Partials;

use Livewire\Component;
use Livewire\WithPagination;

class ListComponent extends Component
{
    public $events;

    public function render()
    {
        return view('livewire.events.partials.list');
    }
}
