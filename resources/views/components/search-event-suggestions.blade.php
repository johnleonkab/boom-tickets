@php
                        \Carbon\Carbon::setLocale('es');
                    @endphp
@foreach ($events as $event)
<button onclick="window.location.href='{{url('event/'.$event->slug)}}'" class="suggested-result hover:bg-indigo-500 hover:bg-opacity-50 transition w-full px-3 py-2 font-medium text-justify my-1 grid grid-cols-6 gap-2">
    <div>
      <img class="max-h-24" src="@if($event->poster_url != '') {{$event->poster_url}} @else {{$event->venue->log_url}} @endif" alt="">
    </div>
    <div class="col-span-5">
      <h5>{{$event->name}}</h5>
  <small>En {{$event->venue->name}} - {{ \Carbon\Carbon::parse($event->start_datetime)->translatedFormat('l d \d\e F') }} </small>
  <div class="flex">
    @if(!$event->tickets->isEmpty())
        @foreach ($event->tickets as $ticket)
            <span class="rounded-lg bg-transparent border-2 border-x-white px-2 py-1 mx-2">
                {{$ticket->name}} | {{$ticket->price}} €
            </span>
        @endforeach
  @endif
  </div>
    </div>
  </button>
@endforeach



