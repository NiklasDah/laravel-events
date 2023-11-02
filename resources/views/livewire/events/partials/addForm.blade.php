<?php

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\rules;
use function Livewire\Volt\state;

state([
    'event_name' => '',
    'description' => '',
    'location' => '',
    'location_type' => 'online',
    'invite_only' => false,
    'max_users' => -1,
    'start' => '',
    'end' => '',
]);

rules([
    'event_name' => 'required|string',
    'location' => 'string|nullable',
    'location_type' => 'required|in:online,presence',
    'description' => 'required|string',
    'invite_only' => 'required|boolean',
    'max_users' => 'integer',
    'start' => 'required|date',
    'end' => 'required|date|after:start',
]);

$addEvent = function () {
    try {
        $validated = $this->validate();
    } catch (ValidationException $e) {

        throw $e;
    }

    $event = auth()->user()->events()->create([
        'name' => $validated['event_name'],
        'description' => $validated['description'],
        'location' => $validated['location'],
        'location_type' => $validated['location_type'],
        'invite_only' => $validated['invite_only'],
        'max_users' => $validated['max_users'],
        'start' => $validated['start'],
        'end' => $validated['end'],
    ]);

    $this->dispatch('event-added');
};

?>
<section class="space-y-6 p-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Add Event') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('In order to add your Event, add it via this form.') }}
        </p>
    </header>
    
    <form wire:submit="addEvent" class="mt-6 grid grid-cols-2 gap-4">
        <div class="col-span-2">
            <x-input-label for="event_name" :value="__('Event Name')" />
            <x-text-input wire:model="event_name" id="event_name" name="event_name" type="text" class="mt-1 block w-full dark:text-gray-200 dark:bg-gray-800" />
            <x-input-error :messages="$errors->get('event_name')" class="mt-2 text-red-600" />
        </div>

        <div class="flex">
            <div class="flex items-center space-x-2 dark:text-gray-200 dark:bg-gray-800">
                <x-checkbox-input wire:model="invite_only" id="invite_only" name="invite_only" type="checkbox" class="mt-1" />
                <x-input-label for="invite_only" class="dark:text-gray-200" :value="__('Invite Only')" />
            </div>
            <x-input-error :messages="$errors->get('invite_only')" class="mt-2 text-red-600" />
        </div>
    
        <div class="col-span-2">
            <x-input-label for="description" :value="__('Description')" />
            <x-textarea-input wire:model="description" id="description" name="description" class="mt-1 block w-full dark:text-gray-200 dark:bg-gray-800" rows="4">
            </x-textarea-input>
            <x-input-error :messages="$errors->get('description')" class="mt-2 text-red-600" />
        </div>
    
        <div>
            <x-input-label for="location" :value="__('Location')" />
            <x-text-input wire:model="location" id="location" name="location" type="text" class="mt-1 block w-full dark:text-gray-200 dark:bg-gray-800" />
            <x-input-error :messages="$errors->get('location')" class="mt-2 text-red-600" />
        </div>
    
        <div>
            <x-input-label for="location_type" :value="__('Location Type')" />
            <select wire:model="location_type" id="location_type" name="location_type" class="mt-1 block w-full dark:text-gray-200 dark:bg-gray-800">
                <option value="online">Online</option>
                <option value="presence">Presence</option>
            </select>
            <x-input-error :messages="$errors->get('location_type')" class="mt-2 text-red-600" />
        </div>
    
        <div>
            <x-input-label for="max_users" :value="__('Max Users')" />
            <x-text-input wire:model="max_users" id="max_users" name="max_users" type="number" class="mt-1 block w-full dark:text-gray-200 dark:bg-gray-800" />
            <x-input-error :messages="$errors->get('max_users')" class="mt-2 text-red-600" />
        </div>
    
        <div>
            <x-input-label for="start" :value="__('Start Date and Time')" />
            <x-text-input wire:model="start" id="start" name="start" type="datetime-local" class="mt-1 block w-full dark:text-gray-200 dark:bg-gray-800" />
            <x-input-error :messages="$errors->get('start')" class="mt-2 text-red-600" />
        </div>
    
        <div>
            <x-input-label for="end" :value="__('End Date and Time')" />
            <x-text-input wire:model="end" id="end" name="end" type="datetime-local" class="mt-1 block w-full dark:text-gray-200 dark:bg-gray-800" />
            <x-input-error :messages="$errors->get('end')" class="mt-2 text-red-600" />
        </div>
    
        <div class="col-span-2">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
    
</section>
