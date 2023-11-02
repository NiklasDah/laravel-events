<?php

namespace App\Livewire\Events;

use Livewire\Component;
use App\Models\Event;

class Scanner extends Component
{   
    public Event $event;

    public function processTicket($code, $override = false)
    {
        if($user = $this->event->enrolled()->where(['registration_number' => $code])->first()) {
            if($override) {
                $user->pivot->in_queue = false;
                $user->pivot->confirmed = true;
                $user->pivot->attended = true;
                $user->pivot->save();
                $this->dispatch('ticketProcessed', ['success' => true, 'message' => $user->name . ' checked in! (overriden)', 'class' => 'bg-green-500'])->self();
                return;
            }
            switch (true) {
                case ($user->pivot->confirmed && !$user->pivot->in_queue && !$user->pivot->attended):
                    $this->dispatch('ticketProcessed', ['success' => true, 'message' => $user->name . ' checked in!', 'class' => 'bg-green-500'])->self();
                    $user->pivot->attended = true;
                    $user->pivot->save();
                    break;
                
                case ($user->pivot->in_queue):
                case ($user->pivot->confirmed && $user->pivot->in_queue && !$user->pivot->attended):
                    $this->dispatch('ticketProcessed', ['success' => false, 'message' => $user->name . ' is in queue, allow skipping queue?', 'class' => 'bg-orange-500', 'followup' => true, 'registration_number' => $code])->self();
                    break;
                
                case (!$user->pivot->confirmed):
                    $this->dispatch('ticketProcessed', ['success' => false, 'message' => $user->name . ' has not confirmed the event. Ask them to do so and try again.', 'class' => 'bg-orange-500'])->self();
                    break;
                
                case ($user->pivot->attended):
                    $this->dispatch('ticketProcessed', ['success' => false, 'message' => $user->name . ' has already attended the event.', 'class' => 'bg-orange-500'])->self();
                    break;
                default:
                    $this->dispatch('ticketProcessed', ['success' => false, 'message' => 'The condition of the ticket is unclear. Please contact support with the corresponding ticket.', 'class' => 'bg-orange-500'])->self();
                    break;
            }            
        } else {
            $this->dispatch('ticketProcessed', ['success' => false, 'message' => 'Ticket not found!', 'class' => 'bg-red-500'])->self();
        }
        //$this->redirect(route('dashboard'));
    }


    public function render()
    {
        return view('livewire.events.scanner');
    }
}
