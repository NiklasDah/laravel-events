<?php

namespace App\Livewire\Events;

use Livewire\Component;
use App\Models\Event;
use Livewire\Attributes\Rule; 

class Index extends Component
{
    public $event;

    #[Rule('required')]
    public $event_name = '';

    #[Rule('required')]
    public $description = '';

    #[Rule('string|nullable')]
    public $location = '';

    #[Rule('required|in:online,presence')]
    public $location_type = '';

    #[Rule('required|boolean')]
    public $invite_only = '';

    #[Rule('integer')]
    public $max_users = '';

    #[Rule('required|date')]
    public $start = '';

    #[Rule('required|date|after:start')]
    public $end = '';


    public function mount(Event $event)
    {
        $this->event = $event;
    
        $this->event_name = $event->name;
    
        $this->description = $event->description;
    
        $this->location = $event->location;
    
        $this->location_type = $event->location_type;
    
        $this->invite_only = $event->invite_only;
    
        $this->max_users = $event->max_users;
    
        $this->start = $event->start;
    
        $this->end = $event->end;
    }
    
    public function changeEvent() {
        try {
            $validated = $this->validate();
        } catch (ValidationException $e) {
            throw $e;
        }
    
        if($this->event->organizer->id != auth()->user()->id) return;
    
        $this->event->update([
            'name' => $validated['event_name'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'location_type' => $validated['location_type'],
            'invite_only' => $validated['invite_only'],
            'max_users' => $validated['max_users'],
            'start' => $validated['start'],
            'end' => $validated['end'],
        ]);
    
        $this->dispatch('event-updated');
        $this->dispatch('close-modal', 'edit-event');
    }
    public function render()
    {
        return view('livewire.events.index');
    }
}
