<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Event :event_name', ['event_name' => $event->name]) }}
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="bg-gradient-to-r from-blue-400 to-purple-500 text-white p-4 rounded-t-lg">
                <h1 class="text-2xl font-semibold">{{ $event->name }}
                    @if($event->organizer == auth()->user())
                    <svg x-on:click.prevent="$dispatch('open-modal', 'edit-event')" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="w-4 h-4 inline cursor-pointer">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    <x-modal name="edit-event" :show="false">
                        <div class="p-8">
                            <form wire:submit="changeEvent" class="mt-6 grid grid-cols-2 gap-4">
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
                                    <select disabled wire:model="location_type" id="location_type" name="location_type" class="mt-1 block w-full dark:text-gray-200 dark:bg-gray-800">
                                        <option value="online">Online</option>
                                        <option value="presence">Presence</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('location_type')" class="mt-2 text-red-600" />
                                </div>
                            
                                <div>
                                    <x-input-label for="max_users" :value="__('Max Users')" />
                                    <x-text-input disabled wire:model="max_users" id="max_users" name="max_users" type="number" class="mt-1 block w-full dark:text-gray-200 dark:bg-gray-800" />
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
                        </div>
                    </x-modal>
                    @endif
                </h1>             
                <p>{{ __($event->location_type." event") }}
                    @if($event->location_type != 'online')
                        ({{ $event->location }})
                    @endif
                </p>
                </div>
            <div class="p-6 text-gray-900 dark:text-gray-100 grid md:grid-cols-6 grid-cols-1 gap-6">
                <div class="md:col-span-3" wire:poll>
                    <p class="mb-2">
                        {{ __("Description") }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-300 pb-6">
                        {{ $event->description }}
                    </p>
                    <x-progress-bar :percentage="$event->percentageFilled()" />
                    @if($event->max_users == -1) 
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __("Unlimited attendants allowed") }}</p>
                    @elseif($event->queued->count() > 0)
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __(":attendants of a maximum of :max_users are attending, :queued in queue", ['attendants' => $event->attendants->count(), 'max_users' => $event->max_users, 'queued' => $event->queued->count()]) }}</p>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __(":attendants of a maximum of :max_users are attending", ['attendants' => $event->attendants->count(), 'max_users' => $event->max_users]) }}</p>
                    @endif
                </div>
                <div class="md:col-span-2">
                    <livewire:events.partials.register-card :event="$event" />
                </div>
                <a class="group block flex-shrink-0 items-center flex-col" href="mailto:{{ $event->organizer->email }}" >
                    <p class="mb-2">
                        {{ __("Organizer") }}
                    </p>
                    <div class="flex items-center bg-gray-200 dark:bg-gray-900 p-3 rounded m-auto">
                        <div>
                            <img class="inline-block h-9 w-9 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" />
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium dark:text-gray-300 dark:group-hover:text-gray-100 text-gray-700 group-hover:text-gray-900">{{ $event->organizer->name }}</p>
                            <p class="text-xs font-medium dark:text-gray-500 dark:group-hover:text-gray-300 text-gray-500 group-hover:text-gray-700">{{ $event->organizer->email }}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>