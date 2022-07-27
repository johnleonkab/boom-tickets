@extends('layouts.main')
@section('content')
<style>
    .blur-image{
        background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{$event->poster_url}}');
        height: 100%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;

/* Add the blur effect */
filter: blur(15px);
-webkit-filter: blur(15px);

    }
</style>
<div class="blur-image fixed top-0 w-screen h-sreen"></div>

<section class="mt-40 pb-40">
    <div class="absolute left-1/2 -translate-x-1/2 border border-{{$event->color}}  md:bg-black md:bg-opacity-50 w-full md:w-3/4 mx-auto rounded-lg text-white ">
        <img src="{{$event->poster_url}}" class=" block lg:hidden w-full" alt="">

        <div class="md:flex p-5">
            <h1 id="event-name" class="font-light text-4xl">{{$event->name}}</h1>
            <div class="ml-auto">
                <livewire:dynamic-follow-button containerId="follow-button-{{$event->slug}}" targetType="event" :targetId="$event->id" :targetSlug="$event->slug">
            </div>
        <hr>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-3">
            <div>
                <img src="{{$event->poster_url}}" class="p-5 hidden lg:block" alt="">
            </div>
            <div class="md:col-span-2 p-5 align-middle">
                <div id="event-description" class="font-medium">
                    {{$event->description}}
                </div>
                <div class="my-10 flex">
                    <a href="{{url('venue/'.$event->venue->slug)}}" class="rounded-lg p-3 align-middle font-medium transition {{$event->color}}">
                        <span class="material-symbols-outlined align-middle">
                            pin_drop
                            </span>
                            {{$event->venue->name}}
                    </a>
                </div>
               
                <div class="border-l px-2 py-2 mt-10">
                    
                        @php
                            $array = explode(',', $event->tags);
                            $path = storage_path() . "/app/public/json/tags.json";
                            $json = json_decode(file_get_contents($path), true);
                        @endphp
                        @if(!empty($array))
                            @foreach ($array as $tag)
                            <div class="align-middle font-medium text-gray-300 my-2">
                                <span class="material-symbols-outlined mr-3 align-middle">
                                    {{$json['icons'][$tag]}}
                                </span>
                                {{$tag}}
                            </div>
                            @endforeach
                        @endif
                </div>
                <div class="flex align-middle mt-5">
                    <span class="material-symbols-outlined mr-3 align-middle my-auto text-3xl">event</span>
                    <div class="uppercase font-medium text-right align-middle">
                        <div class="align-middle">{!! App\Http\Controllers\DateController::EventDates($event->start_datetime, $event->end_datetime)!!}</div>
                    </div>
                    <div class="text-2xl font-thin mx-4 align-middle my-auto">
                        Quedan: <span id="timer"></span>
                    </div>
                </div>

            </div>
        </div>
        <div class="p-4">
            <h4 class="text-2xl">Entradas</h4>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-5">
            @if ($event->tickets->where('visible', true)->count() == 0)
                <div class="bg-gray-700 p-5 text-center col-span-5">
                    Parece que no han salido entradas para este evento aun.
                </div>
            @endif
            @foreach ($event->tickets->where('visible', true) as $ticket)
            <div class="ticket border-{{$event->color}}-neon flex flex-col">
                <div class="px-3 py-3">
                    <span class="font-medium font-lato text-xl mb-10 uppercase">{{$ticket->name}}</span>
                </div>
                <div> 
                    <hr>
                <div class="py-3">
                    <ul class="list-disc ml-5">
                        @php
                            $conditions = explode (';', $ticket->conditions)
                        @endphp
                        @foreach ($conditions as $condition)
                            <li>{{$condition}}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="text-center font-medium mt-10">
                    <span class="text-4xl">{{$ticket->price}}</span>
                    <span class="text-xl">€</span>
                </div>
                <div class="my-10 text-center">
                    <button class="buy-button">
                        <span class="material-symbols-outlined mr-2">
                            confirmation_number    
                        </span> 
                        Comprar</button>
                </div>
                <div>
                    @if($ticket->id_number_required)
                        <span class="text-gray-500">
                            <span class="material-symbols-outlined font-bold align-middle">
                                info
                                </span>
                                Se requiere DNI
                        </span>
                    @endif
                </div>
                </div>
                <div class="flex flex-wrap mt-auto h-5">
                    <img class="h-full" src="{{asset('images/logo BT sq.png')}} " alt="">
                    <span class="text-gray-600">BoomTickets 2022</span>
                </div>
            </div>
            @endforeach
        </div>
                    <script src="https://raw.githubusercontent.com/mckamey/countdownjs/master/countdown.js"></script>
<script>
// Set the date we're counting down to
var countDownDate = new Date("{{App\Http\Controllers\DateController::GetDate($event->start_datetime, 'shortYmd')}}").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));

  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
  if(days > 1){
    document.getElementById("timer").innerHTML = days+ " días."
  }else{
    document.getElementById("timer").innerHTML = hours + ":"
  + minutes + ":" + seconds ;
  }
if(distance/(1000*60*60) < 24){
    $('#timer').addClass('text-red-500')
}
  // If the count down is finished, write some text
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo").innerHTML = "EXPIRED";
  }
}, 1000);
</script>
                           
                
            
    </div>
    
</section>
@endsection