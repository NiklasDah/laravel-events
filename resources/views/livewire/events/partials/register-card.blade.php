<div>
@if(!$event->enrolled->contains(auth()->user()) && $event->organizer->id != auth()->user()->id)
<div class="lg:col-start-3 lg:row-end-1">
    <div class="rounded-lg bg-gray-50 dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-50/5">
      <dl class="flex flex-wrap">
        <div class="flex-auto pl-6 pt-6">
          <dt class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-100">{{ __('Register') }}</dt>
          <dd class="mt-1 text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">{{ __('for event :event_name', ['event_name' => $event->name]) }}</dd>
        </div>
        <div class="mt-4 flex w-full flex-none gap-x-4 px-6 pt-6 border-t dark:border-gray-50/5 border-gray-900/5">
          <dt class="flex-none">
            <span class="sr-only">{{ __('Event Date')}}</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="h-6 w-5 text-gray-400 dark:text-gray-200">
                <path strokeLinecap="round" strokeLinejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
              </svg>
          </dt>
          <dd class="text-sm leading-6 text-gray-500 dark:text-gray-300">
            <p>                    
                {{ __(":start_date at :start_time until :end_date at :end_time", ['start_date' => \Carbon\Carbon::parse($event->start)->format('d.m.Y'), 'start_time' => \Carbon\Carbon::parse($event->start)->format('H:i'), 'end_date' => \Carbon\Carbon::parse($event->end)->format('d.m.Y'), 'end_time' => \Carbon\Carbon::parse($event->end)->format('H:i')])}}
            </p>
          </dd>
        </div>
        <div class="mt-4 flex w-full flex-none gap-x-4 px-6">
            <dt class="flex-none">
              <span class="sr-only">{{ __('Event Location')}}</span>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="h-6 w-5 text-gray-400 dark:text-gray-200">
                <path strokeLinecap="round" strokeLinejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                <path strokeLinecap="round" strokeLinejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
              </svg>              
            </dt>
            <dd class="text-sm leading-6 text-gray-500 dark:text-gray-300">
              <p>                    
                @if($event->location_type != 'online')
                    {{ $event->location }}
                @else
                    {{ __("Online") }}
                @endif
                </p>
            </dd>
          </div>
      </dl>
      <div class="mt-6 border-t dark:border-gray-50/5 border-gray-900/5 px-6 py-6">
        @if($event->percentageFilled() < 100)
            <span wire:click="enroll" class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-100 hover:underline hover:cursor-pointer">{{ __('Register') }} <span aria-hidden="true">&rarr;</span></span>
        @else
            <span wire:click="enroll" class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-100 hover:underline hover:cursor-pointer">{{ __('Register for queue') }} <span aria-hidden="true">&rarr;</span></span>
        @endif
      </div>
    </div>
  </div>
