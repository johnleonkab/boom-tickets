@extends('admin.layouts.app')
@slot('pageTitle', $pageTitle)
@section('content')
<script src="https://unpkg.com/flowbite@1.4.7/dist/datepicker.js"></script>

<style>
    .red:hover{
        border-color:#BA274A; 
        background-color:#420816;
        box-shadow: #BA274A 0px 0px 10px;
    }
    .green:hover{
        border-color:#2da86b; 
        background-color:#00361b;
        box-shadow: #2da86b 0px 0px 10px
    }
    .blue:hover{
        border-color:#2f83b5; 
        background-color:#00304d;
        box-shadow: #2f83b5 0px 0px 10px
    }
    .purple:hover{
        border-color:#8d4aba; 
        background-color:#2a0047;
        box-shadow: #8d4aba 0px 0px 10px
    }
    .pink:hover{
        border-color:#db2abb; 
        background-color:#6e005a;
        box-shadow: #db2abb 0px 0px 10px
    }
</style>
<div class="text-white w-full md:w-5/6 lg:w-3/4 mx-auto">
    <div class="text-4xl font-lato font-light">@if($event->slug == '') Nuevo @endif  Evento: {{$event->name}}</div>
    <hr>
    
    <!-- Event card -->
    <div class="bg-gray-900 rounded-lg my-5 p-10">
        <form action="{{$postUrl}}" id="event-form" enctype="multipart/form-data" method="POST">
            @csrf
            <fieldset >
                <input type="hidden" name="slug" value="{{$event->slug}}">
                <div>
                    <input name="name" placeholder="Nombre del evento (100 caracteres máximo)" required 
                     type="text" value="{{$event->name}}" max="100"
                    class="input w-full">
                </div>
                <div class="mt-5">
                    <textarea name="description" id="" class="w-full bg-transparent focus:border-transparent h-32
                    focus:border-indigo-600 focus:ring-0 transition"
                    placeholder="Cuenta cómo va a ser tu evento. Máx: 100 caracteres.">{{$event->description}}</textarea>
                </div>

            <div class="flex">
                <div class="w-1/2">
                    <livewire:color-picker defaultValue="{{$event->color}}" defaultValueName="{{__('colors.'.$event->color)}}">
                </div>
                <div class="w-1/2">
                    

                    <div class="font-medium mb-2">Póster</div>
                    @if ($event->poster_url != "")
                        <img src="{{$event->poster_url}}" alt="">
                    @endif
                    <label class="block mb-2 text-sm font-medium  text-gray-300" for="file_input">Upload file</label>
                    <input name="poster_img" class="block w-full text-sm  rounded-lg border cursor-pointer text-gray-400 focus:outline-none bg-gray-700 border-gray-600 placeholder-gray-400" id="file_input" type="file">
                    
                </div>
            </div>
               
            @if ($event->visible)
            <div class="font-medium mt-10">
                Los siguientes campos no son editables cuando un evento es público.
            </div>
            @endif
                <div class="lg:flex w-full">
                    <div class="w-full mt-10">
                        <div class="font-medium">Fecha y hora de inicio del evento:</div>
                        <div class="flex w-full">
                                <input @if($event->visible) readonly @endif name="start_date_time" type="datetime-local" 
                                class="w-full md:w-1/2  input"  value="{{$event->start_datetime}}">
                        </div>
                    </div>
                    <div class="w-full mt-10">
                        <div class="font-medium">Fecha y hora de finaliación del evento:</div>
                        <div class="flex w-full">
                                <input @if($event->visible) readonly @endif name="end_date_time" type="datetime-local"  
                                class="w-full md:w-1/2  input"  value="{{$event->end_datetime}}">
                        </div>
                    </div>

                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <div class="mt-10">
                        <div class="font-medium">Aforo máximo (1-99999)</div>
                        <input @if($event->visible) readonly @endif type="number" name="max_capacity" 
                        class="input w-full md:w-1/2" value="{{$event->max_capacity}}">
                    </div>
                    <div class="mt-10">
                        <div class="font-medium">Lugar</div>
                        <select name="venue_slug" id="" class="input w-full md:w-1/2">
                           @foreach (App\Models\Organization::find(auth()->guard('admin')->user()->organization_id)->venues as $venue)
                           @if($venue->visible)
                               @if ($event->venue_id == $venue->id) 
                                   <option selected value="{{$venue->slug}}" class="bg-gray-900 font-light" >{{$venue->name}}</option>
                               @else
                               <option  @if($event->visible) disabled @endif value="{{$venue->slug}}" class="bg-gray-900 font-light">{{$venue->name}}</option>
                               @endif
                           @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-10 grid grid-cols-1 md:grid-cols-2">
                    <div>
                        <div class="font-medium">Edad mínima</div>
                        <input @if($event->visible) readonly @endif type="number" name="minimum_age" 
                        class="input w-full md:w-1/2" value="{{$event->minimum_age}}">
                    </div>
                    <div>
                        <div class="font-medium">Visible</div>
                        <input type="hidden" name="visible" value="0" />
                        <livewire:toggle-switch :checked="$event->visible" :disabled="$event->visible"  ident="event_visible" name="visible" value="1">
                    </div>
                </div>
                <div class="mt-10">
    <link
      href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css"
      rel="stylesheet"
    />
    <link
      href="https://unpkg.com/@yaireo/tagify/dist/tagify.css"
      rel="stylesheet"
      type="text/css"
    />
    <div class="flex items-center justify-center mt-20">
      <div class="w-1/2">
        <label for="Tags" class="block mb-2 text-sm text-gray-600">Tags</label>
        <input
          type="text"
          class="w-full customTags px-4 py-6 text-sm border border-gray-300 rounded outline-none "
          name="tags"
          value="{{$event->tags}}"
        />
      </div>
    </div>
    <script src="https://unpkg.com/@yaireo/tagify"></script>
    <script src="https://unpkg.com/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <?php
            $path = storage_path() . "/app/public/json/tags.json"; // ie: /var/www/laravel/app/storage/json/filename.json
            $json = json_decode(file_get_contents($path), true);
            ?>
    <script>
      // The DOM element you wish to replace with Tagify
      var input = document.querySelector('input[name=tags]');
      var tagify = new Tagify(input, {
        addTagOnBlur: false,
        dropdown: {
          enabled: 0,
          closeOnSelect: false,
          classname: "customSuggestionsList"
        },
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

                </div>
                <div class="font-medium my-3">
                    Notas:
                    <ul class="list-decimal ml-5">
                        <li>La fecha y hora del evento está sujeta a la zona horaria del lugar. </li>
                        <li>Un evento no se podrá editar al completo si se marca la opción de público.</li>
                    </ul>
                </div>
            </fieldset>
            <div class="text-right my-10">
                <button type="submit" id="save-button" class="@if($event->slug != '') invisible @endif font-medium bg-indigo-500 py-2 px-5  hover:bg-indigo-600 active:bg-indigo-700 transition ">
                    Guardar Cambios
                </button>
                
            </div>
        </form>

        @if(!$event->visible)
        <button class="font-medium bg-indigo-500 py-2 px-5  hover:bg-indigo-600 active:bg-indigo-700 transition " type="button" data-modal-toggle="popup-modal">
            Publicar
          </button>
          
          <div id="popup-modal" tabindex="-1" class=" hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
              <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                  <div class="relative rounded-lg shadow bg-gray-700">
                      <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-gray-800 hover:text-white" data-modal-toggle="popup-modal">
                          <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                          <span class="sr-only">Close modal</span>
                      </button>
                      <div class="p-6 text-center">
                          <svg aria-hidden="true" class="mx-auto mb-4 w-14 h-14 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                          <h3 class="mb-5 text-lg font-normal text-gray-400">¿Estás seguro de publicar este evento? 
                            Una vez sea público no podrás editar ni la información crucial del evento.</h3>
                          <button data-modal-toggle="popup-modal" type="button" class=" focus:ring-4 focus:outline-none  rounded-lg border text-sm font-medium px-5 py-2.5  focus:z-10 bg-gray-700 text-gray-300 border-gray-500 hover:text-white hover:bg-gray-600 focus:ring-gray-600">No, cancel</button>
                          <form action="{{url('admin/event/publish')}}">
                        <input type="hidden" name="slug" value="{{$event->slug}}">
                            <button type="submit" class="text-white bg-indigo-600 hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                            Sí, publicar
                        </button>
                    </form>
                        </div>
                  </div>
              </div>
          </div>
          @endif
    </div>

    <!-- Tickets card -->
    @if($event->slug != '')
    <div class="bg-black my-5 p-10">
        <div class="text-2xl font-light">Entradas</div>
        <hr>
        <div class="overflow-x-auto">
            <style>
                td{
                    padding-right: 5px;
                    padding-left: 5px;
                }
            </style>
            <table class="w-full ">
                <tr class="font-medium text-lg">
                    <td>Nombre</td>
                    <td>Condiciones</td>
                    <td>Precio</td>
                    <td>Moneda</td>
                    <td>Cantidad</td>
                    <td>Personas por entrada</td>
                    <td>Personas</td>
                    <td>Hora máxima de entrada</td>
                    <td>Nominativa</td>
                    <td></td>
                </tr>
                @foreach ($event->tickets as $ticket)
                <form action="{{url('admin/ticket/update')}}" id="ticketform-{{$ticket->slug}}">
                    <input type="hidden" name="event_slug" value="{{$event->slug}}">
                    <input type="hidden" name="slug" value="{{$ticket->slug}}">
                    <tr class="border-b border-gray-700">
                        <td class="py-4">
                            <input name="name" @if($event->visible) readonly @endif placeholder="Nombre de la entrada (100 caracteres máximo)" required 
                             type="text" value="{{$ticket->name}}" max="100"
                            class="input">
                        </td>
                        <td class="py-4">
                            <textarea class="input" name="conditions" @if($event->visible) readonly @endif 
                                placeholder="Condiciones de la entrada separados por ; (2 consumiciones; camisa).  máx:100 caracteres. " required
                                >{{$ticket->conditions}}</textarea>
                        </td>
                        <td class="py-4">
                            <input  @if($event->visible) readonly @endif type="number" name="price" 
                            class="font-light bg-transparent border-transparent border-b-gray-600 focus:outline-black w-20 focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition" value="{{$ticket->price}}">
                        </td>
                        <td class="py-4">
                            <select name="currency" class="input" id="" readonly>
                                <option  @if($ticket->currency == 'eur') selected @endif value="eur">€</option>
                                <option  @if($ticket->currency == 'usd') selected @endif value="usd">$</option>
                            </select>
                        </td>
                        <td class="py-4">
                            <input  @if($event->visible) readonly @endif type="number" name="quantity" 
                            class="font-light bg-transparent border-transparent border-b-gray-600 focus:outline-black w-20 focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition" value="{{$ticket->quantity}}">
                        </td>
                        <td class="py-4">
                            <input  type="number" name="people_per_ticket" value="{{$ticket->people_per_ticket}}" 
                            class="font-light bg-transparent border-transparent border-b-gray-600 focus:outline-black w-20 focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition" >
                        </td>
                        <td><!-- personas--></td>
                        <td class="py-4 flex">
                            <input type="hidden" name="time_limit" value="0">
                            <div class="align-middle"><livewire:toggle-switch :checked="$ticket->time_limit" :disabled="$event->visible" ident="{{$ticket->slug}}_maxdt" name="time_limit" value="1"></div>
                            <input type="datetime-local" name="max_datetime" value="{{ \Carbon\Carbon::parse($ticket->max_datetime)->timezone('Europe/Madrid')->format('Y-m-d H:i') }}" class="font-light bg-transparent border-transparent border-b-gray-600 focus:outline-black focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition">
                        </td>
                        <td class="py-4">
                            <input type="hidden" name="id_number_required" value="0">
                            <livewire:toggle-switch :checked="$ticket->id_number_required" :disabled="$event->visible" ident="{{$ticket->slug}}_idreq" name="id_number_required" value="1">
                        </td>
                    </form>
                        <td>
                            @if ($event->visible && $event->visible)
                                @component('admin.components.dropwdown')
                                    @slot('idname', $ticket->slug)
                                    @slot('name', 'Opciones')
                                    @slot('options')
                                    <li>
                                        <a href="#" class="block px-4 py-2  hover:bg-gray-600 text-white transition">Analiticas</a>
                                    </li>
                                    @endslot
                                @endcomponent                        
                            
                            @else

                                @component('admin.components.dropwdown')
                                    @slot('idname', $ticket->slug)
                                    @slot('name', 'Opciones')
                                    @slot('options')
                                    <li>
                                        <button type="submit" class="block px-4 py-2  hover:bg-gray-600 text-white transition w-full text-justify"
                                        onclick="document.getElementById('ticketform-{{$ticket->slug}}').submit()">Guardar</button>
                                    </li>
                                    <li>
                                        <form action="{{url('admin/ticket/delete')}}">
                                            <input type="hidden" name="slug" value="{{$ticket->slug}}">
                                            <button type="submit" class="block px-4 py-2  bg-red-600 hover:bg-red-700 text-white transition w-full text-justify">Eliminar</button>
                                        </form>
                                    </li>
                                    @endslot
                                @endcomponent
                            @endif
                        </td>
        
                    </tr>
                
                
                @endforeach
                <form action="{{url('admin/ticket/new')}}">
                    <input type="hidden" name="event_slug" value="{{$event->slug}}">
                    <tr class="border-b border-gray-700">
                        <td class="py-4">
                            <input name="name" placeholder="Nombre de la entrada (100 caracteres máximo)" required 
                             type="text" value="" max="100"
                            class=" bg-transparent border-transparent border-b-gray-600 focus:outline-black  focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition">
                        </td>
                        <td class="py-4">
                            <input name="conditions" placeholder="Condiciones de la entrada separados por ; (2 consumiciones; camisa).  máx:100 caracteres. " required 
                             type="text"
                            class=" bg-transparent border-transparent border-b-gray-600 focus:outline-black  focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition">
                        </td>
                        <td class="py-4">
                            <input  type="number" name="price" 
                            class="font-light bg-transparent border-transparent border-b-gray-600 focus:outline-black w-20 focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition" >
                        </td>
                        <td>
                            <select name="currency" class="input" id="" readonly>
                                <option @if($event->venue->currency == 'eur') selected @endif value="eur">€</option>
                                <option @if($event->venue->currency == 'usd') selected @endif value="usd">$</option>
                            </select>
                        </td>
                        <td class="py-4">
                            <input  type="number" name="quantity" 
                            class="font-light bg-transparent border-transparent border-b-gray-600 focus:outline-black w-20 focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition" >
                        </td>
                        <td class="py-4">
                            <input  type="number" name="people_per_ticket" value="1" 
                            class="font-light bg-transparent border-transparent border-b-gray-600 focus:outline-black w-20 focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition" >
                        </td>
                        <td></td>
                        <td class="py-4 flex">
                            <input type="hidden" name="time_limit" value="0">
                            <div><livewire:toggle-switch   ident="maxdt" name="time_limit" value="1"></div>
                            <input type="datetime-local" name="max_datetime"  class="font-light bg-transparent border-transparent border-b-gray-600 focus:outline-black focus:border-transparent 
                            focus:border-b-indigo-600 focus:ring-0 transition">
                        </td>
                        <td class="py-4">
                            <input type="hidden" name="id_number_required" value="0">
                            <livewire:toggle-switch ident="idreq" name="id_number_required" value="1">
                        </td>
                        <td>
                            <button type="submit" class="transition text-white bg-indigo-700 hover:bg-indigo-800 focus:outline-none font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center " type="button">
                                Guardar
                            </button>
                        </td>
        
                    </tr>
                </form>
            </table>
        </div>
    </div>
    @endif

</div>
  <script>

function showSaveButton(){
    $('#save-button').removeClass('invisible')
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
  </script>

@endsection