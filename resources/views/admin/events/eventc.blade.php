@extends('admin.layouts.main')
@slot('pageTitle', $pageTitle)
@section('content')
<script src="https://jsuites.net/v4/jsuites.js"></script>
<script src="https://jsuites.net/v4/jsuites.webcomponents.js"></script>
 
<link rel="stylesheet" href="https://jsuites.net/v4/jsuites.css" type="text/css" />

    <div class="bg-gray-700 rounded-lg text-white p-5 m-5">
        <h2 class="title-header-2">Nuevo evento: @isset($event->name) {{$event->name}} @endisset</h2>
        <form id="event-form" action="{{$postUrl}}" method="POST" enctype="multipart/form-data">
            @csrf
            <button type="submit" id="save-button" class="save-button mt-5 @if($event->slug != '') @endif invisible  rounded-lg font-medium bg-indigo-500 py-2 px-5  hover:bg-indigo-600 active:bg-indigo-700 transition ">
                Guardar Cambios
            </button>
            <input type="hidden" name="slug" value="{{$event->slug}}">
            <div id="editable-content" class="">
                <label for="event-name">Nombre del evento:</label>
                <input type="text" name="name"
                id="event-name"
                value="{{$event->name}}"
                placeholder="Nombre del evento (100 caracteres máximo)"
                class="mb-5 block w-full mt-1 text-sm rounded border-gray-600 bg-gray-700 focus:border-indigo-400 focus:outline-none focus:shadow-outline-indigo text-gray-300 focus:shadow-outline-gray form-input transition">
                
                <label for="event-description" class="mt-5">Descripción: </label>
                <textarea name="description" id="event-description"
                placeholder="Cuenta cómo va a ser tu evento. Máx: 6000 caracteres."
                class="mb-5 block w-full mt-1 text-sm rounded border-gray-600 bg-gray-700 focus:border-indigo-400 focus:outline-none focus:shadow-outline-indigo text-gray-300 focus:shadow-outline-gray form-input transition"
                >{{$event->description}}</textarea>

                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div>
                        <livewire:color-picker :defaultValue="$event->color">
                    </div>
                    <div>
                        <label class="" for="file_input">Póster</label>
                        <div id="event-poster-container" class="bg-gray-600 w-full py-2 rounded-lg border-gray-400 border-dashed border-2 text-center mb-2">
                            <img id="event-poster-image" src="{{$event->poster_url}}" alt="">
                        </div>
                        <input name="poster_img" id="imageInput" onchange="loadFile(event)" class="block w-full text-sm rounded-lg border transition cursor-pointer text-gray-400 focus:outline-none bg-gray-700 border-gray-600 dark:placeholder-gray-400" aria-describedby="file_input_help" id="file_input" type="file">
                    </div>
                </div>
                <label for="tags" class="">Etiquetas</label>
                    <input
                    id="tags"
                    type="text"
                    class="w-full customTags px-4 py-6 text-sm border border-gray-300 rounded outline-none "
                    name="tags"
                    value="{{$event->tags}}"
                    />
            </div>
            <div id="uneditable-content" class="">
                <div class="grid grid-cols-1 md:grid-cols-2 mt-5">
                    <div>
                        <label for="start_date_time">Fecha y hora de inicio</label>
                        <input id="start_date_time" @if($event->visible) readonly @endif name="start_date_time" class="ad-input !w-3/4" type="datetime-local" 
                        @if($event->slug != '') value="{{ \Carbon\Carbon::parse($event->start_datetime)->timezone($event->venue->timezone)}}" @endif>
                    </div>
                    <div>
                        <label for="end_date_time">Fecha y hora final</label>
                        <input id="end_date_time" @if($event->visible) readonly @endif name="end_date_time" class="ad-input !w-3/4" type="datetime-local" 
                        @if($event->slug != '') value="{{ \Carbon\Carbon::parse($event->end_datetime)->timezone($event->venue->timezone)}}" @endif>
                    </div>
                    <div>
                        <label data-tooltip-target="tooltip-default" for="">Aforo máximo del evento</label>
                        <div id="tooltip-default" role="tooltip" class="z-20 inline-block absolute invisible py-2 px-3 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 transition-opacity duration-300 tooltip dark:bg-gray-700">
                            Este numero afectará al número de entradas que puedes emitir
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                        <input type="number" class="!w-3/4" @if($event->visible) readonly @endif value="{{$event->max_capacity}}" name="max_capacity" min="0" max="99999" placeholder="Entre 1 y 99999">
                    </div>
                    <div>
                        <label for="age-limit">Edad mínima de asistencia</label>
                        <input type="number" class="!w-3/4" @if($event->visible) readonly @endif name="minimum_age" min="16" max="99" value="{{$event->minimum_age}}" placeholder="A partir de 16">
                    </div>
                    <div>
                        <label for="event-venue">Lugar del evento</label>
                        <select id="event-venue" name="venue_slug" class="border text-sm rounded-lg  block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 text-white focus:ring-blue-500 focus:border-blue-500">
                            @foreach (App\Models\Organization::find(auth()->guard('admin')->user()->organization_id)->venues as $venue)
                           @if($venue->visible)
                               @if ($event->venue_id == $venue->id) 
                                   <option selected value="{{$venue->slug}}" class="" >{{$venue->name}}</option>
                               @else
                               <option  @if($event->visible) disabled @endif value="{{$venue->slug}}" class="">{{$venue->name}}</option>
                               @endif
                           @endif
                            @endforeach
                          </select>
                    </div>
                </div>
                <button type="submit" id="save-button" class="save-button mt-5 @if($event->slug != '') @endif invisible  rounded-lg font-medium bg-indigo-500 py-2 px-5  hover:bg-indigo-600 active:bg-indigo-700 transition ">
                    Guardar Cambios
                </button>
            </div>
        </form>
        <!-- Entradas -->
        @if($event->slug != '')
        <h2 class="title-header-2">Entradas</h2>
        <div class="grid grid-cols-1 xl:grid-cols-2 2xl:grid-cols-3 gap-4">
            @foreach ($event->tickets as $ticket)
            <div class="rounded-lg bg-gray-900 p-5">
                <form action="{{url('admin/ticket/update')}}" method="get">
                    <input type="hidden" name="event_slug" value="{{$event->slug}}">
                    <input type="hidden" name="slug" value="{{$ticket->slug}}">
                <label for="ticket-name">Nombre de la entrada</label>
                <input id="ticket-name" 
                class="mb-5 block w-full mt-1 text-sm rounded border-gray-600 bg-gray-700 focus:border-indigo-400 focus:outline-none focus:shadow-outline-indigo text-gray-300 focus:shadow-outline-gray form-input transition" 
                name="name" type="text" value="{{$ticket->name}}" @if($event->visible) readonly @endif  placeholder="Nombre" >
                <label for="ticket-description">Condiciones</label>
                <textarea id="ticket-description" class="form-textarea rounded" 
                name="conditions" type="text" placeholder="Separadas por ;" @if($event->visible) readonly @endif
                >{{$ticket->conditions}}</textarea>
                <label for="time-limit">Límite horario de entrada</label>
                <div class="flex">
                    <div class="my-auto mr-2">
                        <input type="hidden" name="time_limit" value="0">
                        <livewire:toggle-switch :checked="$ticket->time_limit" :disabled="$event->visible"  ident="{{$ticket->slug}}_maxdt" name="time_limit" value="1">
                    </div>
                    <input type="datetime-local" 
                    min="{{ \Carbon\Carbon::parse($event->start_datetime)->timezone($event->venue->timezone)}}" 
                    max="{{ \Carbon\Carbon::parse($event->end_datetime)->timezone($event->venue->timezone)}}" 
                    class="w-5/6" name="max_datetime" 
                    @if($event->slug != '') value="{{ \Carbon\Carbon::parse($event->start_datetime)->timezone($event->venue->timezone)}}" @endif
                    @if($event->visible) readonly @endif>
                </div>
                <label for="event-price">Precio:</label>
                <div class="flex">
                    <input type="number" id="event-price" name="price" class="!w-5/6 " placeholder="0,00"
                    value="{{$ticket->price}}" @if($event->visible) readonly @endif>
                    <input type="hidden" value="{{$event->venue->currency}}" name="currency">
                    <span class="uppercase mx-auto align-middle">{{$event->venue->currency}}</span>
                </div>
                <div class="grid grid-cols-3">
                    <div>
                        <label for=""># de entradas</label>
                        <input id="tickets_quantity" type="number" name="quantity" min="1" class="!w-3/4"
                        value="{{$ticket->quantity}}" @if($event->visible) readonly @endif>
                    </div>
                    <div>
                        <label for="">personas/entrada</label>
                        <input id="people_per_ticket" type="number" name="people_per_ticket" min="1" class="!w-3/4"
                        value="{{$ticket->people_per_ticket}}" @if($event->visible) readonly @endif>
                    </div>
                    <div>
                        <div>Total:</div>
                        <div id="total_people">{{$ticket->quantity * $ticket->people_per_ticket}}</div>
                    </div>
                </div>
                <label for="">Entrada nominativa</label>
                    <div class="flex">
                        <input type="hidden" name="id_number_required" value="0">
                        <livewire:toggle-switch :checked="$ticket->id_number_required" :disabled="$event->visible" ident="{{$ticket->slug}}_idreq" name="id_number_required" value="1">
                    </div>
                    <div class="flex">
                        @if(!$event->visible)
                        <button type="submit" class="ml-auto rounded-lg font-medium bg-indigo-500 py-2 px-5  hover:bg-indigo-600 active:bg-indigo-700 transition ">
                            Guardar
                        </button>
                        @endif
                    </div>
            </form>
            @if(!$event->visible)
                <form action="{{url('admin/ticket/delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="slug" value="{{$ticket->slug}}">
                    <button type="submit" class="bg-red-600 p-2 rounded font-medium m-2">
                        Eliminar
                    </button>
                </form>
                @endif
            </div>                
            @endforeach
            @if(!$event->visible)
            <div class="rounded-lg bg-gray-800 p-5 border-4 border-dashed border-gray-400">
                <form action="{{url('admin/ticket/update')}}" method="get">
                    <input type="hidden" name="event_slug" value="{{$event->slug}}">
                <label for="ticket-name">Nombre de la entrada</label>
                <input id="ticket-name" 
                class="mb-5 block w-full mt-1 text-sm rounded border-gray-600 bg-gray-700 focus:border-indigo-400 focus:outline-none focus:shadow-outline-indigo text-gray-300 focus:shadow-outline-gray form-input transition" 
                name="name" type="text" placeholder="Nombre" >
                <label for="ticket-description">Condiciones</label>
                <textarea id="ticket-description" class="form-textarea rounded" name="conditions" type="text" placeholder="Separadas por ;" 
                ></textarea>
                <label for="time-limit">Límite horario de entrada</label>
                <div class="flex">
                    <div class="my-auto mr-2">
                        <input type="hidden" name="time_limit" value="0">
                        <livewire:toggle-switch ident="timelimit" name="time_limit" value="1    ">
                    </div>
                    <input type="datetime-local" min="{{ \Carbon\Carbon::parse($event->start_datetime)->timezone($event->venue->timezone)}}" max="{{ \Carbon\Carbon::parse($event->end_datetime)->timezone($event->venue->timezone)}}" class="w-5/6" name="max_datetime" >
                </div>
                <label for="event-price">Precio:</label>
                <div class="flex">
                    <input type="number" id="event-price" name="price" class="!w-5/6 " placeholder="0,00">
                    <input type="hidden" value="{{$event->venue->currency}}" name="currency">
                    <span class="uppercase mx-auto align-middle">{{$event->venue->currency}}</span>
                </div>
                <div class="grid grid-cols-3">
                    <div>
                        <label for=""># de entradas</label>
                        <input id="tickets_quantity" type="number" name="quantity" min="1" value="1" class="!w-3/4">
                    </div>
                    <div>
                        <label for="">personas/entrada</label>
                        <input id="people_per_ticket" type="number" name="people_per_ticket" value="1" min="1" class="!w-3/4">
                    </div>
                    <div>
                        <div>Total:</div>
                        <div id="total_people"></div>
                    </div>
                    <input type="hidden" name="id_number_required" value="0">
                    <label for="">Entrada nominativa</label>
                    <livewire:toggle-switch ident="idreq" name="id_number_required" value="1">
                    <button type="submit" class="rounded-lg font-medium bg-indigo-500 py-2 px-5  hover:bg-indigo-600 active:bg-indigo-700 transition ">
                        Guardar
                    </button>
                    
                </div>
            </form>
            </div>
            @endif
        </div>
        @endif
        <link href="https://cdn.jsdelivr.net/npm/daisyui@2.20.0/dist/full.css" rel="stylesheet" type="text/css" />

        <div class="flex">
            @if(!$event->visible && $event->slug != '')
            <a href="#my-modal-2" class="rounded ml-auto font-medium bg-indigo-500 py-2 px-5  hover:bg-indigo-600 active:bg-indigo-700 transition " type="button" data-modal-toggle="popup-modal">
            Publicar
            </a>
            <div class="modal" id="my-modal-2">
            <div class="modal-box bg-gray-900">
                <div class="flex">
                    <h3 class="mr-auto text-xl font-medium">Confirmar publicación</h3>
                    <a class="ml-auto" href="#!">
                        <span class="material-symbols-outlined">close</span>
                    </a>
                </div>
                <p class="py-4">Cuando publiques este evento no podrás editar los campos fundamentales.</p>
                <p>Los campos que podrás seguir editando son: Nombre, descripción, color y póster.</p>
                <div class="modal-action">
                    <form action="{{url('admin/event/publish')}}" method="POST">
                        @csrf
                        <input type="hidden" name="slug" value="{{$event->slug}}">
                            <button type="submit" class="text-white bg-indigo-600 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Sí, publicar
                        </button>
                    </form>
                </div>
            </div>
            </div>
          @endif
        </div>
