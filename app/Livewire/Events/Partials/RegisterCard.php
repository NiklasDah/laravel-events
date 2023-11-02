<?php

namespace App\Livewire\Events\Partials;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class RegisterCard extends Component
{
    public $event;

    public function enroll() {
        $this->event->enrollUser(Auth::user());
    }

    public function unenroll() {
        $this->event->unenrollUser(Auth::user());
    }

    public function confirm_attendance($enrolled) {
        $enrolled = $this->event->enrolled()->where(['event_users.user_id' => $enrolled['id']])->first();
        $enrolled->pivot->attended = true;
        $enrolled->pivot->save();
    }

    public function remove_attendance($enrolled) {
        $enrolled = $this->event->enrolled()->where(['event_users.user_id' => $enrolled['id']])->first();
        $enrolled->pivot->attended = false;
        $enrolled->pivot->save();
    }

    public function render()
    {
        return view('livewire.events.partials.register-card');
    }
}