@elseif($event->organizer->id != auth()->user()->id)
<div class="lg:col-start-3 lg:row-end-1">
    <div class="rounded-lg bg-gray-50 dark:bg-gray-900 shadow-sm ring-1 ring-gray-900/5 dark:ring-gray-50/5">
      <dl class="flex flex-wrap">
        <div class="flex-auto pl-6 pt-6">
          <dt class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-100">{{ __('Registration details') }}</dt>
          <dd class="mt-1 text-base font-semibold leading-6 text-gray-900 dark:text-gray-100">{{ __('for event :event_name', ['event_name' => $event->name]) }}</dd>
        </div>
        <div class="mt-4 flex justify-center items-center w-full relative flex-none gap-x-4 px-6 pt-6 border-t dark:border-gray-50/5 border-gray-900/5">
            {{ QrCode::size(200)->generate($event->attendants->find(auth()->user()->id)->pivot->registration_number) }}
        </div>
        <div class="mt-4 flex w-full flex-none gap-x-4 px-6 pt-6 border-t dark:border-gray-50/5 border-gray-900/5">
          <dt class="flex-none">
            <span class="sr-only">{{ __('Event Date')}}</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="h-6 w-5 text-gray-400 dark:text-gray-200">
                <path strokeLinecap="round" strokeLinejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
              </svg>
          </dt>
          <dd class="text-sm leading-6 text-gray-500 dark:text-gray-300">
            <p>                    
                {{ __(":start_date at :start_time until :end_date at :end_time", ['start_date' => \Carbon\Carbon::parse($event->start)->format('d.m.Y'), 'start_time' => \Carbon\Carbon::parse($event->start)->format('H:i'), 'end_date' => \Carbon\Carbon::parse($event->end)->format('d.m.Y'), 'end_time' => \Carbon\Carbon::parse($event->end)->format('H:i')])}}
            </p>
          </dd>
        </div>
        <div class="mt-4 flex w-full flex-none gap-x-4 px-6">
            <dt class="flex-none">
              <span class="sr-only">{{ __('Event Location')}}</span>
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="h-6 w-5 text-gray-400 dark:text-gray-200">
                <path strokeLinecap="round" strokeLinejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                <path strokeLinecap="round" strokeLinejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
              </svg>              
            </dt>
            <dd class="text-sm leading-6 text-gray-500 dark:text-gray-300">
                <p>                    
                @if($event->location_type != 'online')
                    {{ $event->location }}
                @elseif($event->started() && $event->attendants->contains(auth()->user()))
                    <a href={{ $event->location }} class="underline">{{ __("Online") }}</a>
                @elseif(!$event->attendants->contains(auth()->user()))
                @if($event->queued->contains(auth()->user()))
                    {{ __("Online, you are in queue") }}
                @else
                    {{ __("Online, :queued in queue", ['queued' => $event->queued->count()]) }}
                @endif
                @else
                    {{ __("Online, link will be provided 15 Minutes before the event starts") }} 
                @endif
                </p>
            </dd>
          </div>
      </dl>
      <div class="mt-6 border-t dark:border-gray-50/5 border-gray-900/5 px-6 py-6">
        @if(!$event->started())
            <span wire:click="unenroll" class="text-sm font-semibold leading-6 text-gray-900 dark:text-gray-100 hover:underline hover:cursor-pointer">{{ __('Deregister') }} <span aria-hidden="true">&rarr;</span></span>
        @elseif($event->attendants->contains(auth()->user()))
            <span>{{ __("Event has already started, you are able to attend") }}</span>
        @elseif(!$event->attendants->contains(auth()->user()))
            <span>{{ __("Event has already started, you are unable to attend") }}</span>
        @endif
        </div>
    </div>
  </div>
@else
<div class="dark:bg-gray-900 px-6 py-2 rounded">
    <a href="{{ route('scanner', ['event' => $event]) }}" class="rounded w-full dark:bg-gray-800 bg-gray-50 p-2 flex align-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" class="w-6 h-6">
            <path strokeLinecap="round" strokeLinejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
            <path strokeLinecap="round" strokeLinejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
          </svg>          
        </a>
    <ul role="list" class="divide-y divide-gray-800">
    @foreach($event->enrolled as $enrolled)
    <li v-for="person in people" :key="person.email" class="flex justify-between gap-x-4 py-5">
      <div class="min-w-0 grow-0">
        <p class="text-sm font-semibold leading-6 dark:text-gray-100 text-gray-900">{{ $enrolled->name }}</p>
        <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ $enrolled->email }}</p>
        <p class="text-xs text-gray-400">{{ $enrolled->pivot->confirmed ? __("confirmed") : __("not confirmed") }}{{ $enrolled->pivot->in_queue ? ", ".__("in queue") : "" }}</p>
      </div>
      @if(!$enrolled->pivot->attended)
        <p wire:click="confirm_attendance({{ $enrolled }})" class="cursor-pointer grow-0 rounded-full bg-white px-2.5 py-1 text-xs font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 h-fit">{{ __('Override attendance') }}</p>
      @else
        <p class="grow-0 rounded-full bg-green-500 px-2.5 py-1 text-xs font-semibold text-white shadow-sm ring-1 ring-inset ring-green-300 h-fit">{{ __('attended') }} <span class="cursor-pointer" wire:click="remove_attendance({{ $enrolled }})">x</span></p>
      @endif
    </li>
    @endforeach
  </ul>
</div>
@endif
</div>