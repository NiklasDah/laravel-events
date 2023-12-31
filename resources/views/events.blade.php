@if(auth()->user())
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <livewire:events.partials.list_component :events="App\Models\Event::availableEvents()" />
                </div>
                @if(auth()->user() && auth()->user()->isOrganizer())
                    <livewire:events.partials.addForm />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
@else
<x-guestview-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <livewire:events.partials.list_component :events="App\Models\Event::availableEvents()" />
                </div>
                @if(auth()->user() && auth()->user()->isOrganizer())
                    <livewire:events.partials.addForm />
                @endif
            </div>
        </div>
    </div>
</x-guestview-layout>
@endif