<ul role="list" class="divide-y divide-gray-200 dark:divide-gray-800 rounded" wire:poll>
    @foreach($events as $event)
    <li class="relative flex justify-between gap-x-6 px-4 py-5 dark:hover:bg-gray-600 hover:bg-gray-400 dark:bg-gray-900 sm:px-6 lg:px-8 rounded">
        <div class="flex min-w-0 gap-x-4">
          <div class="min-w-0 flex-auto">
            <p class="text-sm font-semibold leading-6 text-gray-8000 dark:text-gray-200">
              <a href="{{ route('event.index', $event) }}">
                <span class="absolute inset-x-0 -top-px bottom-0"></span>
                {{ $event->name }} 
                @if(auth()->user() && $event->user_id == auth()->user()->id)
                    ({{ __("You are the organizer") }})
                @elseif(auth()->user() && $event->isUserRegistered(auth()->user()))
                    ({{ __("You are registered") }})
                @endif
              </a>
            </p>
            <p class="mt-1 flex text-xs leading-5 text-gray-600 dark:text-gray-400">
              <span class="relative truncate">{{ $event->description }}</span>
            </p>
          </div>
        </div>
        <div class="flex shrink-0 items-center gap-x-4">
          <div class="hidden sm:flex sm:flex-col sm:items-end">
            <p class="text-sm leading-6 text-gray-800 dark:text-gray-200">{{ $event->location_type == "online" ? "Online" : $event->location }}</p>
            <div class="mt-1 text-xs leading-5 text-gray-700 dark:text-gray-300 flex">
                @if(\Carbon\Carbon::parse($event->start)->isPast())
                    {{ __("Started on :start_date at :start_time", ['start_date' => \Carbon\Carbon::parse($event->start)->format('d.m.Y'), 'start_time' => \Carbon\Carbon::parse($event->start)->format('H:i')])}}
                    <div class="flex grow-0 items-center">
                        <div class="flex-none rounded-full bg-emerald-500/20 p-1 ml-1">
                            <div class="h-1.5 w-1.5 rounded-full bg-emerald-500"></div>
                        </div>  
                    </div>
                @elseif(true)
                    {{ __("Starting on :start_date at :start_time", ['start_date' => \Carbon\Carbon::parse($event->start)->format('d.m.Y'), 'start_time' => \Carbon\Carbon::parse($event->start)->format('H:i')])}}
                @endif
            </div>  
          </div>
          <svg class="h-5 w-5 flex-none text-gray-600 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
          </svg>
        </div>
      </li>
    @endforeach
  </ul>