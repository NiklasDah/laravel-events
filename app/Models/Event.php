<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    /** 
     * return all events available to register
     */
    public static function availableEvents() : Collection {
        if(!Auth::check()) return Event::where(['invite_only' => false, ['end', '>', \Carbon\Carbon::now()]])->get();
        return Event::where(['invite_only'=> false, ['end', '>', \Carbon\Carbon::now()]])->get();
    }

    public function attendants() {
        return $this->enrolled()->where(['confirmed' => true, 'in_queue' => false]);
    }

    public function queued() {
        return $this->enrolled()->where(['in_queue'=> true]);
    }

    public function enrolled() {
        return $this->belongsToMany(User::class, 'event_users')->withPivot('registration_number', 'confirmed', 'in_queue', 'attended');
    }

    public function started() {
        return \Carbon\Carbon::parse($this->start, 'Europe/Berlin')->subMinutes(15)->isPast();
    }

    public function enrollUser(User $user) {
        if($this->attendants->contains($user->id)) return;
        if($this->organizer->id == $user->id) return;
        if($this->attendants->count() >= $this->max_users && $this->max_users != -1) {
            return $this->attendants()->attach($user->id, ['registration_number' => Str::uuid(), 'in_queue' => true, 'confirmed' => false]);
        }
        $this->attendants()->attach($user->id, ['registration_number' => Str::uuid()]);
    }

    public function unenrollUser(User $user) {
        if($this->started()) return;
        $this->attendants()->detach($user->id);
        if($this->attendants->count() > $this->max_users && $this->max_users != -1) {
            // move first queued user from queue to event
            $queuedUser = $this->queued()->first();
            if ($queuedUser) {
                $queuedUser->update(['in_queue' => false]);
            }
        }
    }

    public function percentageFilled() {
        if($this->max_users == -1) return 0;
        if($this->max_users == 0) return 100;
        return round((($this->attendants->count() / $this->max_users) * 100),2);
    }

    public function organizer() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function isUserRegistered($user_id) {
        return $this->attendants->contains($user_id);
    }
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'user_id',
        'start',
        'end',
        'invite_only',
        'location',
        'location_type',
        'max_users'
    ];
}