<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet" />
<link href="https://unpkg.com/@yaireo/tagify/dist/tagify.css" rel="stylesheet"type="text/css"/>
<script src="https://unpkg.com/@yaireo/tagify"></script>
<script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<?php
        $path = storage_path() . "/app/public/json/tags.json"; // ie: /var/www/laravel/app/storage/json/filename.json
        $json = json_decode(file_get_contents($path), true);
        ?>
<script>

function showSaveButton(){
    $('.save-button').removeClass('invisible')
}
$('input', '#event-form').change(function() {
    showSaveButton()
})
$('input', '#event-form').keyup(function() {
    showSaveButton()
})
$('textarea', '#event-form').keyup(function() {
    showSaveButton()
})
function colorEdited(){
    showSaveButton()
}
function multiply(){
    var people = $('#tickets_quantity').val() * $('#people_per_ticket').val()
    $('#total_people').html(people)
}
$('#tickets_quantity').change(function() {
    multiply()
})
$('#people_per_ticket').change(function() {
    multiply()
})

// The DOM element you wish to replace with Tagify
var input = document.querySelector('input[name=tags]');
var tagify = new Tagify(input, {
addTagOnBlur: false,
dropdown: {
enabled: 0,
closeOnSelect: false,
classname: "customSuggestionsList"
},
userInput: false,
whitelist: [

@foreach($json['tags'] as $tag)
'{{$tag['name']}}',

@endforeach
],
templates: {
dropdownItem(item) {
return `<div ${this.getAttributes(item)}
class='tagify__dropdown__item ${item.class ? item.class : ''}'
tabindex="0"
role="option">
${item.value}
<button tabindex="0" data-value="${
item.value
}" class="ml-4 text-red-800">Remove</button>
</div>`;
},
},
hooks: {
suggestionClick(e) {
var isAction = e.target.classList.contains('removeBtn'),
suggestionElm = e.target.closest('.tagify__dropdown__item'),
value = suggestionElm.getAttribute('value');

return new Promise(function (resolve, reject) {
if (isAction) {
removeWhitelistItem(value);
tagify.dropdown.refilter.call(tagify);
reject();
}
resolve();
});
},
},
});

function removeWhitelistItem(value) {
var index = tagify.settings.whitelist.indexOf(value);
if (value && index > -1) tagify.settings.whitelist.splice(index, 1);
}
</script>

<script>
  var loadFile = function(event) {
    var output = document.getElementById('event-poster-image');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
  };
</script>
    </div>
@endsection